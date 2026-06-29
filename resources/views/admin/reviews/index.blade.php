@extends('admin.layout')

@section('title', 'Reviews')
@section('page-title', 'Reviews')

@section('content')
<style>
    /* ==================== PAGE HEADER ==================== */
    .rev-header {
        background: linear-gradient(135deg, #7C3AED, #A78BFA, #C4B5FD);
        border-radius: 20px;
        padding: 1.75rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .rev-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 20% 30%, rgba(255,255,255,0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(255,255,255,0.06) 0%, transparent 50%);
    }

    .rev-header::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 30% 40%, rgba(255,255,255,0.07) 1px, transparent 1px),
            radial-gradient(circle at 70% 60%, rgba(255,255,255,0.05) 1px, transparent 1px);
        background-size: 60px 60px, 80px 80px;
    }

    .rev-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .rev-header-left h1 {
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.25rem;
        letter-spacing: -0.3px;
    }

    .rev-header-left h1 i { margin-right: 0.4rem; }

    .rev-header-left p {
        color: rgba(255,255,255,0.8);
        margin: 0;
        font-size: 0.85rem;
    }

    .rev-header-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* ==================== TABLE CARD ==================== */
    .rev-table-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        border: none;
        overflow: hidden;
    }

    .rev-table-card .card-head {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #F0F0F5;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .rev-table-card .card-head h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .rev-table-card .card-head h5 i { color: #7C3AED; }

    .rev-table-card .card-head .rev-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.85rem;
        background: #EDE9FE;
        color: #7C3AED;
        border-radius: 100px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    /* ==================== TABLE ==================== */
    .table-rev {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-rev thead th {
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

    .table-rev thead th:first-child { border-radius: 10px 0 0 10px; padding-left: 1.25rem; }
    .table-rev thead th:last-child { border-radius: 0 10px 10px 0; padding-right: 1.25rem; }

    .table-rev tbody tr { transition: background 0.2s ease; }
    .table-rev tbody tr:hover { background: #F8F9FE; }

    .table-rev tbody td {
        padding: 0.9rem 1rem;
        border-bottom: 1px solid #F0F0F5;
        font-size: 0.88rem;
        color: var(--text-dark);
        vertical-align: middle;
    }

    .table-rev tbody tr:last-child td:first-child { border-radius: 0 0 0 10px; }
    .table-rev tbody tr:last-child td:last-child { border-radius: 0 0 10px 0; }
    .table-rev tbody tr:last-child td { border-bottom: none; }

    /* ==================== ROW ELEMENTS ==================== */
    .rev-reviewer {
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }

    .rev-avatar {
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

    .rev-reviewer-info .rev-name {
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--text-dark);
    }

    .rev-reviewer-info .rev-email {
        font-size: 0.78rem;
        color: var(--text-muted);
    }

    .rev-product {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        max-width: 200px;
    }

    .rev-product-img {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        object-fit: cover;
        background: #F0F0F5;
        flex-shrink: 0;
    }

    .rev-product-img-placeholder {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background: #F0F0F5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #CCC;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .rev-product-name {
        font-weight: 500;
        font-size: 0.85rem;
        color: var(--text-dark);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* ==================== STARS ==================== */
    .rev-stars {
        display: inline-flex;
        gap: 0.15rem;
        font-size: 0.9rem;
    }

    .rev-stars .star-filled { color: #F59E0B; }
    .rev-stars .star-empty { color: #E0E0E0; }

    .rev-rating-text {
        font-size: 0.78rem;
        color: var(--text-muted);
        margin-left: 0.3rem;
    }

    /* ==================== COMMENT ==================== */
    .rev-comment {
        max-width: 280px;
    }

    .rev-comment-text {
        font-size: 0.85rem;
        color: var(--text-dark);
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-break: break-word;
    }

    .rev-comment-text.expanded {
        -webkit-line-clamp: unset;
        overflow: visible;
    }

    .rev-comment-toggle {
        background: none;
        border: none;
        color: #7C3AED;
        font-size: 0.72rem;
        font-weight: 600;
        cursor: pointer;
        padding: 0;
        margin-top: 0.2rem;
    }

    .rev-comment-toggle:hover {
        text-decoration: underline;
    }

    .rev-comment-empty {
        color: #CCC;
        font-size: 0.82rem;
        font-style: italic;
    }

    /* ==================== DATE ==================== */
    .rev-date {
        color: var(--text-muted);
        font-size: 0.82rem;
        white-space: nowrap;
    }

    /* ==================== ACTIONS ==================== */
    .rev-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.4rem;
    }

    .rev-btn-delete {
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
        background: #FEE2E2;
        color: #DC2626;
    }

    .rev-btn-delete:hover {
        background: #DC2626;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    /* ==================== EMPTY STATE ==================== */
    .rev-empty {
        text-align: center;
        padding: 3rem 1.5rem;
    }

    .rev-empty-icon {
        font-size: 3rem;
        display: block;
        margin-bottom: 0.75rem;
        opacity: 0.3;
    }

    .rev-empty h6 {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.3rem;
    }

    .rev-empty p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0;
    }

    /* ==================== CONFIRM MODAL ==================== */
    .rev-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        backdrop-filter: blur(4px);
        z-index: 1050;
        align-items: center;
        justify-content: center;
    }

    .rev-modal-overlay.active {
        display: flex;
    }

    .rev-modal {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        max-width: 400px;
        width: 90%;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        animation: modalIn 0.25s ease both;
    }

    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.92) translateY(12px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .rev-modal-icon {
        font-size: 3rem;
        margin-bottom: 0.75rem;
    }

    .rev-modal h5 {
        font-weight: 700;
        margin-bottom: 0.4rem;
    }

    .rev-modal p {
        font-size: 0.88rem;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }

    .rev-modal-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }

    .rev-modal .btn {
        padding: 0.6rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .rev-modal .btn-cancel {
        background: #F0F0F5;
        color: var(--text-dark);
    }

    .rev-modal .btn-cancel:hover {
        background: #E0E0E5;
    }

    .rev-modal .btn-danger {
        background: #DC2626;
        color: white;
    }

    .rev-modal .btn-danger:hover {
        background: #B91C1C;
    }

    /* ==================== REAL-TIME NOTIFICATION BANNER ==================== */
    .rev-notif {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1060;
        background: white;
        border-radius: 16px;
        padding: 1rem 1.25rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 1rem;
        transform: translateY(calc(100% + 40px));
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        border-left: 4px solid #7C3AED;
        max-width: 420px;
    }

    .rev-notif.active {
        transform: translateY(0);
        opacity: 1;
    }

    .rev-notif-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #EDE9FE;
        color: #7C3AED;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .rev-notif-content {
        flex: 1;
        min-width: 0;
    }

    .rev-notif-text {
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--text-dark);
        display: block;
    }

    .rev-notif-actions {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        flex-shrink: 0;
    }

    .rev-notif-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.45rem 0.9rem;
        border: none;
        border-radius: 10px;
        background: #7C3AED;
        color: white;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .rev-notif-btn:hover {
        background: #6D28D9;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    .rev-notif-btn:disabled {
        opacity: 0.7;
        cursor: wait;
    }

    .rev-notif-btn.pulse {
        animation: revPulse 0.6s ease;
    }

    @keyframes revPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .rev-notif-btn .spinning {
        display: inline-block;
        animation: revSpin 0.8s linear infinite;
    }

    @keyframes revSpin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .rev-notif-close {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        border: none;
        background: transparent;
        color: #AAA;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-size: 0.7rem;
    }

    .rev-notif-close:hover {
        background: #F0F0F5;
        color: var(--text-muted);
    }

    /* ==================== ANIMATION ==================== */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .rev-table-card { animation: fadeSlideUp 0.4s ease both; }
    .rev-header { animation: fadeSlideUp 0.4s ease 0.05s both; }
</style>

{{-- ==================== PAGE HEADER ==================== --}}
<div class="rev-header">
    <div class="rev-header-content">
        <div class="rev-header-left">
            <h1><i class="bi bi-star-fill"></i>Reviews</h1>
            <p>Manage customer reviews and feedback.</p>
        </div>
        <div class="rev-header-right">
            <span style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.45rem 1.2rem; background: rgba(255,255,255,0.12); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.1); border-radius: 100px; color: white; font-size: 0.82rem; font-weight: 500;">
                <i class="bi bi-clock-history"></i>
                {{ now()->format('M d, Y') }}
            </span>
        </div>
    </div>
</div>

{{-- ==================== SUCCESS MESSAGE ==================== --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 mb-3" role="alert" style="background: #D1FAE5; color: #065F46;">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- ==================== REVIEWS TABLE ==================== --}}
<div class="rev-table-card">
    <div class="card-head">
        <h5>
            <i class="bi bi-list-ul"></i>
            All Reviews
        </h5>
        <span class="rev-count-badge">
            <i class="bi bi-star"></i>
            {{ $reviews->count() }} total
        </span>
    </div>
    <div class="table-responsive">
        <table class="table-rev">
            <thead>
                <tr>
                    <th>Reviewer</th>
                    <th>Product</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th style="width: 80px; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reviews as $review)
                    @php
                        $reviewerName = $review->user->name ?? 'Deleted User';
                        $reviewerEmail = $review->user->email ?? '';
                        $initials = strtoupper(substr($reviewerName, 0, 1));
                        $avatarColors = ['#7C3AED','#A78BFA','#C4B5FD','#6C63FF','#8B5CF6','#9333EA'];
                        $avatarColor = $avatarColors[$review->user_id % count($avatarColors)];
                    @endphp
                    <tr>
                        <td>
                            <div class="rev-reviewer">
                                <div class="rev-avatar" style="background: {{ $avatarColor }};">
                                    {{ $initials }}
                                </div>
                                <div class="rev-reviewer-info">
                                    <div class="rev-name">{{ $reviewerName }}</div>
                                    <div class="rev-email">{{ $reviewerEmail }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="rev-product">
                                @if($review->product && $review->product->image)
                                    <img src="{{ asset('storage/' . ltrim($review->product->image, '/')) }}" alt="{{ $review->product->name }}" class="rev-product-img">
                                @else
                                    <div class="rev-product-img-placeholder">
                                        <i class="bi bi-box"></i>
                                    </div>
                                @endif
                                <span class="rev-product-name">{{ $review->product ? $review->product->name : 'Deleted Product' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="rev-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= $review->rating ? 'bi-star-fill star-filled' : 'bi-star star-empty' }}"></i>
                                @endfor
                                <span class="rev-rating-text">{{ $review->rating }}/5</span>
                            </div>
                        </td>
                        <td>
                            <div class="rev-comment">
                                @if($review->comment)
                                    <div class="rev-comment-text" id="comment-{{ $review->id }}">
                                        {{ $review->comment }}
                                    </div>
                                    @if(strlen($review->comment) > 100)
                                        <button class="rev-comment-toggle" onclick="toggleComment({{ $review->id }})" id="toggle-{{ $review->id }}">
                                            Read more
                                        </button>
                                    @endif
                                @else
                                    <span class="rev-comment-empty">No comment</span>
                                @endif
                            </div>
                        </td>
                        <td><span class="rev-date">{{ $review->created_at->format('M d, Y \\a\\t g:i A') }}</span></td>
                        <td>
                            <div class="rev-actions">
                                <button type="button"
                                        class="rev-btn-delete"
                                        title="Delete review"
                                        onclick="openDeleteModal({{ $review->id }}, '{{ addslashes($reviewerName) }}')">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="rev-empty">
                                <span class="rev-empty-icon">💬</span>
                                <h6>No reviews yet</h6>
                                <p>When customers leave reviews on products, they will appear here.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ==================== DELETE CONFIRM MODAL ==================== --}}
<div class="rev-modal-overlay" id="deleteModal">
    <div class="rev-modal">
        <div class="rev-modal-icon">🗑️</div>
        <h5>Delete Review</h5>
        <p id="deleteModalText">Are you sure you want to delete this review?</p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="rev-modal-actions">
                <button type="button" class="btn btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== REAL-TIME NOTIFICATION BANNER ==================== --}}
<div class="rev-notif" id="revNotif">
    <div class="rev-notif-icon">
        <i class="bi bi-star-fill"></i>
    </div>
    <div class="rev-notif-content">
        <span class="rev-notif-text" id="revNotifText">0 new reviews</span>
    </div>
    <div class="rev-notif-actions">
        <button class="rev-notif-btn" id="revNotifBtn" onclick="refreshReviews()">
            <i class="bi bi-arrow-clockwise"></i> Refresh
        </button>
        <button class="rev-notif-close" onclick="dismissNotif()" title="Dismiss">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
</div>

<script>
    // ==================== POLLING CONFIG ====================
    const POLL_INTERVAL = 10000; // 10 seconds
    let lastCheckTime = '{{ now()->toIso8601String() }}';
    let newReviewCount = 0;
    let pollTimer = null;
    let isRefreshing = false;

    // ==================== POLLING FUNCTION ====================
    async function checkNewReviews() {
        try {
            const url = '{{ route('admin.reviews.latest') }}?after=' + encodeURIComponent(lastCheckTime);
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                }
            });

            if (!response.ok) return;

            const data = await response.json();

            if (data.count > 0) {
                newReviewCount += data.count;
                showNotification(newReviewCount);
            }

            // Update server time for next poll
            if (data.server_time) {
                lastCheckTime = data.server_time;
            }
        } catch (e) {
            // Silently fail — don't bother admin with network errors
        }
    }

    // ==================== NOTIFICATION UI ====================
    function showNotification(count) {
        const notif = document.getElementById('revNotif');
        const text = document.getElementById('revNotifText');
        const btn = document.getElementById('revNotifBtn');

        text.textContent = count + ' new review' + (count === 1 ? '' : 's');
        notif.classList.add('active');

        // Pulse animation on the button
        btn.classList.add('pulse');
        setTimeout(() => btn.classList.remove('pulse'), 600);
    }

    function dismissNotif() {
        document.getElementById('revNotif').classList.remove('active');
    }

    // ==================== REFRESH TABLE ====================
    async function refreshReviews() {
        if (isRefreshing) return;
        isRefreshing = true;

        const btn = document.getElementById('revNotifBtn');
        btn.innerHTML = '<i class="bi bi-arrow-clockwise spinning"></i> Refreshing...';
        btn.disabled = true;

        try {
            const response = await fetch(window.location.href, {
                headers: {
                    'Accept': 'text/html',
                    'X-Requested-With': 'XMLHttpRequest',
                }
            });

            if (!response.ok) return;

            const html = await response.text();

            // Extract the table body
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTbody = doc.querySelector('.table-rev tbody');
            const newBadge = doc.querySelector('.rev-count-badge');
            const oldTbody = document.querySelector('.table-rev tbody');
            const oldBadge = document.querySelector('.rev-count-badge');

            if (newTbody) {
                // Animate out
                oldTbody.style.transition = 'opacity 0.2s ease';
                oldTbody.style.opacity = '0';

                setTimeout(() => {
                    oldTbody.innerHTML = newTbody.innerHTML;
                    oldTbody.style.opacity = '1';
                }, 200);
            }

            if (newBadge && oldBadge) {
                oldBadge.innerHTML = newBadge.innerHTML;
            }

            // Reset counter
            newReviewCount = 0;
            dismissNotif();

            // Update last check time using client time
            lastCheckTime = new Date().toISOString();

        } catch (e) {
            // Silently fail
        } finally {
            btn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Refresh';
            btn.disabled = false;
            isRefreshing = false;
        }
    }

    // ==================== START POLLING ====================
    function startPolling() {
        // Initial delay of 5s, then every 10s
        setTimeout(() => {
            checkNewReviews();
            pollTimer = setInterval(checkNewReviews, POLL_INTERVAL);
        }, 5000);
    }

    // ==================== COMMENT TOGGLE ====================
    function toggleComment(id) {
        const comment = document.getElementById('comment-' + id);
        const toggle = document.getElementById('toggle-' + id);
        if (!comment) return;
        if (comment.classList.contains('expanded')) {
            comment.classList.remove('expanded');
            if (toggle) toggle.textContent = 'Read more';
        } else {
            comment.classList.add('expanded');
            if (toggle) toggle.textContent = 'Show less';
        }
    }

    // ==================== DELETE MODAL ====================
    function openDeleteModal(id, name) {
        document.getElementById('deleteModalText').textContent = 'Are you sure you want to delete the review by ' + name + '? This action cannot be undone.';
        document.getElementById('deleteForm').action = '{{ route('admin.reviews.destroy', '__ID__') }}'.replace('__ID__', id);
        document.getElementById('deleteModal').classList.add('active');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }

    // Close modal on overlay click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    // Close modal on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });

    // ==================== INIT ====================
    document.addEventListener('DOMContentLoaded', startPolling);
</script>
@endsection
