<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Category</label>
        <br>
        <select name="category_id">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" 
                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <br><br>

        <label for="">Name</label>
        <br>
        <input type="text" name="name" value="{{ $product->name }}">
        <br><br>

        <label for="">Description</label>
        <br>
        <textarea name="description">{{ $product->description }}</textarea>
        <br><br>

        <label for="">Price</label>
        <br>
        <input type="number" name="price" step="0.01" value="{{ $product->price }}">
        <br><br>

        <label for="">Stock</label>
        <br>
        <input type="number" name="stock" value="{{ $product->stock }}">
        <br><br>

        <label for="">Current Image</label>
        <br>
        @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" width="100" alt="{{ $product->name }}">
        @else
            No image
        @endif
        <br><br>

        <label for="">New Image</label>
        <br>
        <input type="file" name="image">
        <br><br>

        <button type="submit">Update Product</button>
    </form>

    <br>

    <a href="{{ route('admin.products.index') }}">Back</a>
</body>
</html>