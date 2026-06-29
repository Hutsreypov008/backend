<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user:id,name,email', 'product:id,name,image'])
            ->latest()
            ->get();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function latest(Request $request)
    {
        $after = $request->input('after');

        $query = Review::with(['user:id,name,email', 'product:id,name,image'])
            ->latest();

        if ($after) {
            $query->where('created_at', '>', $after);
        }

        $reviews = $query->get();

        return response()->json([
            'count' => $reviews->count(),
            'reviews' => $reviews->map(function ($review) {
                $reviewerName = $review->user->name ?? 'Deleted User';
                return [
                    'id' => $review->id,
                    'reviewer_name' => $reviewerName,
                    'reviewer_email' => $review->user->email ?? '',
                    'reviewer_initial' => strtoupper(substr($reviewerName, 0, 1)),
                    'product_name' => $review->product ? $review->product->name : 'Deleted Product',
                    'product_image' => $review->product && $review->product->image
                        ? asset('storage/' . ltrim($review->product->image, '/'))
                        : null,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'comment_preview' => $review->comment
                        ? (strlen($review->comment) > 80 ? mb_substr($review->comment, 0, 80) . '...' : $review->comment)
                        : null,
                    'created_at' => $review->created_at->format('M d, Y \\a\\t g:i A'),
                    'created_at_raw' => $review->created_at->toIso8601String(),
                ];
            }),
            'server_time' => now()->toIso8601String(),
        ]);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}
