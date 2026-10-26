@extends(view()->exists('layouts.app') ? 'layouts.app' : 'app')

@section('content')
<div class="invoice-container" style="background-color: #f8fafc; min-height: 100vh; padding: 1.75rem 2rem;">

    <!-- 1. Header & Tombol Aksi (Otomatis Sembunyi Saat Print) -->
    <div class="no-print" style="display: flex; justify-content: space-between; align-items: flex-end; padding-bottom: 1.25rem; margin-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.02em;">Detail Nota Penjualan</h1>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem;">
                Rincian barang keluar untuk nomor invoice <span style="font-family: monospace; font-weight: 700; color: #0f172a;">{{ $sale->invoice_number ?? $sale->sale_number }}</span>
            </p>
        </div>

        <div style="display: flex; gap: 0.65rem; align-items: center;">
            <button onclick="window.print()" type="button" style="display: inline-flex; align-items: center; gap: 0.45rem; background-color: #2563eb; color: #ffffff; border: none; padding: 0.55rem 1.15rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 700; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 14h12v8H6z"/></svg>
                Cetak Struk
            </button>
            <a href="{{ route('sales.index') }}" style="display: inline-flex; align-items: center; gap: 0.45rem; background: #ffffff; color: #334155; text-decoration: none; padding: 0.55rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; border: 1px solid #cbd5e1;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- 2. Lembar Fisik Faktur (Area yang Tercetak) -->
    <div id="printable-invoice" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 2.5rem; max-width: 900px; margin: 0 auto; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        
        <!-- Header Faktur -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 2rem; border-bottom: 2px solid #0f172a; margin-bottom: 2rem;">
            <div>
                <div style="display: flex; align-items: center; gap: 0.6rem; color: #2563eb; font-weight: 900; font-size: 1.25rem; letter-spacing: -0.02em;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="16" height="16" x="4" y="4" rx="2"/>
                        <rect width="6" height="6" x="9" y="9"/>
                        <path d="M15 2v2"/>
                        <path d="M15 20v2"/>
                        <path d="M2 15h2"/>
                        <path d="M2 9h2"/>
                        <path d="M20 15h2"/>
                        <path d="M20 9h2"/>
                        <path d="M9 2v2"/>
                        <path d="M9 20v2"/>
                    </svg>
                    <span>ELECTROHUB INVENTORY</span>
                </div>
                <div style="font-size: 0.78rem; color: #64748b; margin-top: 0.25rem;">
                    Sistem Manajemen Penjualan &amp; Stok Perangkat Elektronik
                </div>
            </div>

            <div style="text-align: right;">
                <div style="font-size: 1.25rem; font-weight: 900; color: #0f172a; letter-spacing: 0.05em;">INVOICE</div>
                <div style="font-family: monospace; font-size: 0.8rem; font-weight: 700; color: #0f172a; margin-top: 0.25rem;">
                    No. Nota: {{ $sale->invoice_number ?? $sale->sale_number }}
                </div>
                <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">
                    Tanggal: {{ $sale->created_at ? $sale->created_at->format('d F Y') : date('d F Y') }}
                </div>
                <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">
                    Kasir: <strong>{{ $sale->user->name ?? auth()->user()->name }}</strong>
                </div>
                <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">
                    Pelanggan: <strong>{{ $sale->customer_name ?? 'Pelanggan Umum' }}</strong>
                </div>
            </div>
        </div>

        <!-- Tabel Rincian Item Penjualan -->
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.8rem; margin-bottom: 2rem;">
            <thead>
                <tr style="border-bottom: 1px solid #cbd5e1; border-top: 1px solid #cbd5e1; background: #f8fafc; color: #475569; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.05em;">
                    <th style="padding: 0.75rem 0.5rem; text-align: center; width: 5%;">No.</th>
                    <th style="padding: 0.75rem 1rem; width: 45%;">Deskripsi Produk</th>
                    <th style="padding: 0.75rem 1rem; text-align: right; width: 20%;">Harga Satuan</th>
                    <th style="padding: 0.75rem 1rem; text-align: center; width: 10%;">Qty</th>
                    <th style="padding: 0.75rem 1rem; text-align: right; width: 20%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $saleItems = $sale->items ?? $sale->saleItems ?? [];
                @endphp
                @forelse($saleItems as $index => $item)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 0.85rem 0.5rem; text-align: center; color: #64748b;">
                        {{ $loop->iteration ?? ($index + 1) }}
                    </td>
                    <td style="padding: 0.85rem 1rem;">
                        <div style="font-weight: 700; color: #0f172a;">
                            {{ $item->product->name ?? 'Produk Elektronik' }}
                        </div>
                        <div style="font-family: monospace; font-size: 0.7rem; color: #94a3b8; margin-top: 2px;">
                            SKU: {{ $item->product->sku ?? '-' }}
                        </div>
                    </td>
                    <td style="padding: 0.85rem 1rem; text-align: right; font-family: monospace; color: #334155;">
                        Rp {{ number_format($item->unit_price ?? $item->price, 0, ',', '.') }}
                    </td>
                    <td style="padding: 0.85rem 1rem; text-align: center; font-weight: 700; color: #0f172a; font-family: monospace;">
                        {{ $item->quantity }}
                    </td>
                    <td style="padding: 0.85rem 1rem; text-align: right; font-weight: 700; font-family: monospace; color: #0f172a;">
                        Rp {{ number_format($item->subtotal ?? (($item->unit_price ?? $item->price) * $item->quantity), 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 1.5rem; text-align: center; color: #94a3b8;">
                        Rincian item transaksi tidak ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="border-top: 2px solid #0f172a;">
                    <td colspan="4" style="padding: 1rem; text-align: right; font-size: 0.85rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #0f172a;">
                        Grand Total :
                    </td>
                    <td style="padding: 1rem; text-align: right; font-size: 1.15rem; font-weight: 900; font-family: monospace; color: #059669;">
                        Rp {{ number_format($sale->total, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Kolom Tanda Tangan -->
        <div style="display: flex; justify-content: space-between; margin-top: 4rem; padding: 0 2rem; text-align: center; font-size: 0.78rem; color: #475569;">
            <div style="width: 200px;">
                <div>Tanda Terima Pelanggan,</div>
                <div style="margin-top: 4.5rem; border-bottom: 1px solid #0f172a;"></div>
                <div style="margin-top: 0.35rem; color: #94a3b8;">{{ $sale->customer_name ?? 'Pelanggan Umum' }}</div>
            </div>

            <div style="width: 200px;">
                <div>Hormat Kami,</div>
                <div style="margin-top: 4.5rem; border-bottom: 1px solid #0f172a;"></div>
                <div style="margin-top: 0.35rem; font-weight: 700; color: #0f172a;">
                    {{ $sale->user->name ?? auth()->user()->name }}
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Aturan CSS Cetak: Menyembunyikan Navigasi & Sidebar Saat Masuk Mode Print -->
<style>
@media print {
    /* 1. Sembunyikan semua elemen UI aplikasi di luar faktur */
    aside, 
    nav, 
    .no-print,
    .sidebar,
    [style*="width: 260px"],
    header,
    button {
        display: none !important;
    }

    /* 2. Reset layout body agar pas di kertas A4 / Letter */
    body, html {
        background-color: #ffffff !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .invoice-container {
        padding: 0 !important;
        background: transparent !important;
        min-height: auto !important;
    }

    #printable-invoice {
        border: none !important;
        box-shadow: none !important;
        padding: 1.5rem !important;
        max-width: 100% !important;
        margin: 0 !important;
    }
}
</style>
@endsection