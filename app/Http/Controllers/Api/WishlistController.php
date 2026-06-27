<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $wishlists = Wishlist::with('product.category')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get()
            ->map(function (Wishlist $wishlist) {
                $product = $wishlist->product;

                return [
                    'id' => $wishlist->id,
                    'user_id' => $wishlist->user_id,
                    'product_id' => $wishlist->product_id,
                    'created_at' => $wishlist->created_at,
                    'updated_at' => $wishlist->updated_at,
                    'product' => $product ? [
                        'id' => $product->id,
                        'category_id' => $product->category_id,
                        'category' => $product->category,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'stock' => $product->stock,
                        'image' => $product->image,
                        'image_url' => $product->image
                            ? asset('storage/' . ltrim($product->image, '/'))
                            : null,
                        'created_at' => $product->created_at,
                        'updated_at' => $product->updated_at,
                    ] : null,
                ];
            });

        return response()->json($wishlists);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlist = Wishlist::firstOrCreate([
            'user_id' => $request->user()->id,
            'product_id' => $validated['product_id'],
        ]);

        $wishlist->load('product.category');

        $product = $wishlist->product;

        return response()->json([
            'message' => 'Product added to wishlist.',
            'wishlist' => [
                'id' => $wishlist->id,
                'user_id' => $wishlist->user_id,
                'product_id' => $wishlist->product_id,
                'created_at' => $wishlist->created_at,
                'updated_at' => $wishlist->updated_at,
                'product' => $product ? [
                    'id' => $product->id,
                    'category_id' => $product->category_id,
                    'category' => $product->category,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'image' => $product->image,
                    'image_url' => $product->image
                        ? asset('storage/' . ltrim($product->image, '/'))
                        : null,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                ] : null,
            ],
        ], 201);
    }

    public function destroy(Request $request, Product $product)
    {
        Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->delete();

        return response()->json([
            'message' => 'Product removed from wishlist.',
        ]);
    }

    public function destroyBatch(Request $request)
    {
        $validated = $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'required|exists:products,id',
        ]);

        $count = Wishlist::where('user_id', $request->user()->id)
            ->whereIn('product_id', $validated['product_ids'])
            ->delete();

        return response()->json([
            'message' => "{$count} item(s) removed from wishlist.",
            'count' => $count,
        ]);
    }
}
