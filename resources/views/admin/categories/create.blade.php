@extends('admin.layout')

@section('title', 'Create Category')
@section('page-title', 'Create Category')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="card-title mb-0">Create Category</h5>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="content-card">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save Category</button>
        </form>
    </div>
@endsection
