<!DOCTYPE html>
<html>
<head>
    <title>Create Product</title>
</head>
<body>
    <h1>Create Product</h1>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="">Category</label>
        <br>
        <select name="category_id">
            <option value="">-- Select Category --</option>

            @foreach ($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <br><br>

        <label for="">Name</label>
        <br>
        <input type="text" name="name">
        <br><br>

        <label for="">Description</label>
        <br>
        <textarea name="description"></textarea>
        <br><br>

        <label for="">Price</label>
        <br>
        <input type="number" name="price" step="0.01">
        <br><br>

        <label for="">Stock</label>
        <br>
        <input type="number" name="stock">
        <br><br>

        <label for="">Image</label>
        <br>
        <input type="file" name="image">
        <br><br>

        <button type="submit">Save Product</button>
    </form>

    <br>

    <a href="{{ route('admin.products.index') }}">Back</a>
</body>
</html>