<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('items.product')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json($orders);
    }

    public function show(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403, 'You cannot view this order.');
        }

        $order->load('items.product');

        return response()->json($order);
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string',
        ]);

        $user = $request->user();

        $cartItems = Cart::with('product')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'message' => 'Cart is empty.',
            ], 422);
        }

        foreach ($cartItems as $cartItem) {
            if ($cartItem->quantity > $cartItem->product->stock) {
                return response()->json([
                    'message' => 'Not enough stock for ' . $cartItem->product->name,
                    'available_stock' => $cartItem->product->stock,
                ], 422);
            }
        }

        $order = DB::transaction(function () use ($validated, $user, $cartItems) {
            $totalAmount = 0;

            foreach ($cartItems as $cartItem) {
                $totalAmount += $cartItem->product->price * $cartItem->quantity;
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'shipping_name' => $validated['shipping_name'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
            ]);

            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                $subtotal = $product->price * $cartItem->quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $subtotal,
                ]);

                $product->update([
                    'stock' => $product->stock - $cartItem->quantity,
                ]);
            }

            Cart::where('user_id', $user->id)->delete();

            // Create an admin notification for the new order
            Notification::create([
                'type' => 'new_order',
                'data' => [
                    'order_id' => $order->id,
                    'total_amount' => $totalAmount,
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                ],
            ]);

            return $order->load('items.product');
        });

        return response()->json([
            'message' => 'Checkout successful.',
            'order' => $order,
        ], 201);
    }
}
