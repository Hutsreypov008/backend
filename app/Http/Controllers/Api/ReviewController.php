<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function index(Product $product)
    {
        $reviews = $product->reviews()
            ->with('user:id,name')
            ->latest()
            ->get();

        // Check which reviewers have actually purchased this product
        if ($reviews->isNotEmpty()) {
            $reviewUserIds = $reviews->pluck('user_id')->unique();

            $purchasedUserIds = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->whereIn('orders.user_id', $reviewUserIds)
                ->where('order_items.product_id', $product->id)
                ->pluck('orders.user_id')
                ->unique();

            $reviews->each(function ($review) use ($purchasedUserIds) {
                $review->purchased = $purchasedUserIds->contains($review->user_id);
            });
        }

        return response()->json($reviews);
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'product_id' => $product->id,
            ],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        $review->load('user:id,name');

        return response()->json([
            'message' => 'Review saved successfully.',
            'review' => $review,
        ], 201);
    }
}
