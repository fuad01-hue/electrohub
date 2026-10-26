@extends('layouts.app') <!-- Sesuaikan dengan nama layout utamamu -->

@section('content')
<div class="container-fluid px-4 py-4">
    <h4 class="fw-bold mb-4">Pusat Pesanan Online</h4>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Pesanan</th>
                            <th>Waktu Masuk</th>
                            <th>Pelanggan</th>
                            <th>Total Tagihan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="fw-semibold text-primary">{{ $order->order_code }}</td>
                            <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                {{ $order->customer_name }} <br>
                                <small class="text-muted">{{ $order->customer_phone }}</small>
                            </td>
                            <td class="fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="btn btn-sm btn-outline-dark">
                                    Cetak Resi
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada pesanan online yang masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection