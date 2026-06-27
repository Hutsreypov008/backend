@extends('admin.layout')

@section('title', 'Orders')
@section('page-title', 'Orders')

@section('content')
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
        margin: 0 0 0.25rem;
        letter-spacing: -0.3px;
    }

    .ord-header-left h1 i { margin-right: 0.4rem; }

    .ord-header-left p {
        color: rgba(255,255,255,0.8);
        margin: 0;
        font-size: 0.85rem;
    }

    .ord-header-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* ==================== TABLE CARD ==================== */
    .ord-table-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        border: none;
        overflow: hidden;
    }

    .ord-table-card .card-head {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #F0F0F5;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .ord-table-card .card-head h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .ord-table-card .card-head h5 i { color: #26A69A; }

    .ord-table-card .card-head .ord-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.85rem;
        background: #E0F2F1;
        color: #00695C;
        border-radius: 100px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    /* ==================== TABLE ==================== */
    .table-ord {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-ord thead th {
        background: #F8F9FE;
        padding: 0.85rem 1rem;
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: none;
        text-align: left;
    }

    .table-ord thead th:first-child { border-radius: 10px 0 0 10px; padding-left: 1.25rem; }
    .table-ord thead th:last-child { border-radius: 0 10px 10px 0; padding-right: 1.25rem; }

    .table-ord tbody tr { transition: background 0.2s ease; }
    .table-ord tbody tr:hover { background: #F8F9FE; }

    .table-ord tbody td {
        padding: 0.9rem 1rem;
        border-bottom: 1px solid #F0F0F5;
        font-size: 0.88rem;
        color: var(--text-dark);
        vertical-align: middle;
    }

    .table-ord tbody tr:last-child td:first-child { border-radius: 0 0 0 10px; }
    .table-ord tbody tr:last-child td:last-child { border-radius: 0 0 10px 0; }
    .table-ord tbody tr:last-child td { border-bottom: none; }

    /* ==================== ROW ELEMENTS ==================== */
    .ord-id {
        font-weight: 700;
        color: #26A69A;
        font-size: 0.9rem;
        letter-spacing: -0.2px;
    }

    .ord-customer {
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }

    .ord-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }

    .ord-customer-info .ord-name {
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--text-dark);
    }

    .ord-customer-info .ord-email {
        font-size: 0.78rem;
        color: var(--text-muted);
    }

    .ord-amount {
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--text-dark);
    }

    .ord-amount .currency {
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--text-muted);
    }

    /* ==================== STATUS BADGES ==================== */
    .ord-status {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.8rem;
        border-radius: 100px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .ord-status i { font-size: 0.6rem; }

    .ord-status.pending {
        background: #FEF3C7;
        color: #D97706;
    }

    .ord-status.processing {
        background: #DBEAFE;
        color: #2563EB;
    }

    .ord-status.shipped {
        background: #EDE9FE;
        color: #7C3AED;
    }

    .ord-status.preparing {
        background: #E8EAF6;
        color: #3F51B5;
    }

    .ord-status.completed {
        background: #D1FAE5;
        color: #059669;
    }

    .ord-status.cancelled {
        background: #FEE2E2;
        color: #DC2626;
    }

    .ord-status-btn {
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.8rem;
        border-radius: 100px;
        font-size: 0.78rem;
        font-weight: 600;
        font-family: inherit;
        transition: all 0.2s ease;
    }

    .ord-status-btn i { font-size: 0.6rem; }

    .ord-status-btn:hover {
        filter: brightness(0.92);
        transform: translateY(-1px);
    }

    .ord-status-btn:active {
        transform: translateY(0);
    }

    .ord-status-btn.pending {
        background: #FEF3C7;
        color: #D97706;
    }

    .ord-status-btn.preparing {
        background: #E8EAF6;
        color: #3F51B5;
    }

    .ord-status-btn.completed {
        background: #D1FAE5;
        color: #059669;
        cursor: default;
        pointer-events: none;
    }

    .ord-status-btn.cancelled {
        background: #FEE2E2;
        color: #DC2626;
        cursor: default;
        pointer-events: none;
    }

    .ord-date {
        color: var(--text-muted);
        font-size: 0.82rem;
    }

    /* ==================== ACTIONS ==================== */
    .ord-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.4rem;
    }

    .ord-btn-view {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        background: #E0F2F1;
        color: #00695C;
    }

    .ord-btn-view:hover {
        background: #26A69A;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(38, 166, 154, 0.3);
    }

    /* ==================== EMPTY STATE ==================== */
    .ord-empty {
        text-align: center;
        padding: 3rem 1.5rem;
    }

    .ord-empty-icon {
        font-size: 3rem;
        display: block;
        margin-bottom: 0.75rem;
        opacity: 0.3;
    }

    .ord-empty h6 {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.3rem;
    }

    .ord-empty p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0;
    }

    /* ==================== ANIMATION ==================== */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .ord-table-card { animation: fadeSlideUp 0.4s ease both; }
    .ord-header { animation: fadeSlideUp 0.4s ease 0.05s both; }
