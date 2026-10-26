<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembayaran Lunas - {{ $order->order_code }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light py-5">
<div class="container" style="max-width: 550px;">
    <div class="card border-0 shadow rounded-4 overflow-hidden">
        <div class="bg-success text-white p-4 text-center">
            <i class="bi bi-patch-check-fill display-4 mb-2"></i>
            <h4 class="fw-bold mb-0">Pembayaran Sukses!</h4>
            <small class="text-white-50">Stok barang di kasir telah terpotong otomatis.</small>
        </div>

        <div class="p-4 bg-white">
            <div class="d-flex justify-content-between mb-2 small text-muted">
                <span>Nomor Order:</span>
                <span class="font-monospace fw-bold text-dark">{{ $order->order_code }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2 small text-muted">
                <span>Nama Penerima:</span>
                <span class="fw-bold text-dark">{{ $order->customer_name }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2 small text-muted">
                <span>Status Pesanan:</span>
                <span class="badge bg-success">LUNAS / COMPLETED</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-1">
                <span class="fw-semibold text-dark">{{ $order->product->name }}</span>
                <span class="fw-bold">x{{ $order->quantity }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <span class="text-muted small">Total Dibayar:</span>
                <span class="fs-5 fw-bold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>

            <div class="d-grid gap-2">
                <a href="{{ route('shop.index') }}" class="btn btn-primary fw-semibold rounded-3 py-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali Belanja ke Katalog
                </a>
                <button onclick="window.print()" class="btn btn-outline-secondary btn-sm rounded-3">
                    <i class="bi bi-printer me-1"></i> Cetak Bukti Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>
</body>
</html>