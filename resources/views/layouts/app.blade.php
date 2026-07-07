<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mobile Shop') — Mobile Shop Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #4946aa; }
        .sidebar .nav-link { color: #ccc; padding: .6rem 1rem; border-radius: 6px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #0f3460; color: #fff; }
        .sidebar .nav-link i { margin-right: 8px; }
        .sidebar-brand { color: #e94560; font-weight: 700; font-size: 1.2rem; padding: 1.2rem 1rem; display: block; }
        .main-content { min-height: 100vh; }
        .badge-due { background: #dc3545; }
        .stat-card { border-left: 4px solid; border-radius: 8px; }
    </style>
    @stack('styles')
</head>
<body>
<div class="container-fluid p-0">
    <div class="row g-0">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar py-3 px-2">
            <a href="{{ route('dashboard') }}" class="sidebar-brand text-decoration-none">
                <i class="bi bi-phone"></i> Apple Mobiles
            </a>
            <ul class="nav flex-column gap-1 mt-2">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <small class="text-muted px-3 text-uppercase" style="font-size:.7rem">Inventory</small>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('stock.*') ? 'active' : '' }}" href="{{ route('stock.index') }}">
                        <i class="bi bi-box-seam"></i> Stock
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <small class="text-muted px-3 text-uppercase" style="font-size:.7rem">People</small>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dealers.*') ? 'active' : '' }}" href="{{ route('dealers.index') }}">
                        <i class="bi bi-building"></i> Dealers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                        <i class="bi bi-people"></i> Customers
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <small class="text-muted px-3 text-uppercase" style="font-size:.7rem">Transactions</small>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dealer-transactions.*') ? 'active' : '' }}" href="{{ route('dealer-transactions.index') }}">
                        <i class="bi bi-arrow-down-circle"></i> Purchases
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                        <i class="bi bi-cart-check"></i> Sales
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <small class="text-muted px-3 text-uppercase" style="font-size:.7rem">Finance</small>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class="bi bi-bar-chart"></i> Reports
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 main-content p-4">
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

            @yield('content')
        </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
