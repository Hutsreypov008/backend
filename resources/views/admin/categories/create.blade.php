<!DOCTYPE html>
<html>
<head>
    <title>Create Category</title>
</head>
<body>
    <h1>Create Category</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <label for="">Name</label>
        <br>
        <input type="text" name="name">
        <br><br>

        <label for="">Description</label>
        <br>
        <textarea name="description"></textarea>
        <br><br>

        <button type="submit">Save</button>
    </form>

    <br>

    <a href="{{ route('admin.categories.index') }}">Back</a>
</body>
</html>