<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ElectroPOS & Inventory') - Sistem Manajemen Elektronik</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%232563eb'><path d='M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5'/></svg>">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
        }
        .navbar-top {
            background: #0f172a;
            border-bottom: 1px solid #1e293b;
            padding: 0.75rem 1.5rem;
        }
        .sidebar {
            background: #1e293b;
            min-height: calc(100vh - 61px);
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        }
        .sidebar-heading {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: #64748b;
            padding: 1.25rem 1.25rem 0.5rem;
            text-transform: uppercase;
        }
        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 0.7rem 1.25rem;
            font-size: 0.92rem;
            font-weight: 500;
            border-radius: 0.5rem;
            margin: 0.15rem 0.75rem;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }
        .sidebar .nav-link i {
            font-size: 1.1rem;
            margin-right: 0.75rem;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.08);
            color: #ffffff;
        }
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }
        .main-content {
            padding: 1.75rem;
        }
        .card {
            border-radius: 0.75rem;
        }
    </style>
</head>
<body>

    <!-- TOP NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-top sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('dashboard') }}">
                <span class="bg-primary text-white rounded-3 p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                    <i class="bi bi-cpu-fill"></i>
                </span>
                <span>Electro<span class="text-primary">Hub</span> Inventory</span>
            </a>

            <div class="d-flex align-items-center ms-auto">
                <div class="dropdown">
                    <button class="btn btn-dark border border-secondary border-opacity-25 rounded-pill px-3 py-1 d-flex align-items-center gap-2 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle text-info"></i>
                        <span class="small fw-medium">{{ Auth::user()->name ?? 'User' }}</span>
                        <span class="badge bg-primary text-uppercase" style="font-size: 0.65rem;">{{ Auth::user()->role ?? 'staff' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        @if(Route::has('profile.edit'))
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-gear me-2 text-secondary"></i> Pengaturan Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger fw-medium">
                                    <i class="bi bi-box-arrow-right me-2"></i> Keluar (Logout)
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- SIDEBAR MENU LENGKAP -->
            <div class="col-md-3 col-lg-2 p-0 sidebar">
                <nav class="nav flex-column py-2">
                    <div class="sidebar-heading">Menu Utama</div>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>

                    <div class="sidebar-heading">Master Inventory</div>
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="bi bi-laptop"></i> Produk Elektronik
                    </a>

                    @if(Auth::user() && in_array(Auth::user()->role, ['owner', 'admin']))
                        <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                            <i class="bi bi-tags-fill"></i> Kategori Barang
                        </a>

                        @if(Route::has('suppliers.index'))
                            <a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                                <i class="bi bi-buildings-fill"></i> Data Supplier
                            </a>
                        @endif

                        @if(Route::has('users.index'))
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <i class="bi bi-people-fill"></i> Kelola Staf / Kasir
                            </a>
                        @endif
                    @endif

                    <div class="sidebar-heading">Transaksi & Stok</div>
                    @if(Route::has('purchases.index'))
                        <a href="{{ route('purchases.index') }}" class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
                            <i class="bi bi-box-arrow-in-down"></i> Pembelian (Stock-In)
                        </a>
                    @endif

                    @if(Route::has('sales.index'))
                        <a href="{{ route('sales.index') }}" class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                            <i class="bi bi-cart-check-fill"></i> Penjualan (Sales)
                        </a>
                    @endif

                    <li class="nav-item mt-2">
                        <a class="nav-link text-white" href="{{ route('admin.orders') }}">
                            <i class="bi bi-box-seam me-2"></i> Pesanan Web
                        </a>
                    </li>

                    @if(Auth::user() && Auth::user()->role === 'admin' && Route::has('users.index'))
                        <div class="sidebar-heading">Administrator</div>
                        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="bi bi-people-fill"></i> Kelola Pengguna
                        </a>
                    @endif
                </nav>
            </div>

            <!-- KONTEN UTAMA -->
            <div class="col-md-9 col-lg-10 main-content">
                @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-octagon-fill fs-5 me-2"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>