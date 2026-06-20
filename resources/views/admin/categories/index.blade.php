<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
</head>
<body>
    <h1>Category List</h1>

    <a href="{{ route('admin.categories.create') }}">Add Category</a>

    <br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>

        @foreach ($categories as $index => $category)
            <tr>
                <td>{{ $index +1 }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description }}</td>
                <td>
                    <a href="{{ route('admin.categories.edit', $category->id) }}">Edit</a>

                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;" >
                        
                        @csrf
                        @method('DELETE')

                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>