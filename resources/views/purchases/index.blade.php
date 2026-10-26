@extends(view()->exists('layouts.app') ? 'layouts.app' : 'app')

@section('content')
<div style="background-color: #f8fafc; min-height: 100vh; padding: 1.75rem 2rem;">

    <!-- 1. Header Section & Action Button -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; padding-bottom: 1.25rem; margin-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem;">
                <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #e2e8f0; color: #334155; padding: 2px 8px; border-radius: 4px;">Logistik & Pengadaan</span>
                <span style="font-size: 0.75rem; color: #94a3b8;">Restock Gudang Fisik</span>
            </div>
            <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.02em;">Riwayat Pengadaan Barang Masuk (Stock-In)</h1>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem;">Arsip purchase order (PO), faktur belanja dari supplier, dan histori penambahan stok inventaris.</p>
        </div>

        <div style="display: flex; gap: 0.625rem; align-items: center;">
            <a href="{{ route('purchases.create') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background-color: #2563eb; color: #ffffff; text-decoration: none; padding: 0.55rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                Catat Pembelian Baru (Stock-In)
            </a>
        </div>
    </div>

    <!-- 2. Ringkasan Pengadaan (Summary Strip) -->
    @php
        $totalPengadaan = isset($purchases) ? $purchases->sum('total') : 0;
        $totalDokumen = isset($purchases) ? $purchases->count() : 0;
    @endphp
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
        
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem 1.25rem;">
            <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">Akumulasi Belanja Stok</span>
            <div style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-top: 0.25rem;">
                Rp {{ number_format($totalPengadaan, 0, ',', '.') }}
            </div>
            <span style="font-size: 0.7rem; color: #94a3b8; display: block; margin-top: 0.2rem;">Total modal restock barang masuk</span>
        </div>

        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem 1.25rem;">
            <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">Total Dokumen PO</span>
            <div style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-top: 0.25rem;">
                {{ $totalDokumen }} <span style="font-size: 0.75rem; font-weight: 500; color: #94a3b8;">Faktur Tercatat</span>
            </div>
            <span style="font-size: 0.7rem; color: #94a3b8; display: block; margin-top: 0.2rem;">Histori transaksi dengan pemasok</span>
        </div>

        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem 1.25rem;">
            <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">Integritas Gudang</span>
            <div style="font-size: 1.4rem; font-weight: 800; color: #059669; margin-top: 0.25rem; display: flex; align-items: center; gap: 0.4rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                Sinkron
            </div>
            <span style="font-size: 0.7rem; color: #94a3b8; display: block; margin-top: 0.2rem;">Stok fisik bertambah otomatis</span>
        </div>

    </div>

    <!-- 3. Enterprise Purchase Order Data Grid -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2 style="font-size: 0.875rem; font-weight: 700; color: #0f172a; margin: 0;">Log Transaksi Pengadaan (Stock-In)</h2>
                <p style="font-size: 0.75rem; color: #94a3b8; margin: 2px 0 0 0;">Daftar seluruh pesanan barang masuk yang telah terverifikasi sistem.</p>
            </div>
        </div>

        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.8rem;">
            <thead>
                <tr style="background: #f8fafc; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 0.85rem 1.25rem; font-weight: 700;">No. Transaksi (PO)</th>
                    <th style="padding: 0.85rem 1rem; font-weight: 700;">Tanggal Masuk</th>
                    <th style="padding: 0.85rem 1rem; font-weight: 700;">Mitra Supplier</th>
                    <th style="padding: 0.85rem 1rem; font-weight: 700;">Total Biaya Modal</th>
                    <th style="padding: 0.85rem 1rem; font-weight: 700;">Penerima / Petugas</th>
                    <th style="padding: 0.85rem 1.25rem; font-weight: 700; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $purchase)
                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;">
                    
                    <!-- No PO / Referensi -->
                    <td style="padding: 0.85rem 1.25rem;">
                        <span style="font-family: monospace; font-size: 0.75rem; font-weight: 700; background: #f1f5f9; color: #0f172a; padding: 3px 8px; border-radius: 4px; border: 1px solid #e2e8f0;">
                            {{ $purchase->purchase_number ?? $purchase->po_number ?? ('PO-' . $purchase->id) }}
                        </span>
                    </td>

                    <!-- Tanggal Masuk -->
                    <td style="padding: 0.85rem 1rem; color: #334155; font-size: 0.78rem;">
                        {{ $purchase->created_at ? $purchase->created_at->format('d M Y') : '-' }}
                        <span style="font-size: 0.68rem; color: #94a3b8; display: block; margin-top: 1px;">
                            {{ $purchase->created_at ? $purchase->created_at->format('H:i') . ' WIB' : '' }}
                        </span>
                    </td>

                    <!-- Mitra Supplier -->
                    <td style="padding: 0.85rem 1rem;">
                        <div style="font-weight: 700; color: #0f172a; font-size: 0.825rem;">
                            {{ $purchase->supplier->name ?? 'Distributor Umum' }}
                        </div>
                        @if(optional($purchase->supplier)->phone)
                        <span style="font-size: 0.7rem; color: #94a3b8; font-family: monospace;">
                            {{ $purchase->supplier->phone }}
                        </span>
                        @endif
                    </td>

                    <!-- Total Biaya Modal -->
                    <td style="padding: 0.85rem 1rem; font-weight: 800; color: #0f172a; font-family: monospace; font-size: 0.85rem;">
                        Rp {{ number_format($purchase->total, 0, ',', '.') }}
                    </td>

                    <!-- Petugas / Staf Penerima -->
                    <td style="padding: 0.85rem 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.4rem;">
                            <div style="width: 22px; height: 22px; border-radius: 9999px; background: #e2e8f0; color: #475569; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 700;">
                                {{ strtoupper(substr($purchase->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <span style="font-size: 0.75rem; color: #475569; font-weight: 600;">
                                {{ $purchase->user->name ?? 'Sang Owner' }}
                            </span>
                        </div>
                    </td>

                    <!-- Aksi -->
                    <td style="padding: 0.85rem 1.25rem; text-align: right;">
                        @if(Route::has('purchases.show'))
                        <a href="{{ route('purchases.show', $purchase) }}" title="Lihat Rincian Faktur" 
                           style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 5px 9px; color: #2563eb; background: #eff6ff; border: 1px solid #dbeafe; border-radius: 0.375rem; text-decoration: none; font-size: 0.72rem; font-weight: 600;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            Detail PO
                        </a>
                        @else
                        <span style="font-size: 0.72rem; color: #059669; font-weight: 600; background: #ecfdf5; border: 1px solid #a7f3d0; padding: 2px 7px; border-radius: 4px;">
                            Selesai
                        </span>
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 3rem 1.25rem; text-align: center; color: #94a3b8;">
                        <p style="font-size: 0.85rem; font-weight: 600; color: #64748b; margin: 0;">Belum ada rekaman riwayat barang masuk.</p>
                        <span style="font-size: 0.75rem; color: #94a3b8; display: block; margin-top: 0.25rem;">Klik tombol "Catat Pembelian Baru" untuk restock inventaris pertama Anda.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Footer -->
        @if(method_exists($purchases, 'hasPages') && $purchases->hasPages())
        <div style="padding: 0.85rem 1.25rem; background: #f8fafc; border-top: 1px solid #e2e8f0;">
            {{ $purchases->links() }}
        </div>
        @endif
    </div>

</div>
@endsection