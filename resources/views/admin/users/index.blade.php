@extends('admin.layout')

@section('title', 'Users')
@section('page-title', 'Users')

@section('content')
<style>
    /* ==================== PAGE HEADER ==================== */
    .user-header {
        background: linear-gradient(135deg, #E65100, #FF8A65, #FFAB91);
        border-radius: 20px;
        padding: 1.75rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .user-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 20% 30%, rgba(255,255,255,0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(255,255,255,0.06) 0%, transparent 50%);
    }

    .user-header::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 30% 40%, rgba(255,255,255,0.07) 1px, transparent 1px),
            radial-gradient(circle at 70% 60%, rgba(255,255,255,0.05) 1px, transparent 1px);
        background-size: 60px 60px, 80px 80px;
    }

    .user-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .user-header-left h1 {
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.25rem;
        letter-spacing: -0.3px;
    }

    .user-header-left h1 i { margin-right: 0.4rem; }

    .user-header-left p {
        color: rgba(255,255,255,0.8);
        margin: 0;
        font-size: 0.85rem;
    }

    .user-header-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* ==================== TABLE CARD ==================== */
    .user-table-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        border: none;
        overflow: hidden;
    }

    .user-table-card .card-head {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #F0F0F5;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .user-table-card .card-head h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .user-table-card .card-head h5 i { color: #FF8A65; }

    .user-table-card .card-head .user-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.85rem;
        background: #FFF3E0;
        color: #E65100;
        border-radius: 100px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    /* ==================== TABLE ==================== */
    .table-user {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-user thead th {
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

    .table-user thead th:first-child { border-radius: 10px 0 0 10px; padding-left: 1.25rem; }
    .table-user thead th:last-child { border-radius: 0 10px 10px 0; padding-right: 1.25rem; }

    .table-user tbody tr { transition: background 0.2s ease; }
    .table-user tbody tr:hover { background: #FFF8F0; }

    .table-user tbody td {
        padding: 0.9rem 1rem;
        border-bottom: 1px solid #F0F0F5;
        font-size: 0.88rem;
        color: var(--text-dark);
        vertical-align: middle;
    }

    .table-user tbody tr:last-child td:first-child { border-radius: 0 0 0 10px; }
    .table-user tbody tr:last-child td:last-child { border-radius: 0 0 10px 0; }
    .table-user tbody tr:last-child td { border-bottom: none; }

    /* ==================== ROW ELEMENTS ==================== */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }

    .user-info .user-name {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-dark);
    }

    .user-info .user-email {
        font-size: 0.78rem;
        color: var(--text-muted);
    }

    .user-id {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: #FFF3E0;
        color: #E65100;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .user-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.8rem;
        border-radius: 100px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .user-role-badge.admin {
        background: #FFF3E0;
        color: #E65100;
    }

    .user-role-badge.admin i { color: #FF8A65; }

    .user-role-badge.customer {
        background: #F5F5F5;
        color: #757575;
    }

    .user-role-badge.customer i { color: #BDBDBD; }

    .user-date {
        color: var(--text-muted);
        font-size: 0.82rem;
    }

    /* ==================== COUPON BADGES ==================== */
    .coupon-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.25rem 0.65rem;
        border-radius: 100px;
        font-size: 0.78rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .coupon-badge i { font-size: 0.6rem; }

    .coupon-badge.active {
        background: #D1FAE5;
        color: #059669;
    }

    .coupon-badge.used {
        background: #FEF3C7;
        color: #D97706;
    }

    .coupon-code {
        font-family: 'Courier New', monospace;
        font-size: 0.75rem;
        font-weight: 600;
        color: #8B5CF6;
        letter-spacing: 0.3px;
        background: #F5F3FF;
        padding: 0.15rem 0.5rem;
        border-radius: 6px;
    }

    .coupon-none {
        color: #ccc;
        font-size: 0.9rem;
    }

    /* ==================== EMPTY STATE ==================== */
    .user-empty {
        text-align: center;
        padding: 3rem 1.5rem;
    }

    .user-empty-icon {
        font-size: 3rem;
        display: block;
        margin-bottom: 0.75rem;
        opacity: 0.3;
    }

    .user-empty h6 {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.3rem;
    }

    .user-empty p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0;
    }

    /* ==================== ANIMATION ==================== */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .user-table-card { animation: fadeSlideUp 0.4s ease both; }
    .user-header { animation: fadeSlideUp 0.4s ease 0.05s both; }
</style>

{{-- ==================== PAGE HEADER ==================== --}}
<div class="user-header">
    <div class="user-header-content">
        <div class="user-header-left">
            <h1><i class="bi bi-people-fill"></i>Users</h1>
            <p>Manage registered users and their account roles.</p>
        </div>
    </div>
</div>

{{-- ==================== USERS TABLE ==================== --}}
<div class="user-table-card">
    <div class="card-head">
        <h5>
            <i class="bi bi-person-badge"></i>
            All Users
        </h5>
        <span class="user-count-badge">
            <i class="bi bi-people"></i>
            {{ $users->count() }} total
        </span>
    </div>
    <div class="table-responsive">
        <table class="table-user">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Coupon</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    @php
                        $isAdmin = (bool) $user->is_admin;
                        $initials = strtoupper(substr($user->name, 0, 1));
                        $avatarColors = ['#FF8A65','#6C63FF','#26A69A','#FF6B9D','#4FC3F7','#F59E0B','#9C27B0','#EF5350'];
                        $avatarColor = $avatarColors[$user->id % count($avatarColors)];
                        $hasProfileImage = !empty($user->profile_image);
                    @endphp
                    <tr>
                        <td><span class="user-id">{{ $index + 1 }}</span></td>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar" style="background: {{ $hasProfileImage ? 'transparent' : $avatarColor }};">
                                    @if($hasProfileImage)
                                        <img src="{{ $user->profile_image_url }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                    @else
                                        {{ $initials }}
                                    @endif
                                </div>
                                <div class="user-info">
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="user-role-badge {{ $isAdmin ? 'admin' : 'customer' }}">
                                <i class="bi {{ $isAdmin ? 'bi-shield-fill-check' : 'bi-person' }}"></i>
                                {{ $isAdmin ? 'Admin' : 'Customer' }}
                            </span>
                        </td>
                        <td>
                            @php
                                $userCoupons = $user->spinRewards->whereNotNull('coupon_code');
                                $activeCoupon = $userCoupons->firstWhere('is_used', false);
                                $usedCoupon = $userCoupons->firstWhere('is_used', true);
                                $latest = $activeCoupon ?? $usedCoupon ?? null;
                            @endphp
                            @if($latest)
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span class="coupon-badge {{ $latest->is_used ? 'used' : 'active' }}">
                                        <i class="bi {{ $latest->is_used ? 'bi-check2-all' : 'bi-tag-fill' }}"></i>
                                        {{ $latest->discount_percent }}%
                                    </span>
                                    @if(!$latest->is_used && $latest->coupon_code)
                                        <span class="coupon-code">{{ $latest->coupon_code }}</span>
                                    @endif
                                </div>
                            @else
                                <span class="coupon-none">—</span>
                            @endif
                        </td>
                        <td><span class="user-date">{{ optional($user->created_at)->format('M d, Y') }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="user-empty">
                                <span class="user-empty-icon">👤</span>
                                <h6>No users yet</h6>
                                <p>Users will appear here when they register.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
