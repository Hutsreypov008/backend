<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
</head>
<body>
    <h1>Product List</h1>

    <a href="{{ route('admin.products.create') }}">Add Product</a>

    <br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Category</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Action</th>
        </tr>

        @foreach ($products as $index=> $product)
            <tr>
                <td>{{ $index +1 }}</td>

                <td>
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" width="80" alt="{{ $product->name }}">
                    @else
                        No image
                    @endif
                </td>

                <td>{{ $product->category->name }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>

                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}">Edit</a>

                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                          method="POST"
                          style="display:inline;"
                          onsubmit="return confirm('Are you sure you want to delete this product?');">
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