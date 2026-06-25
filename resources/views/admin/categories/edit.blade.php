@extends('admin.layout')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="text-muted mb-0">Update category information.</p>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary rounded-4">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-5 app-soft">
        <div class="card-body p-4">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $category->description) }}</textarea>
                </div>

                <button type="submit" class="btn app-accent rounded-4">
                    <i class="bi bi-check-circle-fill me-2"></i>Update Category
                </button>
            </form>
        </div>
    </div>
@endsection
