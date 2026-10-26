<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroHub Store - Katalog Resmi & Ketersediaan Stok</title>
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%232563eb'><path d='M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5'/></svg>">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- 1. Header & Navigation Bar -->
    <header class="border-bottom bg-white sticky-top py-2-5 shadow-sm">
        <div class="container-xl py-1">
            <div class="d-flex align-items-center justify-content-between gap-3">
                
                <!-- Logo Brand -->
                <a class="navbar-brand fw-bold d-flex align-items-center gap-2 text-decoration-none" href="{{ url('/') }}">
                    <div class="bg-primary text-white rounded-3 p-1-5 d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 36px; height: 36px;">
                        <i class="bi bi-cpu-fill fs-5"></i>
                    </div>
                    <span class="fs-5 text-dark fw-bold"><span class="text-primary">Electro</span>Hub Store</span>
                </a>

                <!-- Search Bar Fungsional -->
                <form action="{{ route('shop.index') }}" method="GET" class="d-none d-md-flex align-items-center m-0 flex-grow-1 justify-content-center">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="search-input-group d-flex align-items-center gap-2">
                        <i class="bi bi-search text-muted"></i>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari nama laptop, aksesoris, atau seri brand..." class="w-100 py-1">
                        @if(request('search'))
                            <a href="{{ route('shop.index', ['category' => request('category')]) }}" class="text-muted text-decoration-none small">&times;</a>
                        @endif
                    </div>
                </form>

                <!-- Tombol Navigasi Kanan (Beranda & Akun) -->
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1-5 fw-medium d-none d-sm-inline-flex align-items-center gap-1">
                        <i class="bi bi-house"></i>
                        <span>Beranda</span>
                    </a>

                    @auth
                        <div class="dropdown">
                            <button class="btn btn-outline-dark btn-sm rounded-pill px-3 py-1-5 dropdown-toggle d-flex align-items-center gap-2" 
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-check-fill text-primary"></i>
                                <span class="fw-semibold">{{ Auth::user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2">
                                <li><span class="dropdown-item-text small text-muted">Akun Pelanggan</span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger small d-flex align-items-center gap-2">
                                            <i class="bi bi-box-arrow-right"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm rounded-pill px-3 py-1-5 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Akun
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </header>

    <!-- 2. Katalog Content Section -->
    <main class="container-xl py-4 flex-grow-1">
        
        <!-- Header Judul & Status Retail -->
        <div class="row align-items-end justify-content-between mb-4 gy-3">
            <div class="col-lg-8">
                <span class="badge bg-light text-secondary border px-2 py-1 small fw-semibold text-uppercase mb-2" style="font-size: 0.68rem; letter-spacing: 0.8px;">
                    Katalog Retail Resmi
                </span>
                <h3 class="fw-bold text-dark mb-1">Daftar Perangkat & Unit Hardware</h3>
                <p class="text-secondary small mb-0">
                    Semua unit terjamin orisinal dengan garansi distributor terdaftar. Ketersediaan stok diperbarui secara berkala.
                </p>
            </div>
            
            <div class="col-lg-4 text-lg-end">
                <div class="d-inline-flex gap-3 text-start border-start ps-3 py-1 border-secondary border-opacity-25">
                    <div>
                        <div class="fw-bold text-dark small">100% Bergaransi</div>
                        <div class="text-muted" style="font-size: 0.72rem;">Distributor Resmi</div>
                    </div>
                    <div class="border-start ps-3 border-secondary border-opacity-25">
                        <div class="fw-bold text-dark small">Stok Sinkron</div>
                        <div class="text-muted" style="font-size: 0.72rem;">Update POS Kasir</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Kategori Modern (Pill Style) -->
        <div class="mb-4">
            <div class="filter-scroll-container">
                <a href="{{ route('shop.index', ['search' => request('search')]) }}" 
                   class="filter-pill {{ !request('category') ? 'active' : '' }}">
                    <span>Semua Kategori</span>
                    @if(isset($categories))
                        <span class="filter-count-badge">{{ $categories->sum('products_count') }}</span>
                    @endif
                </a>

                @if(isset($categories))
                    @foreach($categories as $category)
                        <a href="{{ route('shop.index', ['category' => $category->id, 'search' => request('search')]) }}" 
                           class="filter-pill {{ request('category') == $category->id ? 'active' : '' }}">
                            <span>{{ $category->name }}</span>
                            <span class="filter-count-badge">{{ $category->products_count ?? $category->products->count() }}</span>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Daftar Grid Produk -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse($products as $product)
                <div class="col">
                    <div class="product-card">
                        
                        <!-- Wadah Gambar & Lencana Stok Dinamis -->
                        <div class="product-img-wrapper">
                            <div class="product-badge-container">
                                @if($product->stock > 5)
                                    <span class="badge badge-stock-ready rounded-pill px-2 py-1 d-inline-flex align-items-center gap-1 shadow-sm">
                                        <i class="bi bi-check-circle-fill"></i> Ready Stock
                                    </span>
                                @elseif($product->stock > 0)
                                    <span class="badge badge-stock-urgent rounded-pill px-2 py-1 d-inline-flex align-items-center gap-1 shadow-sm">
                                        <i class="bi bi-fire"></i> Sisa {{ $product->stock }} Unit
                                    </span>
                                @else
                                    <span class="badge badge-stock-empty rounded-pill px-2 py-1 d-inline-flex align-items-center gap-1 shadow-sm">
                                        <i class="bi bi-x-circle"></i> Stok Habis
                                    </span>
                                @endif
                            </div>

                            @if(!empty($product->image))
                                <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . ltrim(str_replace('storage/', '', $product->image), '/')) }}" 
                                    alt="{{ $product->name }}" 
                                    class="product-img"
                                    style="object-fit: contain; background-color: #ffffff;"
                                    onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=600';">
                            @else
                                <img src="https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=600" 
                                    alt="{{ $product->name }}" 
                                    class="product-img"
                                    style="object-fit: contain; background-color: #ffffff;">
                            @endif
                        </div>

                        <!-- Detail Produk -->
                        <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="text-primary fw-bold text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                        {{ $product->category->name ?? 'HARDWARE' }}
                                    </span>
                                    @if($product->sku)
                                        <small class="text-muted" style="font-size: 0.68rem;">{{ $product->sku }}</small>
                                    @endif
                                </div>

                                <h6 class="fw-bold text-dark text-truncate mb-1" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </h6>
                                <p class="text-secondary small line-clamp-2 mb-2" style="font-size: 0.78rem;">
                                    {{ $product->description ?? 'Unit resmi bergaransi distributor Indonesia.' }}
                                </p>
                            </div>

                            <div class="pt-2 border-top">
                                <div class="d-flex justify-content-between align-items-baseline mb-2">
                                    <small class="text-muted" style="font-size: 0.72rem;">Harga Resmi:</small>
                                    <span class="fw-bold text-dark fs-6">
                                        Rp {{ number_format($product->price ?? $product->selling_price, 0, ',', '.') }}
                                    </span>
                                </div>

                                @if($product->stock > 0)
                                    <a href="{{ route('checkout.show', $product->id) }}" class="btn btn-primary w-100 btn-sm rounded-3 py-1-5 fw-semibold d-flex align-items-center justify-content-center gap-1 shadow-sm">
                                        <i class="bi bi-cart2"></i>
                                        <span>Beli Sekarang</span>
                                    </a>
                                @else
                                    <button class="btn btn-light text-muted w-100 btn-sm rounded-3 py-1-5 fw-medium d-flex align-items-center justify-content-center gap-1 border" disabled>
                                        <i class="bi bi-slash-circle"></i>
                                        <span>Stok Habis</span>
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center">
                    <div class="p-5 bg-light rounded-4 border">
                        <i class="bi bi-box-seam text-secondary fs-1 d-block mb-3"></i>
                        <h5 class="fw-bold text-dark">Tidak Ada Produk Ditemukan</h5>
                        <p class="text-muted small mb-3">Coba ubah kata kunci pencarian atau pilih kategori yang lain.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-primary btn-sm px-4 rounded-pill">Reset Filter</a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Paginasi Data -->
        @if(method_exists($products, 'hasPages') && $products->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links() }}
            </div>
        @endif

    </main>

    <!-- 3. Footer Toko Publik -->
    <footer class="bg-white border-top py-3 text-center">
        <div class="container-xl">
            <p class="text-muted small mb-0" style="font-size: 0.78rem;">
                &copy; {{ date('Y') }} <strong>ElectroHub Retail System</strong>. Terintegrasi langsung dengan inventaris gudang.
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>