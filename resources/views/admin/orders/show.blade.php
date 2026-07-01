@extends('admin.layout')

@section('title', 'Order Detail')
@section('page-title', 'Order Detail')

@section('content')
@php
    $statusColors = [
        'completed' => '#059669',
        'cancelled' => '#DC2626',
        'processing' => '#2563EB',
        'preparing' => '#3F51B5',
        'shipped' => '#7C3AED',
        'pending' => '#D97706',
    ];
    $statusColor = $statusColors[$order->status] ?? '#D97706';

    $statusIcons = [
        'pending' => 'bi-clock-fill',
        'preparing' => 'bi-arrow-repeat',
        'processing' => 'bi-arrow-repeat',
        'shipped' => 'bi-truck',
        'completed' => 'bi-check-circle-fill',
        'cancelled' => 'bi-x-circle-fill',
    ];
    $statusIcon = $statusIcons[$order->status ?? 'pending'] ?? 'bi-clock-fill';
    $isTerminal = in_array($order->status ?? 'pending', ['completed', 'cancelled']);
@endphp
<style>
    /* ==================== PAGE HEADER ==================== */
    .ord-header {
        background: linear-gradient(135deg, #00695C, #26A69A, #4DB6AC);
        border-radius: 20px;
        padding: 1.75rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .ord-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 20% 30%, rgba(255,255,255,0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(255,255,255,0.06) 0%, transparent 50%);
    }

    .ord-header::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 30% 40%, rgba(255,255,255,0.07) 1px, transparent 1px),
            radial-gradient(circle at 70% 60%, rgba(255,255,255,0.05) 1px, transparent 1px);
        background-size: 60px 60px, 80px 80px;
    }

    .ord-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .ord-header-left h1 {
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.35rem;
        letter-spacing: -0.3px;
    }

    .ord-header-left h1 i { margin-right: 0.4rem; }

    .ord-header-left .ord-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .ord-header-left .ord-meta span {
        color: rgba(255,255,255,0.75);
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .ord-header-left .ord-meta span i { font-size: 0.75rem; }

    .ord-header-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .ord-btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.4rem;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 100px;
        color: white;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .ord-btn-back:hover {
        background: rgba(255,255,255,0.25);
        color: white;
        transform: translateY(-2px);
    }

    .ord-status-badge-large {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 1rem;
        border-radius: 100px;
        font-size: 0.82rem;
        font-weight: 600;
    }

    .ord-status-badge-large i { font-size: 0.7rem; }

    .ord-status-badge-large.pending { background: rgba(255,255,255,0.18); color: white; }
    .ord-status-badge-large.processing { background: rgba(255,255,255,0.18); color: white; }
    .ord-status-badge-large.shipped { background: rgba(255,255,255,0.18); color: white; }
    .ord-status-badge-large.completed { background: rgba(255,255,255,0.22); color: white; }
    .ord-status-badge-large.preparing { background: rgba(255,255,255,0.18); color: white; }
    .ord-status-badge-large.cancelled { background: rgba(255,255,255,0.18); color: white; }

    .ord-status-btn-large {
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 1rem;
        border-radius: 100px;
        font-size: 0.82rem;
        font-weight: 600;
        font-family: inherit;
        transition: all 0.2s ease;
        background: rgba(255,255,255,0.18);
        color: white;
    }

    .ord-status-btn-large i { font-size: 0.7rem; }

    .ord-status-btn-large:hover {
        background: rgba(255,255,255,0.28);
        transform: translateY(-1px);
    }

    .ord-status-btn-large:active { transform: translateY(0); }

    .ord-status-btn-large.completed {
        background: rgba(255,255,255,0.22);
        cursor: default;
        pointer-events: none;
    }

    .ord-status-btn-large.cancelled {
        cursor: default;
        pointer-events: none;
    }

    /* ==================== INFO CARDS ==================== */
    .ord-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .ord-info-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        border: none;
        overflow: hidden;
    }

    .ord-info-card .card-head {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #F0F0F5;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .ord-info-card .card-head i {
        font-size: 0.9rem;
        width: 20px;
        text-align: center;
    }

    .ord-info-card .card-head h6 {
        margin: 0;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--text-dark);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .ord-info-card .card-head.customer i { color: #6C63FF; }
    .ord-info-card .card-head.shipping i { color: #26A69A; }
    .ord-info-card .card-head.summary i { color: #F59E0B; }

    .ord-info-card .card-body {
        padding: 1rem 1.25rem;
    }

    .ord-info-item {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding: 0.35rem 0;
        font-size: 0.85rem;
    }

    .ord-info-item .label {
        color: var(--text-muted);
        font-weight: 500;
    }

    .ord-info-item .value {
        color: var(--text-dark);
        font-weight: 600;
        text-align: right;
    }

    .ord-info-item .value.highlight {
        color: #26A69A;
        font-size: 1rem;
    }

    .ord-divider {
        height: 1px;
        background: #F0F0F5;
        margin: 0.5rem 0;
    }

    .ord-full-address {
        font-size: 0.82rem;
        color: var(--text-dark);
        line-height: 1.5;
    }

    .ord-full-address small {
        color: var(--text-muted);
        display: block;
        margin-bottom: 0.2rem;
    }

    /* ==================== ITEMS TABLE CARD ==================== */
    .ord-items-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        border: none;
        overflow: hidden;
    }

    .ord-items-card .card-head {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #F0F0F5;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .ord-items-card .card-head h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .ord-items-card .card-head i { color: #26A69A; }

    .ord-items-card .card-head .ord-item-count {
        margin-left: auto;
        font-size: 0.78rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    /* ==================== ITEMS TABLE ==================== */
    .table-ord-items {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-ord-items thead th {
        background: #F8F9FE;
        padding: 0.8rem 1.25rem;
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: none;
        text-align: left;
    }

    .table-ord-items thead th:first-child { border-radius: 10px 0 0 10px; }
    .table-ord-items thead th:last-child { border-radius: 0 10px 10px 0; padding-right: 1.5rem; }

    .table-ord-items tbody tr { transition: background 0.2s ease; }
    .table-ord-items tbody tr:hover { background: #F8F9FE; }

    .table-ord-items tbody td {
        padding: 0.9rem 1.25rem;
        border-bottom: 1px solid #F0F0F5;
        font-size: 0.88rem;
        color: var(--text-dark);
        vertical-align: middle;
    }

    .table-ord-items tbody tr:last-child td { border-bottom: none; }

    .table-ord-items .item-name {
        font-weight: 600;
    }

    .table-ord-items .item-qty {
        color: var(--text-muted);
    }

    .table-ord-items .item-subtotal {
        font-weight: 700;
        color: var(--text-dark);
    }

    /* ==================== TABLE FOOTER ==================== */
    .table-ord-items tfoot td {
        padding: 0.9rem 1.25rem;
        border-top: 2px solid #F0F0F5;
        font-size: 0.88rem;
        vertical-align: middle;
    }

    .table-ord-items tfoot .total-label {
        font-weight: 600;
        color: var(--text-muted);
        text-align: right;
    }

    .table-ord-items tfoot .total-value {
        font-weight: 800;
        font-size: 1rem;
        color: #26A69A;
        text-align: right;
        padding-right: 1.5rem;
    }

    /* ==================== ANIMATION ==================== */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .ord-header { animation: fadeSlideUp 0.4s ease both; }
    .ord-info-card { animation: fadeSlideUp 0.4s ease both; }
    .ord-info-card:nth-child(1) { animation-delay: 0.05s; }
    .ord-info-card:nth-child(2) { animation-delay: 0.1s; }
    .ord-info-card:nth-child(3) { animation-delay: 0.15s; }
    .ord-items-card { animation: fadeSlideUp 0.4s ease 0.2s both; }
</style>

{{-- ==================== PAGE HEADER ==================== --}}
<div class="ord-header">
    <div class="ord-header-content">
        <div class="ord-header-left">
            <h1><i class="bi bi-receipt-cutoff"></i>Order #{{ $order->id }}</h1>
            <div class="ord-meta">
                <span><i class="bi bi-calendar3"></i>{{ $order->created_at->format('M d, Y \a\t h:i A') }}</span>
                <span><i class="bi bi-box-seam"></i>{{ $order->items->count() }} item(s)</span>
                @if($isTerminal)
                    <span class="ord-status-badge-large {{ $order->status ?? 'pending' }}">
                        <i class="bi {{ $statusIcon }}"></i>
                        {{ ucfirst($order->status ?? 'pending') }}
                    </span>
                @else
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="ord-status-btn-large {{ $order->status ?? 'pending' }}" title="Click to advance status">
                            <i class="bi {{ $statusIcon }}"></i>
                            {{ ucfirst($order->status ?? 'pending') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
        <div class="ord-header-right">
            <a href="{{ route('admin.orders.index') }}" class="ord-btn-back">
                <i class="bi bi-arrow-left"></i>
                <span>Back</span>
            </a>
        </div>
    </div>
</div>

{{-- ==================== INFO CARDS ==================== --}}
<div class="ord-info-grid">
    <div class="ord-info-card">
        <div class="card-head customer">
            <i class="bi bi-person-circle"></i>
            <h6>Customer</h6>
        </div>
        <div class="card-body">
            <div class="ord-info-item">
                <span class="label">Name</span>
                <span class="value">{{ $order->user->name }}</span>
            </div>
            <div class="ord-info-item">
                <span class="label">Email</span>
                <span class="value">{{ $order->user->email }}</span>
            </div>
        </div>
    </div>

    <div class="ord-info-card">
        <div class="card-head shipping">
            <i class="bi bi-truck"></i>
            <h6>Shipping</h6>
        </div>
        <div class="card-body">
            <div class="ord-full-address">
                <small>Shipping to:</small>
                <strong>{{ $order->shipping_name }}</strong><br>
                {{ $order->shipping_address }}<br>
                @if($order->shipping_phone)
                    <span style="font-size: 0.78rem; color: var(--text-muted);">
                        <i class="bi bi-telephone"></i> {{ $order->shipping_phone }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="ord-info-card">
        <div class="card-head summary">
            <i class="bi bi-pie-chart"></i>
            <h6>Summary</h6>
        </div>
        <div class="card-body">
            <div class="ord-info-item">
                <span class="label">Items</span>
                <span class="value">{{ $order->items->count() }}</span>
            </div>
            <div class="ord-info-item">
                <span class="label">Status</span>
                @if($isTerminal)
                    <span class="value" style="color: {{ $statusColor }};">
                        {{ ucfirst($order->status ?? 'pending') }}
                    </span>
                @else
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                style="border: none; background: none; cursor: pointer; font-weight: 600; font-size: 0.85rem; font-family: inherit; color: {{ $statusColor }}; transition: all 0.2s ease; padding: 0;"
                                title="Click to advance status">
                            {{ ucfirst($order->status ?? 'pending') }}
                        </button>
                    </form>
                @endif
            </div>
            @if($order->coupon_code && $order->discount_amount > 0)
                <div class="ord-divider"></div>
                <div class="ord-info-item">
                    <span class="label">
                        <i class="bi bi-tags-fill" style="color: #F59E0B;"></i>
                        Discount
                    </span>
                    <span class="value" style="color: #10B981; font-weight: 700;">
                        -${{ number_format($order->discount_amount, 2) }}
                    </span>
                </div>
                <div class="ord-info-item">
                    <span class="label">Discount %</span>
                    <span class="value" style="color: #F59E0B; font-weight: 800; font-size: 1.05rem;">
                        {{ $spinReward?->discount_percent ?? 0 }}%
                    </span>
                </div>
                <div class="ord-info-item">
                    <span class="label">Coupon Code</span>
                    <span class="value" style="font-family: 'Courier New', monospace; font-weight: 700; color: #8B5CF6; font-size: 0.95rem; letter-spacing: 0.5px;">
                        {{ $order->coupon_code }}
                    </span>
                </div>
            @else
                <div class="ord-info-item">
                    <span class="label">Discount</span>
                    <span class="value" style="color: var(--text-muted);">No discount applied</span>
                </div>
            @endif
            <div class="ord-divider"></div>
            <div class="ord-info-item">
                <span class="label">Total Amount</span>
                <span class="value highlight">${{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>
    </div>
</div>

{{-- ==================== ITEMS TABLE ==================== --}}
<div class="ord-items-card">
    <div class="card-head">
        <i class="bi bi-box-seam-fill"></i>
        <h5>Order Items</h5>
        <span class="ord-item-count">{{ $order->items->count() }} product(s)</span>
    </div>
    <div class="table-responsive">
        <table class="table-ord-items">
            <thead>
                <tr>
                    <th>Product</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Price</th>
                    <th style="text-align: right; padding-right: 1.5rem;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>
                            <span class="item-name">{{ $item->product_name }}</span>
                        </td>
                        <td style="text-align: center;">
                            <span class="item-qty">{{ $item->quantity }}</span>
                        </td>
                        <td style="text-align: right;">
                            ${{ number_format($item->price, 2) }}
                        </td>
                        <td style="text-align: right; padding-right: 1.5rem;">
                            <span class="item-subtotal">${{ number_format($item->subtotal, 2) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                @if($order->coupon_code && $order->discount_amount > 0)
                    <tr>
                        <td colspan="3" class="total-label" style="padding-top: 0.6rem;">Discount</td>
                        <td class="total-value" style="color: #10B981; font-size: 0.9rem; font-weight: 600;">
                            -${{ number_format($order->discount_amount, 2) }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <td colspan="3" class="total-label">Total</td>
                    <td class="total-value">${{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
