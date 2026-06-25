@extends('admin.layout')

@section('title', 'Order Detail')
@section('page-title', 'Order Detail')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 fw-bold mb-1">Order #{{ $order->id }}</h2>
            <p class="text-muted mb-0">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary rounded-4">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-5 h-100">
                <div class="card-body p-4">
                    <h2 class="h5 mb-3">Customer</h2>
                    <p class="mb-1"><strong>Name:</strong> {{ $order->user->name }}</p>
                    <p class="mb-0"><strong>Email:</strong> {{ $order->user->email }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-5 h-100">
                <div class="card-body p-4">
                    <h2 class="h5 mb-3">Shipping</h2>
                    <p class="mb-1"><strong>Name:</strong> {{ $order->shipping_name }}</p>
                    <p class="mb-1"><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                    <p class="mb-0"><strong>Address:</strong> {{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-5 h-100 app-soft">
                <div class="card-body p-4">
                    <h2 class="h5 mb-3">Summary</h2>
                    <p class="mb-1"><strong>Status:</strong> <span class="badge app-primary">{{ ucfirst($order->status) }}</span></p>
                    <p class="mb-1"><strong>Total:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                    <p class="mb-0"><strong>Items:</strong> {{ $order->items->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-5 overflow-hidden">
        <div class="card-header bg-white">
            <h2 class="h5 mb-0">Products</h2>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="fw-semibold">{{ $item->product_name }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-end">${{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th class="text-end">${{ number_format($order->total_amount, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
