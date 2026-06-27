<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Show all cart items for the logged-in user.
    public function index(Request $request)
    {
        $cartItems = Cart::with('product.category')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json($cartItems);
    }

    // Add a product to the logged-in user's cart.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $product = Product::findOrFail($validated['product_id']);

        $cart = Cart::where('user_id', $request->user()->id)
            ->where('product_id', $validated['product_id'])
            ->first();

        $newQuantity = $cart
            ? $cart->quantity + $validated['quantity']
            : $validated['quantity'];

        if ($newQuantity > $product->stock) {
            return response()->json([
                'message' => 'Not enough stock available.',
                'available_stock' => $product->stock,
            ], 422);
        }

        if ($cart) {
            // If the product already exists in the cart, increase the quantity.
            $cart->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            // If the product is not in the cart yet, create a new cart item.
            $cart = Cart::create([
                'user_id' => $request->user()->id,
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
            ]);
        }

        $cart->load('product.category');

        return response()->json([
            'message' => 'Product added to cart.',
            'cart' => $cart,
        ], 201);
    }

    // Update the quantity of one product in the logged-in user's cart.
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validated['quantity'] > $product->stock) {
            return response()->json([
                'message' => 'Not enough stock available.',
                'available_stock' => $product->stock,
            ], 422);
        }

        $cart = Cart::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->firstOrFail();

        $cart->update([
            'quantity' => $validated['quantity'],
        ]);

        $cart->load('product.category');

        return response()->json([
            'message' => 'Cart updated.',
            'cart' => $cart,
        ]);
    }

    // Remove one product from the logged-in user's cart.
    public function destroy(Request $request, Product $product)
    {
        Cart::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->delete();

        return response()->json([
            'message' => 'Product removed from cart.',
        ]);
    }

    public function destroyBatch(Request $request)
    {
        $validated = $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'required|exists:products,id',
        ]);

        $count = Cart::where('user_id', $request->user()->id)
            ->whereIn('product_id', $validated['product_ids'])
            ->delete();

        return response()->json([
            'message' => "{$count} item(s) removed from cart.",
            'count' => $count,
        ]);
    }
}