</style>

{{-- ==================== PAGE HEADER ==================== --}}
<div class="ord-header">
    <div class="ord-header-content">
        <div class="ord-header-left">
            <h1><i class="bi bi-receipt-cutoff"></i>Orders</h1>
            <p>Track and manage all customer orders.</p>
        </div>
        <div class="ord-header-right">
            <span style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.45rem 1.2rem; background: rgba(255,255,255,0.12); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.1); border-radius: 100px; color: white; font-size: 0.82rem; font-weight: 500;">
                <i class="bi bi-clock-history"></i>
                {{ now()->format('M d, Y') }}
            </span>
        </div>
    </div>
</div>

{{-- ==================== ORDERS TABLE ==================== --}}
<div class="ord-table-card">
    <div class="card-head">
        <h5>
            <i class="bi bi-list-ul"></i>
            All Orders
        </h5>
        <span class="ord-count-badge">
            <i class="bi bi-receipt"></i>
            {{ $orders->count() }} total
        </span>
    </div>
    <div class="table-responsive">
        <table class="table-ord">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th style="width: 80px; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    @php
                        $initials = strtoupper(substr($order->user->name, 0, 1));
                        $avatarColors = ['#26A69A','#6C63FF','#FF6B9D','#4FC3F7','#F59E0B','#9C27B0'];
                        $avatarColor = $avatarColors[$order->user_id % count($avatarColors)];
                    @endphp
                    <tr>
                        <td><span class="ord-id">#{{ $order->id }}</span></td>
                        <td>
                            <div class="ord-customer">
                                <div class="ord-avatar" style="background: {{ $avatarColor }};">
                                    {{ $initials }}
                                </div>
                                <div class="ord-customer-info">
                                    <div class="ord-name">{{ $order->user->name }}</div>
                                    <div class="ord-email">{{ $order->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="ord-amount"><span class="currency">$</span>{{ number_format($order->total_amount, 2) }}</span></td>
                        <td>
                            @php
                                $status = $order->status ?? 'pending';
                                $statusIcons = [
                                    'pending' => 'bi-clock-fill',
                                    'preparing' => 'bi-arrow-repeat',
                                    'processing' => 'bi-arrow-repeat',
                                    'shipped' => 'bi-truck',
                                    'completed' => 'bi-check-circle-fill',
                                    'cancelled' => 'bi-x-circle-fill',
                                ];
                                $statusIcon = $statusIcons[$status] ?? 'bi-clock-fill';
                            @endphp
                            @if(in_array($status, ['completed', 'cancelled']))
                                <span class="ord-status {{ $status }}">
                                    <i class="bi {{ $statusIcon }}"></i>
                                    {{ ucfirst($status) }}
                                </span>
                            @else
                                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="ord-status-btn {{ $status }}" title="Click to advance status">
                                        <i class="bi {{ $statusIcon }}"></i>
                                        {{ ucfirst($status) }}
                                    </button>
                                </form>
                            @endif
                        </td>
                        <td><span class="ord-date">{{ $order->created_at->format('M d, Y') }}</span></td>
                        <td>
                            <div class="ord-actions">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                   class="ord-btn-view"
                                   title="View order details">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="ord-empty">
                                <span class="ord-empty-icon">📋</span>
                                <h6>No orders yet</h6>
                                <p>When customers place orders, they will appear here.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
