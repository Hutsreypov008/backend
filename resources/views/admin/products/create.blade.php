@extends('admin.layout')

@section('title', 'Create Product')
@section('page-title', 'Create Product')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="card-title mb-0">Create Product</h5>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="content-card">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" name="category_id" class="form-select" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="col-md-6">
                    <label for="price" class="form-label">Price</label>
                    <input id="price" type="number" name="price" step="0.01" min="0" class="form-control" value="{{ old('price') }}" required>
                </div>

                <div class="col-md-6">
                    <label for="stock" class="form-label">Stock</label>
                    <input id="stock" type="number" name="stock" min="0" class="form-control" value="{{ old('stock') }}" required>
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="col-12">
                    <label for="image" class="form-label">Image</label>
                    <input id="image" type="file" name="image" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Save Product</button>
        </form>
    </div>
@endsection
