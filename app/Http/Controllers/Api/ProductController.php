<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        $products = Product::with('category')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->when($request->category_id, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'category_id' => $product->category_id,
                    'category' => $product->category,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'image' => $product->image,
                    'image_url' => $product->image ? asset('storage/' . $product->image) : null,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                ];
            });

        return response()->json($products);
    }

    public function show(Product $product){
        $product->load('category');

        return response()->json([
            'id' => $product->id,
            'category_id' => $product->category_id,
            'category' => $product->category,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'stock' => $product->stock,
            'image' => $product->image,
            'image_url' => $product->image ? asset('storage/' . $product->image) : null,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ]);
    }
}
