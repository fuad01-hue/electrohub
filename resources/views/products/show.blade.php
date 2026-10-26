@extends('layouts.app')

@section('title', 'Detail Produk - ' . $product->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Detail Spesifikasi Produk</h3>
        <p class="text-muted small mb-0">Informasi lengkap perangkat elektronik dan status ketersediaan stok.</p>
    </div>
    <div class="d-flex gap-2">
        @if(Auth::user() && Auth::user()->role === 'admin')
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                <i class="bi bi-pencil-square me-1"></i> Edit Produk
            </a>
        @endif
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="row g-4 align-items-center">
            <div class="col-md-4 text-center">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded-3 border p-2 bg-white shadow-sm" style="max-height: 280px; object-fit: contain;">
                @else
                    <div class="border rounded-3 bg-light d-flex flex-column align-items-center justify-content-center p-5 text-secondary" style="height: 260px;">
                        <i class="bi bi-laptop display-1 mb-2"></i>
                        <span class="small">Tidak ada gambar produk</span>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-dark font-monospace px-3 py-2">{{ $product->sku }}</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">{{ $product->category->name ?? 'Tanpa Kategori' }}</span>
                    @if($product->brand)
                        <span class="badge bg-secondary bg-opacity-10 text-dark border px-3 py-2">{{ $product->brand }}</span>
                    @endif
                </div>

                <h2 class="fw-bold mb-3">{{ $product->name }}</h2>

                <div class="bg-light rounded-3 p-3 mb-4 border">
                    <div class="text-muted small fw-bold text-uppercase mb-1">Spesifikasi Teknis:</div>
                    <p class="mb-0 text-dark">{{ $product->specifications ?: 'Belum ada catatan spesifikasi teknis untuk produk ini.' }}</p>
                </div>

                <div class="row g-3">
                    <div class="col-sm-4">
                        <div class="p-3 border rounded-3">
                            <span class="text-muted small d-block">Harga Beli (Modal)</span>
                            <strong class="fs-5 text-dark">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-3 border rounded-3 bg-success bg-opacity-10 border-success border-opacity-25">
                            <span class="text-success small d-block">Harga Jual Resmi</span>
                            <strong class="fs-5 text-success">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-3 border rounded-3 {{ $product->stock <= $product->minimum_stock ? 'bg-danger bg-opacity-10 border-danger' : '' }}">
                            <span class="text-muted small d-block">Stok Tersedia (Min: {{ $product->minimum_stock }})</span>
                            <strong class="fs-5 {{ $product->stock <= $product->minimum_stock ? 'text-danger' : 'text-dark' }}">
                                {{ $product->stock }} Unit
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection