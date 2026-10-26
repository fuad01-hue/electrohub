<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroHub - Authorized Computer & Hardware Retailer</title>
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%232563eb'><path d='M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5'/></svg>">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- 1. Header & Navigasi -->
    <header class="navbar-landing sticky-top bg-white py-2 shadow-sm" style="z-index: 1030;">
        <div class="container-xl">
            <div class="d-flex align-items-center justify-content-between">
                
                <!-- Logo Brand -->
                <a class="d-flex align-items-center gap-2 text-decoration-none" href="{{ url('/') }}">
                    <div class="bg-primary text-white rounded-3 p-1-5 d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
                        <i class="bi bi-cpu-fill fs-5"></i>
                    </div>
                    <span class="fs-5 text-dark fw-bold"><span class="text-primary">Electro</span>Hub</span>
                </a>

                <!-- Navigasi Tengah -->
                <nav class="d-none d-md-flex align-items-center gap-4">
                    <a href="{{ url('/') }}" class="text-dark text-decoration-none small fw-semibold">Beranda</a>
                    <a href="#produk-pilihan" class="text-secondary text-decoration-none small fw-medium">Produk Pilihan</a>
                    <a href="#keunggulan" class="text-secondary text-decoration-none small fw-medium">Keunggulan Layanan</a>
                    <a href="{{ route('shop.index') }}" class="text-secondary text-decoration-none small fw-medium">Katalog Toko</a>
                </nav>

                <!-- Tombol Aksi Kanan -->
                <div class="d-flex align-items-center gap-2">
                    <a href="https://wa.me/6289528171583" target="_blank" class="btn btn-outline-dark btn-sm rounded-pill px-3 py-1-5 fw-medium d-none d-sm-inline-flex align-items-center gap-1">
                        <i class="bi bi-whatsapp text-success"></i>
                        <span>WhatsApp Sales</span>
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm rounded-pill px-3 py-1-5 fw-semibold d-inline-flex align-items-center gap-1 shadow-sm">
                        <i class="bi bi-person-circle"></i>
                        <span>login</span>
                    </a>
                </div>

            </div>
        </div>
    </header>

    <!-- 2. Hero Section -->
    <section class="hero-section">
        <div class="container-xl">
            <div class="row align-items-center gy-4">
                <div class="col-lg-8 mx-auto text-center">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1-5 rounded-pill small fw-semibold text-uppercase mb-3" style="font-size: 0.72rem; letter-spacing: 0.6px;">
                        Distributor Perangkat & Komponen Resmi
                    </span>
                    <h1 class="display-5 fw-bold text-dark lh-sm mb-3">
                        Pusat Hardware & Laptop Performa Tinggi
                    </h1>
                    <p class="lead text-secondary fs-6 mb-4 pe-lg-5">
                        Menyediakan lini laptop gaming, workstation, kartu grafis, dan media penyimpanan terbaru dengan jaminan garansi resmi distributor Indonesia serta ketersediaan stok fisik aktual.
                    </p>
                    <div class="d-flex flex-wrap align-items-center justify-content-center gap-3">
                        <a href="{{ route('shop.index') }}" class="btn btn-primary px-4 py-2-5 rounded-pill fw-semibold shadow-sm d-inline-flex align-items-center gap-2">
                            <span>Jelajahi Katalog Toko</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="#keunggulan" class="btn btn-outline-secondary px-4 py-2-5 rounded-pill fw-medium">
                            Pelajari Layanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Mitra Brand Resmi (Logo Bar) -->
    <section class="py-4 border-bottom bg-white">
        <div class="container-xl">
            <p class="text-center text-muted text-uppercase fw-semibold mb-3" style="font-size: 0.68rem; letter-spacing: 1px;">
                Mitra Resmi Distributor & Brand Global
            </p>
            <div class="d-flex flex-wrap align-items-center justify-content-center gap-4 gap-md-5">
                <span class="brand-logo-item fw-bold fs-5 text-secondary">ASUS ROG</span>
                <span class="brand-logo-item fw-bold fs-5 text-secondary">LENOVO LEGION</span>
                <span class="brand-logo-item fw-bold fs-5 text-secondary">SAMSUNG MEMORY</span>
                <span class="brand-logo-item fw-bold fs-5 text-secondary">LG ULTRAGEAR</span>
                <span class="brand-logo-item fw-bold fs-5 text-secondary">INTEL CORE</span>
                <span class="brand-logo-item fw-bold fs-5 text-secondary">NVIDIA GEFORCE</span>
            </div>
        </div>
    </section>

    <!-- 4. Produk Pilihan Minggu Ini -->
    <section class="py-5 bg-light" id="produk-pilihan">
        <div class="container-xl py-3">
            <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between mb-4">
                <div>
                    <span class="text-primary fw-bold text-uppercase small" style="font-size: 0.75rem; letter-spacing: 0.8px;">
                        Koleksi Unggulan
                    </span>
                    <h3 class="fw-bold text-dark mb-1">Produk Pilihan Minggu Ini</h3>
                    <p class="text-secondary small mb-0">Unit perangkat keras resmi paling diminati dengan garansi penuh.</p>
                </div>
                <div class="mt-3 mt-md-0">
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1-5 fw-semibold d-inline-flex align-items-center gap-1">
                        <span>Lihat Semua Produk</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>

            @php
                $featuredProducts = \App\Models\Product::with('category')->latest()->take(4)->get();
                $defaultImages = [
                    asset('storage/products/FeqWeMykZN9CG124UmjXfCo35PAkqj00S46WUh1y.jpg'), // ROG Laptop
                    'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=600',       // Lenovo LOQ Laptop
                    'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=600',       // Gaming Monitor
                    'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=600',       // SSD Storage
                ];
            @endphp

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                @forelse($featuredProducts as $product)
                    @php
                        if (!empty($product->image) && !str_contains($product->image, 'unsplash.com')) {
                            if (str_starts_with($product->image, 'http')) {
                                $imgSrc = $product->image;
                            } else {
                                $cleanPath = ltrim(str_replace('storage/', '', $product->image), '/');
                                $imgSrc = asset('storage/' . $cleanPath);
                            }
                        } else {
                            $imgSrc = $defaultImages[$loop->index % count($defaultImages)];
                        }
                    @endphp
                    <div class="col">
                        <div class="showcase-card h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="showcase-img-box bg-white p-2 d-flex align-items-center justify-content-center" style="height: 190px; overflow: hidden; position: relative;">
                                    <!-- Badge Status (Tetap di Depan) -->
                                    <div class="showcase-badge-container" style="position: absolute; top: 10px; right: 10px; z-index: 2;">
                                        @if($product->stock > 0)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle small">
                                                Ready Stock
                                            </span>
                                        @else
                                            <span class="badge bg-secondary small">Stok Habis</span>
                                        @endif
                                    </div>

                                    <!-- Gambar Produk Dinamis -->
                                    <img src="{{ $imgSrc }}" 
                                    alt="{{ $product->name }}" 
                                    class="showcase-img"
                                    style="max-height: 170px; width: auto; max-width: 100%; object-fit: contain;"
                                    onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=600';">
                                </div>

                                <div class="p-3">
                                    <span class="text-primary fw-bold text-uppercase d-block mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                        {{ $product->category->name ?? 'HARDWARE' }}
                                    </span>
                                    <h6 class="fw-bold text-dark text-truncate mb-1" title="{{ $product->name }}">
                                        {{ $product->name }}
                                    </h6>
                                    <small class="text-muted d-block text-truncate mb-2" style="font-size: 0.78rem;">
                                        {{ $product->description ?? 'Unit baru bersegel garansi distributor resmi.' }}
                                    </small>
                                </div>
                            </div>

                            <div class="p-3 pt-0">
                                <hr class="my-2 border-secondary border-opacity-10">
                                <div class="d-flex align-items-baseline justify-content-between mb-2">
                                    <span class="text-muted small" style="font-size: 0.72rem;">Harga Resmi:</span>
                                    <span class="fw-bold text-dark fs-6">
                                        Rp {{ number_format($product->price ?? $product->selling_price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <a href="{{ route('shop.index') }}" class="btn btn-dark w-100 btn-sm rounded-3 py-1-5 fw-semibold d-flex align-items-center justify-content-center gap-1">
                                    <i class="bi bi-cart2"></i>
                                    <span>Lihat di Toko</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">Katalog unit produk siap ditinjau di halaman etalase.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-primary btn-sm rounded-pill">Buka Katalog Toko</a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 5. Keunggulan Layanan Retail (Nilai Bisnis) -->
    <section class="py-5 bg-white" id="keunggulan">
        <div class="container-xl py-3">
            <div class="text-center max-w-700 mx-auto mb-5">
                <span class="text-primary fw-bold text-uppercase small" style="font-size: 0.75rem; letter-spacing: 0.8px;">
                    Standar Operasional
                </span>
                <h3 class="fw-bold text-dark mt-1">Mengapa Memilih ElectroHub</h3>
                <p class="text-secondary small">
                    Komitmen kami memberikan transparansi inventaris, kemudahan transaksi, dan jaminan produk orisinal.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="value-card h-100">
                        <div class="bg-primary-subtle text-primary rounded-3 p-3 d-inline-flex mb-3">
                            <i class="bi bi-patch-check-fill fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">100% Distributor Resmi</h5>
                        <p class="text-secondary small mb-0 lh-base">
                            Semua unit hardware, laptop, dan komponen diimpor dan didistribusikan melalui jalur resmi bergaransi purna jual terdaftar di seluruh Indonesia.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="value-card h-100">
                        <div class="bg-success-subtle text-success rounded-3 p-3 d-inline-flex mb-3">
                            <i class="bi bi-arrow-repeat fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Ketersediaan Stok Sinkron</h5>
                        <p class="text-secondary small mb-0 lh-base">
                            Informasi unit pada katalog terhubung langsung dengan sistem kasir operasional gerai, memastikan ketersediaan barang akurat tanpa risiko pembatalan pesanan.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="value-card h-100">
                        <div class="bg-warning-subtle text-warning-emphasis rounded-3 p-3 d-inline-flex mb-3">
                            <i class="bi bi-headset fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Konsultasi Spesifikasi</h5>
                        <p class="text-secondary small mb-0 lh-base">
                            Didukung tim spesialis hardware untuk membantu pemilihan komponen yang tepat sesuai kebutuhan komputasi, workstation, atau gaming Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Footer Komersial -->
    <footer class="bg-dark text-white border-top py-4 mt-auto">
        <div class="container-xl">
            <div class="row gy-3 align-items-center justify-content-between">
                <div class="col-md-6 text-center text-md-start">
                    <div class="d-inline-flex align-items-center gap-2 mb-1">
                        <div class="bg-primary text-white rounded-2 p-1 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                            <i class="bi bi-cpu-fill small"></i>
                        </div>
                        <span class="fw-bold">ElectroHub Retail Enterprise</span>
                    </div>
                    <p class="text-secondary small mb-0" style="font-size: 0.78rem;">
                        Platform retail hardware dan terminal kasir terpadu.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <span class="text-secondary small" style="font-size: 0.78rem;">
                        &copy; {{ date('Y') }} ElectroHub Store. Hak Cipta Dilindungi.
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>