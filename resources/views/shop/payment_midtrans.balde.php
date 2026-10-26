<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Midtrans Payment - {{ $order->order_code }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-DUMMY') }}"></script>
</head>
<body class="bg-light py-5 text-center">
<div class="container" style="max-width: 500px;">
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <h5 class="fw-bold mb-2">Midtrans Snap Sandbox</h5>
        <p class="text-muted small">Pesanan <code>{{ $order->order_code }}</code> telah dibuat.</p>
        <h4 class="fw-bold text-primary mb-4">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h4>
        
        <button id="pay-button" class="btn btn-primary w-100 py-2-5 fw-bold rounded-3 mb-2">
            Buka Jendela Pembayaran Midtrans
        </button>

        <form id="auto-confirm-form" action="{{ route('checkout.confirm_paid', $order->order_code) }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>

<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $order->snap_token }}', {
            onSuccess: function (result) {
                document.getElementById('auto-confirm-form').submit();
            },
            onPending: function (result) {
                alert('Menunggu pembayaran simulator!');
            },
            onError: function (result) {
                alert('Pembayaran gagal dicoba.');
            }
        });
    };
    // Otomatis buka popup saat pertama kali load
    window.onload = function() {
        document.getElementById('pay-button').click();
    };
</script>
</body>
</html>