<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Resi Pengiriman - {{ $order->order_code }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; color: #000; padding: 20px; max-width: 400px; margin: auto; }
        .header { text-align: center; border-bottom: 2px dashed #000; padding-bottom: 10px; margin-bottom: 10px; }
        .details { margin-bottom: 15px; font-size: 14px; }
        .total { border-top: 2px dashed #000; padding-top: 10px; font-weight: bold; text-align: right; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h3>ELECTROHUB ONLINE</h3>
        <p>Resi Pengiriman Paket</p>
    </div>
    <div class="details">
        <p><strong>No. Pesanan:</strong> <br> {{ $order->order_code }}</p>
        <p><strong>Tanggal:</strong> <br> {{ $order->created_at->format('d M Y, H:i') }}</p>
        <p><strong>Penerima:</strong> <br> {{ $order->customer_name }} <br> {{ $order->customer_phone }}</p>
        <p><strong>Alamat Tujuan:</strong> <br> {{ $order->customer_address ?? 'Alamat tidak direkam' }}</p>
    </div>
    <div class="total">
        <p>Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
    </div>
</body>
</html>