@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
@php
    $stats = [
        [
            'label' => 'Total Orders',
            'count' => \App\Models\Order::count(),
            'icon' => 'bi-receipt-cutoff',
            'class' => 'teal',
            'change' => '+12%',
            'positive' => true
        ],
        [
            'label' => 'Total Products',
            'count' => \App\Models\Product::count(),
            'icon' => 'bi-box-seam-fill',
            'class' => 'blue',
            'change' => '+8%',
            'positive' => true
        ],
        [
            'label' => 'Categories',
            'count' => \App\Models\Category::count(),
            'icon' => 'bi-tags-fill',
            'class' => 'pink',
            'change' => '+5%',
            'positive' => true
        ],
        [
            'label' => 'Total Users',
            'count' => \App\Models\User::count(),
            'icon' => 'bi-people-fill',
            'class' => 'purple',
            'change' => '+15%',
            'positive' => true
        ],
    ];
@endphp

<div class="row g-3 mb-3">
    @foreach ($stats as $item)
        <div class="col-6 col-xl-3">
            <div class="stat-card {{ $item['class'] }}" onclick="animateValue(this)">
                <div class="stat-icon">
                    <i class="bi {{ $item['icon'] }}"></i>
                </div>
                <div class="stat-value" data-target="{{ $item['count'] }}">0</div>
                <div class="stat-label">{{ $item['label'] }}</div>
                <div class="stat-change {{ $item['positive'] ? 'positive' : 'negative' }}">
                    <i class="bi bi-arrow-up"></i> {{ $item['change'] }}
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="content-card">
            <h5 class="card-title">Recent Orders</h5>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();
                        @endphp
                        @forelse ($recentOrders as $order)
                            @php
                                $statusColors = [
                                    'pending' => 'bg-warning text-dark',
                                    'completed' => 'bg-success',
                                    'cancelled' => 'bg-danger',
                                    'processing' => 'bg-info text-dark'
                                ];
                                $statusClass = $statusColors[$order->status] ?? 'bg-secondary';
                            @endphp
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                <td><span class="badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span></td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-3 text-muted">No orders yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="content-card">
            <h5 class="card-title">Quick Actions</h5>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary text-start">
                    <i class="bi bi-plus-circle me-2"></i>Add Category
                </a>
                <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary text-start">
                    <i class="bi bi-plus-circle me-2"></i>Add Product
                </a>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary text-start">
                    <i class="bi bi-eye me-2"></i>View Orders
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary text-start">
                    <i class="bi bi-people me-2"></i>Manage Users
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.stat-value');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 1500;
            const step = target / (duration / 16);
            let current = 0;

            const updateCounter = () => {
                current += step;
                if (current < target) {
                    counter.textContent = Math.ceil(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };
            updateCounter();
        });
    });

    function animateValue(card) {
        const counter = card.querySelector('.stat-value');
        const target = parseInt(counter.getAttribute('data-target'));
        counter.textContent = '0';
        const duration = 1000;
        const step = target / (duration / 16);
        let current = 0;

        const updateCounter = () => {
            current += step;
            if (current < target) {
                counter.textContent = Math.ceil(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };
        updateCounter();
    }
</script>
@endsection