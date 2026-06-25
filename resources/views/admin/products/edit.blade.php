@extends('admin.layout')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="text-muted mb-0">Update product details, stock, and image.</p>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-4">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-5 app-soft">
        <div class="card-body p-4">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Category</label>
                        <select id="category_id" name="category_id" class="form-select" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="price" class="form-label">Price</label>
                        <input id="price" type="number" name="price" step="0.01" min="0" class="form-control" value="{{ old('price', $product->price) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="stock" class="form-label">Stock</label>
                        <input id="stock" type="number" name="stock" min="0" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Current Image</label>
                        <div>
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="rounded border" width="120" height="120" alt="{{ $product->name }}">
                            @else
                                <span class="badge text-bg-secondary">No image</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label">New Image</label>
                        <input id="image" type="file" name="image" class="form-control">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn app-accent rounded-4">
                        <i class="bi bi-check-circle-fill me-2"></i>Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
