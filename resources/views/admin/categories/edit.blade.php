<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
</head>
<body>
    <h1>Edit Category</h1>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="">Name</label>
        <br>
        <input type="text" name="name" value="{{ $category->name }}">
        <br><br>

        <label for="">Description</label>
        <br>
        <textarea name="description">{{ $category->description }}</textarea>
        <br><br>

        <button type="submit">Update</button>
    </form>

    <br>

    <a href="{{ route('admin.categories.index') }}">Back</a>
</body>
</html>