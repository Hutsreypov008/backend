@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<style>
    /* ==================== DASHBOARD SPECIFIC STYLES ==================== */
    .dash-header {
        background: linear-gradient(135deg, var(--primary), #5A52D5, #7C73FF);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .dash-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 20% 30%, rgba(255,255,255,0.08) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(255,255,255,0.05) 0%, transparent 50%);
    }

    .dash-header::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 30% 40%, rgba(255,255,255,0.06) 1px, transparent 1px),
            radial-gradient(circle at 70% 60%, rgba(255,255,255,0.04) 1px, transparent 1px);
        background-size: 60px 60px, 80px 80px;
    }

    .dash-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .dash-header-left h1 {
        color: white;
        font-size: 1.6rem;
        font-weight: 700;
        margin: 0 0 0.3rem;
        letter-spacing: -0.3px;
    }

    .dash-header-left p {
        color: rgba(255,255,255,0.75);
        margin: 0;
        font-size: 0.9rem;
    }

    .dash-header-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .dash-date-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1.2rem;
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 100px;
        color: white;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .dash-date-badge i {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    /* ==================== STAT CARDS ==================== */
    .stat-card-modern {
        background: white;
        border-radius: 16px;
        padding: 1rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        border: none;
        height: 100%;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .stat-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 35px rgba(108, 99, 255, 0.1);
    }

    .stat-card-modern .stat-bg-icon {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 3.5rem;
        opacity: 0.04;
        pointer-events: none;
    }

    .stat-card-modern .stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .stat-card-modern .stat-icon-wrap {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
    }

    .stat-card-modern .stat-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1.1;
        margin-bottom: 0.15rem;
        letter-spacing: -0.3px;
    }

    .stat-card-modern .stat-label {
        color: var(--text-muted);
        font-size: 0.72rem;
        font-weight: 500;
    }

    .stat-card-modern .stat-footer {
        margin-top: 0.4rem;
        padding-top: 0.4rem;
        border-top: 1px solid #F0F0F5;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.68rem;
    }

    .stat-card-modern .stat-footer.positive { color: #00C853; }
    .stat-card-modern .stat-footer.negative { color: #DC3545; }
    .stat-card-modern .stat-footer.neutral { color: var(--text-muted); }

    /* Card color themes */
    .stat-card-modern.teal .stat-icon-wrap { background: #E0F2F1; color: #00BFA5; }
    .stat-card-modern.teal { border-top: 3px solid #00BFA5; }
    .stat-card-modern.blue .stat-icon-wrap { background: #E1F5FE; color: #4FC3F7; }
    .stat-card-modern.blue { border-top: 3px solid #4FC3F7; }
    .stat-card-modern.pink .stat-icon-wrap { background: #FCE4EC; color: #FF6B9D; }
    .stat-card-modern.pink { border-top: 3px solid #FF6B9D; }
    .stat-card-modern.purple .stat-icon-wrap { background: #F3E5F5; color: #9C27B0; }
    .stat-card-modern.purple { border-top: 3px solid #9C27B0; }
    .stat-card-modern.gold .stat-icon-wrap { background: #FFF8E1; color: #FFB300; }
    .stat-card-modern.gold { border-top: 3px solid #FFB300; }

    /* ==================== CONTENT CARDS ==================== */
    .card-modern {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        border: none;
        height: 100%;
        overflow: hidden;
    }

    .card-modern .card-head {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #F0F0F5;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-modern .card-head h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-modern .card-head h5 i {
        color: var(--primary);
    }

    .card-modern .card-head .card-action {
        font-size: 0.8rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .card-modern .card-head .card-action:hover {
        color: #5A52D5;
    }

    .card-modern .card-body {
        padding: 1.25rem 1.5rem;
    }

    /* ==================== TABLE ==================== */
    .table-dash {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-dash thead th {
        background: #F8F9FE;
        padding: 0.85rem 1rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: none;
        text-align: left;
    }

    .table-dash thead th:first-child { border-radius: 10px 0 0 10px; padding-left: 1.25rem; }
    .table-dash thead th:last-child { border-radius: 0 10px 10px 0; padding-right: 1.25rem; }

    .table-dash tbody tr {
        transition: background 0.2s ease;
    }

    .table-dash tbody tr:hover {
        background: #F8F9FE;
    }

    .table-dash tbody td {
        padding: 1rem;
        border-bottom: 1px solid #F0F0F5;
        font-size: 0.88rem;
        color: var(--text-dark);
        vertical-align: middle;
    }

    .table-dash tbody tr:last-child td:first-child { border-radius: 0 0 0 10px; }
    .table-dash tbody tr:last-child td:last-child { border-radius: 0 0 10px 0; }

    .order-id {
        font-weight: 700;
        color: var(--primary);
        font-size: 0.85rem;
    }

    .customer-name {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .customer-avatar-sm {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .badge-dash {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.75rem;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-dash.pending { background: #FEF3C7; color: #D97706; }
    .badge-dash.completed { background: #D1FAE5; color: #059669; }
    .badge-dash.processing { background: #DBEAFE; color: #2563EB; }
    .badge-dash.cancelled { background: #FEE2E2; color: #DC2626; }
    .badge-dash.shipped { background: #EDE9FE; color: #7C3AED; }

    .amount-text {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--text-dark);
    }

    .date-text {
        color: var(--text-muted);
        font-size: 0.82rem;
    }

    /* ==================== QUICK ACTIONS ==================== */
    .actions-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    .action-btn-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 1.25rem 0.75rem;
        background: #F8F9FE;
        border: 2px solid transparent;
        border-radius: 14px;
        text-decoration: none;
        color: var(--text-dark);
        font-size: 0.78rem;
        font-weight: 600;
        transition: all 0.25s ease;
        text-align: center;
    }

    .action-btn-card:hover {
        border-color: var(--primary);
        background: white;
        color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(108, 99, 255, 0.1);
    }

    .action-btn-card .action-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        transition: all 0.25s ease;
    }

    .action-btn-card:hover .action-icon {
        transform: scale(1.1);
    }

    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
        color: var(--text-muted);
    }

    .empty-state .empty-icon {
        font-size: 2.5rem;
        display: block;
        margin-bottom: 0.75rem;
        opacity: 0.4;
    }

    .empty-state p {
        font-size: 0.85rem;
        margin: 0;
    }

    /* ==================== COUNTER ANIMATION ==================== */
    @keyframes countUp {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .stat-card-modern {
        animation: countUp 0.5s ease both;
    }

    .stat-card-modern:nth-child(1) { animation-delay: 0.05s; }
    .stat-card-modern:nth-child(2) { animation-delay: 0.1s; }
    .stat-card-modern:nth-child(3) { animation-delay: 0.15s; }
    .stat-card-modern:nth-child(4) { animation-delay: 0.2s; }
    .stat-card-modern:nth-child(5) { animation-delay: 0.25s; }
</style>

{{-- ==================== WELCOME HEADER ==================== --}}
<div class="dash-header">
    <div class="dash-header-content">
        <div class="dash-header-left">
            <h1>Welcome back, Admin 👋</h1>
            <p>Here's what's happening with your store today.</p>
        </div>
        <div class="dash-header-right">
            <span class="dash-date-badge">
                <i class="bi bi-calendar3"></i>
                {{ now()->format('l, F j, Y') }}
            </span>
        </div>
    </div>
</div>

{{-- ==================== STAT CARDS ==================== --}}
@php
    $stats = [
        [
            'label' => 'Total Orders',
            'count' => \App\Models\Order::count(),
            'icon' => 'bi-receipt-cutoff',
            'class' => 'teal',
            'bgIcon' => 'bi-receipt',
            'change' => '↑ 12% from last month',
            'positive' => true
        ],
        [
            'label' => 'Total Products',
            'count' => \App\Models\Product::count(),
            'icon' => 'bi-box-seam-fill',
            'class' => 'blue',
            'bgIcon' => 'bi-box',
            'change' => '↑ 8% from last month',
            'positive' => true
        ],
        [
            'label' => 'Categories',
            'count' => \App\Models\Category::count(),
            'icon' => 'bi-tags-fill',
            'class' => 'pink',
            'bgIcon' => 'bi-tag',
            'change' => 'No new categories',
            'positive' => null
        ],
        [
            'label' => 'Total Users',
            'count' => \App\Models\User::count(),
            'icon' => 'bi-people-fill',
            'class' => 'purple',
            'bgIcon' => 'bi-person',
            'change' => '↑ 15% from last month',
            'positive' => true
        ],
        [
            'label' => 'Total Revenue',
            'count' => round(\App\Models\Order::sum('total_amount')),
            'formatted' => '$' . number_format(\App\Models\Order::sum('total_amount'), 2),
            'icon' => 'bi-currency-dollar',
            'class' => 'gold',
            'bgIcon' => 'bi-cash-stack',
            'change' => 'All time earnings',
            'positive' => true
        ],
    ];
@endphp

<div class="row g-3 mb-4">
    @foreach ($stats as $item)
        <div class="col-6 col-xl">
            <div class="stat-card-modern {{ $item['class'] }}" onclick="animateValue(this)">
                <i class="bi {{ $item['bgIcon'] }} stat-bg-icon"></i>
                <div class="stat-top">
                    <div class="stat-icon-wrap">
                        <i class="bi {{ $item['icon'] }}"></i>
                    </div>
                </div>
                @if(isset($item['formatted']))
                    <div class="stat-value" style="font-size: 1.1rem;">{{ $item['formatted'] }}</div>
                @else
                    <div class="stat-value" data-target="{{ $item['count'] }}">0</div>
                @endif
                <div class="stat-label">{{ $item['label'] }}</div>
                <div class="stat-footer {{ $item['positive'] === true ? 'positive' : ($item['positive'] === false ? 'negative' : 'neutral') }}">
                    @if($item['positive'] === true)
                        <i class="bi bi-arrow-up-short"></i>
                    @elseif($item['positive'] === false)
                        <i class="bi bi-arrow-down-short"></i>
                    @endif
                    {{ $item['change'] }}
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- ==================== RECENT ORDERS + QUICK ACTIONS ==================== --}}
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card-modern">
            <div class="card-head">
                <h5><i class="bi bi-receipt-cutoff"></i> Recent Orders</h5>
                <a href="{{ route('admin.orders.index') }}" class="card-action">
                    View All <i class="bi bi-chevron-right" style="font-size: 0.7rem;"></i>
                </a>
            </div>
            <div class="card-body p-0">
                @php
                    $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();
                @endphp

                @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table-dash">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentOrders as $order)
                                    <tr>
                                        <td><span class="order-id">#{{ $order->id }}</span></td>
                                        <td>
                                            <div class="customer-name">
                                                <div class="customer-avatar-sm" style="background: {{ ['#6C63FF','#00BFA5','#FF6B9D','#4FC3F7','#F59E0B','#9C27B0'][$order->user_id % 6] }}">
                                                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                                </div>
                                                <span>{{ $order->user->name }}</span>
                                            </div>
                                        </td>
                                        <td><span class="amount-text">${{ number_format($order->total_amount, 2) }}</span></td>
                                        <td>
                                            <span class="badge-dash {{ $order->status ?? 'pending' }}">
                                                <i class="bi {{ $order->status === 'completed' ? 'bi-check-circle-fill' : ($order->status === 'cancelled' ? 'bi-x-circle-fill' : ($order->status === 'processing' ? 'bi-arrow-repeat' : 'bi-clock-fill')) }}"></i>
                                                {{ ucfirst($order->status ?? 'pending') }}
                                            </span>
                                        </td>
                                        <td><span class="date-text">{{ $order->created_at->format('M d, Y') }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <span class="empty-icon">📦</span>
                        <p>No orders yet. When customers start ordering, they'll appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-modern">
            <div class="card-head">
                <h5><i class="bi bi-lightning-fill" style="color: #F59E0B;"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="actions-grid">
                    <a href="{{ route('admin.categories.create') }}" class="action-btn-card">
                        <div class="action-icon" style="background: #E0F2F1; color: #00BFA5;">
                            <i class="bi bi-plus-lg"></i>
                        </div>
                        Add Category
                    </a>
                    <a href="{{ route('admin.products.create') }}" class="action-btn-card">
                        <div class="action-icon" style="background: #E1F5FE; color: #4FC3F7;">
                            <i class="bi bi-plus-lg"></i>
                        </div>
                        Add Product
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="action-btn-card">
                        <div class="action-icon" style="background: #FCE4EC; color: #FF6B9D;">
                            <i class="bi bi-eye"></i>
                        </div>
                        View Orders
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="action-btn-card">
                        <div class="action-icon" style="background: #F3E5F5; color: #9C27B0;">
                            <i class="bi bi-people"></i>
                        </div>
                        Manage Users
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.stat-value');
        counters.forEach(counter => {
            const targetAttr = counter.getAttribute('data-target');
            if (!targetAttr) return;
            const target = parseInt(targetAttr);
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
        const targetAttr = counter.getAttribute('data-target');
        if (!targetAttr) return;
        const target = parseInt(targetAttr);
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