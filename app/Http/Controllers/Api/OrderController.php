<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SpinReward;
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
            'coupon_code' => 'nullable|string|max:20',
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

        // Validate coupon code if provided
        $discountPercent = 0;
        $appliedCouponCode = null;

        if (!empty($validated['coupon_code'])) {
            $reward = SpinReward::where('coupon_code', $validated['coupon_code'])
                ->where('user_id', $user->id)
                ->first();

            if (!$reward) {
                return response()->json([
                    'message' => 'Invalid coupon code.',
                ], 422);
            }

            if (!$reward->isValid()) {
                $reason = $reward->is_used ? 'already been used' : 'expired';
                return response()->json([
                    'message' => "This coupon has {$reason}.",
                ], 422);
            }

            $discountPercent = (float) $reward->discount_percent;
            $appliedCouponCode = $reward->coupon_code;
        }

        $order = DB::transaction(function () use ($validated, $user, $cartItems, $discountPercent, $appliedCouponCode) {
            $subtotal = 0;

            foreach ($cartItems as $cartItem) {
                $subtotal += $cartItem->product->price * $cartItem->quantity;
            }

            // Calculate discount amount
            $discountAmount = $discountPercent > 0
                ? round($subtotal * ($discountPercent / 100), 2)
                : 0;

            $totalAmount = $subtotal - $discountAmount;

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => max($totalAmount, 0),
                'discount_amount' => $discountAmount,
                'coupon_code' => $appliedCouponCode,
                'status' => 'pending',
                'shipping_name' => $validated['shipping_name'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
            ]);

            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                $itemSubtotal = $product->price * $cartItem->quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $itemSubtotal,
                ]);

                $product->update([
                    'stock' => $product->stock - $cartItem->quantity,
                ]);
            }

            Cart::where('user_id', $user->id)->delete();

            // Mark the spin reward as used
            if ($appliedCouponCode) {
                SpinReward::where('coupon_code', $appliedCouponCode)
                    ->update([
                        'is_used' => true,
                        'used_at' => now(),
                    ]);
            }

            // Create an admin notification for the new order
            Notification::create([
                'type' => 'new_order',
                'data' => [
                    'order_id' => $order->id,
                    'total_amount' => $totalAmount,
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'discount_amount' => $discountAmount,
                    'coupon_code' => $appliedCouponCode,
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
