<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Payment - {{ $order->order_code }}</title>
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f1f5f9;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: #0f172a;
        }
        .payment-card {
            max-width: 480px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        .payment-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 24px 28px;
            color: #ffffff;
        }
        .sandbox-pill {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.3);
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.6px;
            padding: 4px 10px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .qr-frame {
            background: #ffffff;
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 20px;
            display: inline-block;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        }
        .copy-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
        }
    </style>
</head>
<body>

<div class="container px-3">
    <div class="payment-card">
        
        <!-- Header Gateway -->
        <div class="payment-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary text-white rounded-3 p-1 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                        <i class="bi bi-shield-check fs-6"></i>
                    </div>
                    <span class="fw-bold tracking-tight">ElectroHub Pay</span>
                </div>
                <span class="sandbox-pill">
                    <i class="bi bi-code-slash"></i> SANDBOX MODE
                </span>
            </div>

            <div class="d-flex align-items-end justify-content-between">
                <div>
                    <span class="text-secondary small d-block" style="font-size: 0.75rem;">Total Pembayaran</span>
                    <h3 class="fw-bold text-white mb-0">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h3>
                </div>
                <div class="text-end">
                    <span class="text-secondary small d-block" style="font-size: 0.72rem;">Batas Waktu Bayar</span>
                    <span class="badge bg-danger bg-opacity-25 text-danger border border-danger border-opacity-50 font-monospace py-1 px-2" id="countdown-timer">
                        14:59
                    </span>
                </div>
            </div>
        </div>

        <!-- Body Transaksi -->
        <div class="p-4">
            <!-- Info Order & Merchant -->
            <div class="pb-3 mb-3 border-bottom d-flex justify-content-between align-items-center small">
                <div>
                    <span class="text-muted d-block" style="font-size: 0.72rem;">Nomor Transaksi</span>
                    <span class="font-monospace fw-semibold text-dark">{{ $order->order_code }}</span>
                </div>
                <div class="text-end">
                    <span class="text-muted d-block" style="font-size: 0.72rem;">Merchant</span>
                    <span class="fw-semibold text-dark">ElectroHub Flagship Store</span>
                </div>
            </div>

            @if($order->payment_channel === 'dummy_qris')
                <!-- Tampilan QRIS -->
                <div class="text-center py-2">
                    <div class="qr-frame mb-3">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=190x190&data=ELECTROHUB-{{ $order->order_code }}" 
                             alt="QRIS Payment Code" class="img-fluid rounded-2" style="width: 190px; height: 190px;">
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" alt="QRIS" style="height: 18px;" class="opacity-75">
                        <span class="text-muted small">&bull;</span>
                        <span class="text-muted small fw-medium">NMID: ID1024392019482</span>
                    </div>
                    <p class="text-muted small" style="font-size: 0.78rem;">
                        Pindai kode QR menggunakan aplikasi mobile banking atau e-wallet pilihan Anda.
                    </p>
                </div>
            @else
                <!-- Tampilan Virtual Account -->
                <div class="py-2">
                    <div class="copy-box mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small" style="font-size: 0.75rem;">Nomor Virtual Account BCA</span>
                            <span class="badge bg-primary-subtle text-primary fw-bold" style="font-size: 0.68rem;">Otomatis Verifikasi</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-monospace fs-4 fw-bold text-dark">88019{{ rand(1000000, 9999999) }}</span>
                            <button class="btn btn-sm btn-outline-secondary py-1 px-2 rounded-2" onclick="navigator.clipboard.writeText('880199281729')">
                                <i class="bi bi-copy"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-muted small" style="font-size: 0.75rem;">
                        Transfer tepat hingga digit terakhir agar sistem mendeteksi transaksi secara otomatis.
                    </div>
                </div>
            @endif

            <!-- Rincian Item Singkat -->
            <div class="bg-light p-3 rounded-3 mb-4 mt-2">
                <div class="d-flex justify-content-between align-items-center small">
                    <span class="text-secondary text-truncate" style="max-width: 250px;">{{ $order->product->name }}</span>
                    <span class="fw-semibold text-dark">x{{ $order->quantity }}</span>
                </div>
            </div>

            <!-- Tombol Konfirmasi Pembayaran Sandbox -->
            <form action="{{ route('checkout.confirm_paid', $order->order_code) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-dark w-100 py-2-5 fw-bold rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    <span>Bayar Sekarang (Sandbox Test)</span>
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('shop.index') }}" class="text-muted text-decoration-none small" style="font-size: 0.8rem;">
                    <i class="bi bi-arrow-left me-1"></i> Batalkan & kembali ke katalog
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    // Countdown Timer 15 Menit Simpel
    let duration = 15 * 60;
    const display = document.getElementById('countdown-timer');
    setInterval(() => {
        let minutes = Math.floor(duration / 60);
        let seconds = duration % 60;
        display.textContent = `${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        if (--duration < 0) duration = 0;
    }, 1000);
</script>

</body>
</html>