<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #6C63FF;
            --secondary: #F5F7FA;
            --text-dark: #2D3436;
            --text-muted: #636E72;
            --card-shadow: 0 4px 20px rgba(0,0,0,0.05);
            --border-color: #E8E8E8;
        }

        body {
            background: var(--secondary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-dark);
        }

        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: white;
            border-right: 1px solid var(--border-color);
            position: fixed;
            left: 0;
            top: 0;
            padding: 30px 20px;
        }

        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
        }

        .sidebar-brand i {
            font-size: 1.8rem;
        }

        .nav-link {
            color: var(--text-muted);
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .nav-link:hover, .nav-link.active {
            background: var(--primary);
            color: white;
        }

        .nav-link i {
            font-size: 1.1rem;
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
        }

        .top-bar {
            background: white;
            border-radius: 16px;
            padding: 20px 30px;
            margin-bottom: 30px;
            box-shadow: var(--card-shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .date-display {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .search-box {
            background: var(--secondary);
            border-radius: 12px;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 300px;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            font-size: 0.9rem;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-actions i {
            font-size: 1.2rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--card-shadow);
            border: none;
            height: 100%;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }

        .stat-card.teal { border-left: 4px solid #00BFA5; }
        .stat-card.blue { border-left: 4px solid #4FC3F7; }
        .stat-card.pink { border-left: 4px solid #FF6B9D; }
        .stat-card.purple { border-left: 4px solid #9C27B0; }

        .stat-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .stat-card.teal .stat-icon { background: #E0F2F1; color: #00BFA5; }
        .stat-card.blue .stat-icon { background: #E1F5FE; color: #4FC3F7; }
        .stat-card.pink .stat-icon { background: #FCE4EC; color: #FF6B9D; }
        .stat-card.purple .stat-icon { background: #F3E5F5; color: #9C27B0; }

        .stat-value {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--text-dark);
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .stat-change {
            font-size: 0.8rem;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stat-change.positive { color: #00C853; }
        .stat-change.negative { color: #DC3545; }

        .content-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--card-shadow);
            border: none;
            margin-bottom: 24px;
        }

        .card-title {
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text-dark);
            font-size: 1.1rem;
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead th {
            background: var(--secondary);
            border: none;
            font-weight: 600;
            color: var(--text-muted);
            padding: 16px;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 16px;
            vertical-align: middle;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: #5A52D5;
        }

        .btn-outline-secondary {
            border-radius: 10px;
            border-color: var(--border-color);
            color: var(--text-muted);
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid var(--border-color);
            padding: 12px 15px;
            background: white;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(108, 99, 255, 0.1);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .progress {
            height: 8px;
            border-radius: 4px;
        }

        .progress-bar {
            background: var(--primary);
        }
    </style>
</head>
<body>
    <div class="d-flex">
        {{-- Sidebar --}}
        <aside class="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <i class="bi bi-shop"></i>
                ShopAdmin
            </a>

            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-grid-fill"></i>
                    Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                    <i class="bi bi-tags-fill"></i>
                    Categories
                </a>
                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                    <i class="bi bi-box-seam-fill"></i>
                    Products
                </a>
                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                    <i class="bi bi-receipt-cutoff"></i>
                    Orders
                </a>
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people-fill"></i>
                    Users
                </a>
                <a class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}" href="{{ route('admin.reviews.index') }}">
                    <i class="bi bi-star-fill"></i>
                    Reviews
                </a>

                <div style="border-top: 1px solid var(--border-color); margin: 1rem 0; padding-top: 0.5rem;"></div>

                <a class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}" href="{{ route('admin.profile.edit') }}">
                    <i class="bi bi-person-circle"></i>
                    My Profile
                </a>
            </nav>

            <div class="mt-auto">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start" style="border: none; background: transparent;">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="main-content flex-grow-1">
            <div class="top-bar">
                <div class="date-display">
                    {{ now()->format('l, F j, Y') }}
                </div>
                <div class="search-box">
                    <i class="bi bi-search text-muted"></i>
                    <input type="text" placeholder="Search...">
                </div>
                @php
                    $currentUser = Auth::user();
                    $avatarInitial = $currentUser ? strtoupper(substr($currentUser->name, 0, 1)) : 'A';
                    $avatarColor = '#6C63FF';
                @endphp
                <div class="user-actions">
                    <div class="notification-group" style="position: relative;">
                        <button id="notif-bell-btn" class="btn-notif-bell" title="Notifications" style="position: relative; background: none; border: none; padding: 6px; border-radius: 10px; cursor: pointer; color: var(--text-muted); transition: all 0.2s ease;" onclick="toggleNotifDropdown()">
                            <i class="bi bi-bell" style="font-size: 1.2rem;"></i>
                            <span id="notif-badge" class="notif-badge" style="display: none; position: absolute; top: 0; right: 0; background: #dc3545; color: white; font-size: 0.6rem; font-weight: 700; min-width: 18px; height: 18px; border-radius: 50%; align-items: center; justify-content: center; border: 2px solid white;"></span>
                        </button>
                        <div id="notif-dropdown" class="notif-dropdown" style="display: none; position: absolute; top: calc(100% + 8px); right: 0; background: white; border-radius: 14px; box-shadow: 0 12px 40px rgba(0,0,0,0.15); min-width: 340px; max-width: 400px; border: 1px solid #f0f0f5; z-index: 1000; overflow: hidden;">
                            <div style="padding: 0.85rem 1rem; border-bottom: 1px solid #f0f0f5; display: flex; justify-content: space-between; align-items: center;">
                                <strong style="font-size: 0.88rem; color: var(--text-dark);">Notifications</strong>
                                <button id="notif-mark-read-btn" onclick="markAllRead()" style="background: none; border: none; color: #6C63FF; font-size: 0.75rem; font-weight: 600; cursor: pointer; padding: 0;">Mark all read</button>
                            </div>
                            <div id="notif-list" style="max-height: 300px; overflow-y: auto;">
                                <div style="padding: 1.5rem; text-align: center; color: var(--text-muted); font-size: 0.85rem;">Loading...</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.profile.edit') }}" class="d-flex align-items-center gap-2 text-decoration-none" title="Edit Profile">
                        <div class="user-avatar" style="background: {{ $currentUser && $currentUser->profile_image ? 'transparent' : $avatarColor }}; cursor: pointer;">
                            @if($currentUser && $currentUser->profile_image)
                                <img src="{{ $currentUser->profile_image_url }}" alt="{{ $currentUser->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            @else
                                {{ $avatarInitial }}
                            @endif
                        </div>
                        <span class="fw-semibold" style="font-size: 0.9rem; color: var(--text-dark);">{{ $currentUser ? $currentUser->name : 'Admin' }}</span>
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger rounded-3 border-0">
                    <strong>Please check the form.</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Notification Polling & Browser Notifications --}}
    <script>
        let lastNotifId = 0;
        let notifPollInterval = null;
        let notifDropdownOpen = false;

        function showNotifBadge(count) {
            const badge = document.getElementById('notif-badge');
            if (count > 0) {
                badge.style.display = 'flex';
                badge.textContent = count > 99 ? '99+' : count;
            } else {
                badge.style.display = 'none';
            }
        }

        function toggleNotifDropdown() {
            const dropdown = document.getElementById('notif-dropdown');
            notifDropdownOpen = !notifDropdownOpen;
            dropdown.style.display = notifDropdownOpen ? 'block' : 'none';
            if (notifDropdownOpen) {
                fetchNotifs();
            }
        }

        function fetchNotifs() {
            fetch('{{ route('admin.notifications.index') }}')
                .then(res => res.json())
                .then(data => {
                    showNotifBadge(data.unread_count);
                    renderNotifList(data.notifications);
                    if (data.notifications.length > 0) {
                        lastNotifId = Math.max(...data.notifications.map(n => n.id));
                    }
                })
                .catch(() => {});
        }

        function renderNotifList(notifications) {
            const list = document.getElementById('notif-list');
            if (notifications.length === 0) {
                list.innerHTML = '<div style="padding: 2rem 1rem; text-align: center; color: var(--text-muted); font-size: 0.85rem;"><div style="font-size: 2rem; margin-bottom: 0.5rem; opacity: 0.3;">🔔</div>No notifications yet</div>';
                return;
            }
            list.innerHTML = notifications.map(n => {
                const data = typeof n.data === 'string' ? JSON.parse(n.data) : n.data;
                const isNew = !n.is_read;
                let html = '';
                if (n.type === 'new_order') {
                    html = `
                        <strong style="color: #6C63FF;">New Order #${data.order_id}</strong>
                        <div style="font-size: 0.78rem; color: var(--text-muted); margin-top: 2px;">
                            {{ '$' }}${parseFloat(data.total_amount).toFixed(2)} from ${data.customer_name}
                        </div>
                    `;
                } else {
                    html = `<div style="font-size: 0.82rem; color: var(--text-dark);">${n.type}</div>`;
                }
                return `
                    <div onclick="markNotifRead(${n.id})" class="notif-item" style="
                        padding: 0.85rem 1rem;
                        border-bottom: 1px solid #f5f5f8;
                        cursor: pointer;
                        transition: background 0.15s ease;
                        background: ${isNew ? '#F8F9FE' : 'transparent'};
                    "
                    onmouseover="this.style.background='#F0F1F9'"
                    onmouseout="this.style.background='${isNew ? '#F8F9FE' : 'transparent'}'">
                        <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                            <div style="
                                width: 34px; height: 34px; border-radius: 10px;
                                background: ${isNew ? '#E0F2F1' : '#f0f0f5'};
                                color: ${isNew ? '#00695C' : 'var(--text-muted)'};
                                display: flex; align-items: center; justify-content: center;
                                flex-shrink: 0; font-size: 0.9rem;
                            ">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                ${html}
                                <div style="font-size: 0.7rem; color: #bbb; margin-top: 4px;">
                                    ${timeAgo(n.created_at)}
                                </div>
                            </div>
                            ${isNew ? '<span style="width: 8px; height: 8px; border-radius: 50%; background: #6C63FF; flex-shrink: 0; margin-top: 4px;"></span>' : ''}
                        </div>
                    </div>
                `;
            }).join('');
        }

        function timeAgo(dateStr) {
            const date = new Date(dateStr);
            const now = new Date();
            const diffMs = now - date;
            const mins = Math.floor(diffMs / 60000);
            if (mins < 1) return 'Just now';
            if (mins < 60) return mins + 'm ago';
            const hrs = Math.floor(mins / 60);
            if (hrs < 24) return hrs + 'h ago';
            const days = Math.floor(hrs / 24);
            return days + 'd ago';
        }

        function markNotifRead(id) {
            fetch('{{ url('admin/notifications') }}/' + id + '/read', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                .then(res => res.json())
                .then(() => {
                    fetchNotifs();
                })
                .catch(() => {});
        }

        function markAllRead() {
            fetch('{{ route('admin.notifications.read-all') }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                .then(res => res.json())
                .then(() => {
                    fetchNotifs();
                })
                .catch(() => {});
        }

        function checkNewNotifs() {
            fetch('{{ route('admin.notifications.index') }}')
                .then(res => res.json())
                .then(data => {
                    const prevBadge = document.getElementById('notif-badge');
                    const prevCount = prevBadge.style.display !== 'none' ? parseInt(prevBadge.textContent) : 0;
                    showNotifBadge(data.unread_count);

                    // Check for truly new notifications (newer than our last seen)
                    const newNotifs = data.notifications.filter(n => n.id > lastNotifId && !n.is_read);
                    if (newNotifs.length > 0 && lastNotifId > 0) {
                        // Show browser notification
                        const latest = newNotifs[0];
                        const notifData = typeof latest.data === 'string' ? JSON.parse(latest.data) : latest.data;
                        showBrowserNotification(notifData);
                        // Refresh badge immediately
                        showNotifBadge(data.unread_count);
                    }

                    if (data.notifications.length > 0) {
                        lastNotifId = Math.max(...data.notifications.map(n => n.id));
                    }

                    // If dropdown is already open, refresh the list
                    if (notifDropdownOpen) {
                        renderNotifList(data.notifications);
                    }
                })
                .catch(() => {});
        }

        function showBrowserNotification(data) {
            if (!("Notification" in window)) return;

            if (Notification.permission === "granted") {
                createNotif(data);
            } else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                        createNotif(data);
                    }
                });
            }
        }

        function createNotif(data) {
            const notif = new Notification("🛒 New Order!", {
                body: `${data.customer_name} placed an order for $${parseFloat(data.total_amount).toFixed(2)}`,
                icon: '/favicon.ico',
                tag: 'order-' + data.order_id,
            });
            notif.onclick = function() {
                window.open('{{ route('admin.orders.index') }}', '_blank');
                this.close();
            };
            // Close after 8 seconds
            setTimeout(() => notif.close(), 8000);
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const group = document.querySelector('.notification-group');
            if (group && !group.contains(e.target)) {
                const dropdown = document.getElementById('notif-dropdown');
                if (dropdown) {
                    dropdown.style.display = 'none';
                    notifDropdownOpen = false;
                }
            }
        });

        // Initialize: request notification permission and start polling
        document.addEventListener('DOMContentLoaded', function() {
            // Request notification permission
            if ("Notification" in window && Notification.permission === "default") {
                Notification.requestPermission();
            }

            // Initial fetch
            fetchNotifs();

            // Poll every 15 seconds
            notifPollInterval = setInterval(checkNewNotifs, 15000);
        });
    </script>

    <style>
        .btn-notif-bell:hover {
            background: #f0f0f5 !important;
            color: var(--text-dark) !important;
        }
        .notif-item:last-child {
            border-bottom: none !important;
        }
    </style>
</body>
</html>
