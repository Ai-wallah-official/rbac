<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - RBAC System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            box-shadow: 2px 0 10px rgba(0,0,0,0.3);
        }
        .sidebar .brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar .brand h5 {
            color: #fff;
            margin: 0;
            font-weight: 700;
            font-size: 1.1rem;
        }
        .sidebar .brand small {
            color: #8892b0;
            font-size: 0.75rem;
        }
        .sidebar .nav-link {
            color: #8892b0;
            padding: 0.6rem 1.5rem;
            border-radius: 0;
            transition: all 0.2s;
            font-size: 0.875rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.1);
            padding-left: 2rem;
        }
        .sidebar .nav-link i { margin-right: 8px; width: 16px; }
        .sidebar .nav-section {
            color: #4a5568;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 1rem 1.5rem 0.25rem;
        }
        .main-content {
            margin-left: 260px;
            padding: 0;
        }
        .topbar {
            background: #fff;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .page-content { padding: 1.5rem; }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        .stat-card {
            border-radius: 12px;
            padding: 1.5rem;
            color: white;
            border: none;
        }
        .stat-card .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        .stat-card .stat-number {
            font-size: 2rem;
            font-weight: 700;
        }
        .btn { border-radius: 8px; }
        .badge { border-radius: 6px; }
        .table th { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; color: #718096; }
        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            object-fit: cover;
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<nav class="sidebar">
    <div class="brand">
        <h5><i class="bi bi-shield-check text-primary"></i> RBAC System</h5>
        <small>{{ ucfirst(auth()->user()->getRoleNames()->first()) }} Panel</small>
    </div>

    <ul class="nav flex-column mt-3">
        <li class="nav-section">Main</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
        </li>

        <li class="nav-section">Catalog</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
               href="{{ route('admin.products.index') }}">
                <i class="bi bi-box-seam"></i> Products
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
               href="{{ route('admin.categories.index') }}">
                <i class="bi bi-tags"></i> Categories
            </a>
        </li>

        @can('view users')
        <li class="nav-section">Administration</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
               href="{{ route('admin.users.index') }}">
                <i class="bi bi-people"></i> Users
            </a>
        </li>
        @endcan

        <li class="nav-section">Store</li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.index') }}" target="_blank">
                <i class="bi bi-shop"></i> View Store
            </a>
        </li>
    </ul>

    <div class="p-3 mt-auto" style="position:absolute; bottom:0; width:100%;">
        <div class="d-flex align-items-center mb-2">
            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2"
                 style="width:32px;height:32px;">
                <span class="text-white" style="font-size:0.8rem;">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </span>
            </div>
            <div>
                <div style="color:#fff;font-size:0.8rem;">{{ auth()->user()->name }}</div>
                <div style="color:#8892b0;font-size:0.7rem;">{{ auth()->user()->getRoleNames()->first() }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-secondary w-100">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </div>
</nav>

<!-- Main Content -->
<div class="main-content">
    <!-- Topbar -->
    <div class="topbar">
        <div>
            <h6 class="mb-0 fw-semibold">@yield('page-title', 'Dashboard')</h6>
            <small class="text-muted">@yield('page-subtitle', '')</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary">{{ auth()->user()->getRoleNames()->first() }}</span>
        </div>
    </div>

    <!-- Alerts -->
    <div class="page-content pb-0">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Page Content -->
    <div class="page-content">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>