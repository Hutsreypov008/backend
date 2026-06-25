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
                <div class="user-actions">
                    <i class="bi bi-bell"></i>
                    <div class="user-avatar">A</div>
                    <span class="fw-semibold" style="font-size: 0.9rem;">Admin</span>
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
</body>
</html>
