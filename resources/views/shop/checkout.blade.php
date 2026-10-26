<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Unit - {{ $product->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light py-5">
<div class="container" style="max-width: 900px;">
    
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog
        </a>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill small">
            <i class="bi bi-shield-check me-1"></i> Guest Checkout (Tanpa Wajib Akun)
        </span>
    </div>

    <div class="row g-4">
        <!-- Form Data Pembeli & Metode Pembayaran -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-3 text-dark">Data Pengiriman & Pembeli</h5>
                
                <form action="{{ route('checkout.store', $product->id) }}" method="POST" novalidate>
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-3 shadow-sm rounded-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Input Nama Pemesan -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                        <input type="text" name="customer_name" class="form-control rounded-3" 
                            value="{{ auth()->check() ? auth()->user()->name : old('customer_name') }}" required>
                    </div>
            
                    <!-- Input Kontak WhatsApp -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nomor WhatsApp Aktif</label>
                        <input type="text" name="customer_phone" class="form-control rounded-3" 
                            value="{{ old('customer_phone') }}" placeholder="08xxxxxxxxxx" required>
                    </div>

                    <!-- Input Alamat Pengiriman -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Alamat Tujuan Pengiriman</label>
                        <textarea name="customer_address" rows="3" class="form-control rounded-3" required 
                                placeholder="Jalan, Nomor Rumah, Kecamatan, Kota">{{ old('customer_address') }}</textarea>
                    </div>

                    <h5 class="fw-bold mb-3 text-dark">Pilih Metode Pembayaran</h5>
                    
                    <!-- OPSI 2: Dummy Gateway (Sangat Dianjurkan Saat Demo UTS) -->
                    <div class="border rounded-3 p-3 mb-2 bg-light">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="payDummyQris" value="dummy_qris" checked>
                            <label class="form-check-label fw-bold d-block text-dark" for="payDummyQris">
                                Simulasi QRIS Instan
                            </label>
                            <small class="text-muted d-block" style="font-size: 0.75rem;">
                                Menampilkan simulasi QRIS & tombol konfirmasi instan. Stok otomatis terpotong saat berhasil dibayar.
                            </small>
                        </div>
                    </div>

                    <div class="border rounded-3 p-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="payDummyVa" value="dummy_va">
                            <label class="form-check-label fw-bold d-block text-dark" for="payDummyVa">
                                Simulasi Virtual Account (BCA / Mandiri)
                            </label>
                            <small class="text-muted d-block" style="font-size: 0.75rem;">
                                Menampilkan nomor VA dummy untuk simulasi transfer perbankan.
                            </small>
                        </div>
                    </div>

                    <!-- OPSI 1: Midtrans Sandbox -->
                    <div class="border rounded-3 p-3 mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="payMidtrans" value="midtrans">
                            <label class="form-check-label fw-bold d-block text-dark" for="payMidtrans">
                                Midtrans Snap Sandbox (Real Payment Gateway API)
                            </label>
                            <small class="text-muted d-block" style="font-size: 0.75rem;">
                                Menampilkan popup Snap resmi Midtrans dengan kartu kredit uji coba dan simulator bank.
                            </small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2-5 fw-bold shadow-sm rounded-3">
                        Lanjut ke Pembayaran <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Ringkasan Produk -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold text-secondary text-uppercase small mb-3">Ringkasan Pesanan</h6>
                
                <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=200' }}" 
                         class="rounded-3 border" style="width: 70px; height: 70px; object-fit: contain;">
                    <div>
                        <div class="fw-bold text-dark small text-truncate" style="max-width: 180px;">{{ $product->name }}</div>
                        <small class="text-muted font-monospace d-block">{{ $product->sku }}</small>
                        <span class="badge bg-success-subtle text-success small mt-1">Stok Tersedia: {{ $product->stock }}</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between mb-2 small text-secondary">
                    <span>Harga Satuan:</span>
                    <span class="fw-semibold text-dark">Rp {{ number_format($product->price ?? $product->selling_price, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 small text-secondary">
                    <span>Biaya Pengiriman:</span>
                    <span class="text-success fw-bold">GRATIS</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-dark">Total Tagihan:</span>
                    <span class="fw-bold text-primary fs-5">
                        Rp {{ number_format($product->price ?? $product->selling_price, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>