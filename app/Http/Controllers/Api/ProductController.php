<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Support both ?limit=N for homepage and ?per_page=N for paginated listing
        $limit = $request->input('limit');
        $perPage = $request->input('per_page', 50);

        $query = Product::with('category')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->when($request->category_id, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest();

        if ($limit) {
            $products = $query->limit((int) $limit)->get();
        } else {
            $products = $query->paginate((int) $perPage);
        }

        return response()->json($products);
    }

    public function show(Request $request, Product $product)
    {
        $product->load('category');

        // Check if the user is authenticated (route is public, so manually check Bearer token)
        $isAuthenticated = false;
        if ($token = $request->bearerToken()) {
            $accessToken = PersonalAccessToken::findToken($token);
            if ($accessToken) {
                $isAuthenticated = true;
            }
        }

        $product->can_review = $isAuthenticated;

        return response()->json($product);
    }
}
