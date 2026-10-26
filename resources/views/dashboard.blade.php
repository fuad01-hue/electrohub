@extends(view()->exists('app') ? 'app' : 'layouts.app')

@section('content')
<div style="background-color: #f8fafc; min-height: 100vh; padding: 1.75rem 2rem;">
    
    <!-- Header & Action Buttons -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; padding-bottom: 1.25rem; margin-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem;">
                @if(auth()->user()->isAdmin())
                    <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #e2e8f0; color: #334155; padding: 2px 8px; border-radius: 4px;">Owner Overview</span>
                @else
                    <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #eff6ff; color: #2563eb; padding: 2px 8px; border-radius: 4px; border: 1px solid #dbeafe;">Terminal Kasir & Staf Gudang</span>
                @endif
                <span style="font-size: 0.75rem; color: #94a3b8; font-family: monospace;">{{ date('d M Y') }}</span>
            </div>
            
            <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.02em;">
                {{ auth()->user()->isAdmin() ? 'Ringkasan Eksekutif & Finansial' : 'Pusat Operasional Kasir & Stok' }}
            </h1>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem;">
                {{ auth()->user()->isAdmin() 
                    ? 'Monitoring omzet kasir, valuasi inventaris, dan pergerakan stok kritis gudang.' 
                    : 'Akses cepat pelayanan transaksi pelanggan, katalog produk, dan pemantauan stok menipis.' }}
            </p>
        </div>

        <div style="display: flex; gap: 0.625rem; align-items: center;">
            <a href="{{ route('sales.create') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background-color: #2563eb; color: #ffffff; text-decoration: none; padding: 0.55rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                Buka Kasir (Stock-Out)
            </a>

            <!-- Tombol Tambah SKU Hanya Muncul untuk Owner / Admin -->
            @can('manage-master-data')
            <a href="{{ route('products.create') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background-color: #ffffff; color: #334155; text-decoration: none; padding: 0.55rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; border: 1px solid #cbd5e1; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Tambah SKU
            </a>
            @endcan
        </div>
    </div>

    <!-- 4 KPI Metrics Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
        
        @if(auth()->user()->isAdmin())
            <!-- METRIK KHUSUS OWNER: Omzet Total -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">Total Omzet Penjualan</span>
                    <div style="width: 32px; height: 32px; border-radius: 0.5rem; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                    </div>
                </div>
                <div style="font-size: 1.45rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
                    Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
                </div>
                <span style="font-size: 0.72rem; color: #94a3b8; display: block; margin-top: 0.25rem;">Akumulasi transaksi kasir</span>
            </div>

            <!-- METRIK KHUSUS OWNER: Valuasi Stok Fisik -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">Valuasi Stok Fisik</span>
                    <div style="width: 32px; height: 32px; border-radius: 0.5rem; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                </div>
                <div style="font-size: 1.45rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
                    Rp {{ number_format($totalAssetValue ?? 0, 0, ',', '.') }}
                </div>
                <span style="font-size: 0.72rem; color: #94a3b8; display: block; margin-top: 0.25rem;">Modal aset tertahan di gudang</span>
            </div>
        @else
            <!-- METRIK PENGGANTI UNTUK STAFF: Total SKU Aktif -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">Katalog Produk Siap Jual</span>
                    <div style="width: 32px; height: 32px; border-radius: 0.5rem; background: #f8fafc; color: #334155; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                    </div>
                </div>
                <div style="font-size: 1.45rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
                    {{ \App\Models\Product::count() }} <span style="font-size: 0.85rem; font-weight: 600; color: #94a3b8;">SKU</span>
                </div>
                <span style="font-size: 0.72rem; color: #94a3b8; display: block; margin-top: 0.25rem;">Item aktif dalam sistem</span>
            </div>

            <!-- METRIK PENGGANTI UNTUK STAFF: Total Unit Fisik Gudang -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">Total Unit Fisik Gudang</span>
                    <div style="width: 32px; height: 32px; border-radius: 0.5rem; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                </div>
                <div style="font-size: 1.45rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
                    {{ \App\Models\Product::sum('stock') }} <span style="font-size: 0.85rem; font-weight: 600; color: #94a3b8;">Unit</span>
                </div>
                <span style="font-size: 0.72rem; color: #94a3b8; display: block; margin-top: 0.25rem;">Stok tersedia di rak toko</span>
            </div>
        @endif

        <!-- Transaksi Kasir Hari Ini (Bisa Dilihat Semua Role) -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">Closing Kasir Hari Ini</span>
                <div style="width: 32px; height: 32px; border-radius: 0.5rem; background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
            </div>
            <div style="font-size: 1.45rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
                {{ $todayTransactions ?? 0 }} <span style="font-size: 0.85rem; font-weight: 600; color: #94a3b8;">Nota</span>
            </div>
            <span style="font-size: 0.72rem; color: #94a3b8; display: block; margin-top: 0.25rem;">Aktivitas penjualan kasir hari ini</span>
        </div>

        <!-- Stok Kritis (Bisa Dilihat Semua Role) -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">Perlu Restock Segera</span>
                <div style="width: 32px; height: 32px; border-radius: 0.5rem; background: {{ ($lowStockCount ?? 0) > 0 ? '#fff1f2' : '#f8fafc' }}; color: {{ ($lowStockCount ?? 0) > 0 ? '#e11d48' : '#94a3b8' }}; display: flex; align-items: center; justify-content: center;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div style="font-size: 1.45rem; font-weight: 800; color: {{ ($lowStockCount ?? 0) > 0 ? '#e11d48' : '#0f172a' }}; letter-spacing: -0.02em;">
                {{ $lowStockCount ?? 0 }} <span style="font-size: 0.85rem; font-weight: 600; color: #94a3b8;">Item</span>
            </div>
            <span style="font-size: 0.72rem; color: #94a3b8; display: block; margin-top: 0.25rem;">&le; Ambang batas minimal</span>
        </div>

    </div>

    <!-- 2 Column Analytics & Activity -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; align-items: start;">
        
        <!-- Tabel Transaksi Kasir -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="font-size: 0.875rem; font-weight: 700; color: #0f172a; margin: 0;">Aktivitas Kasir Terkini</h2>
                    <p style="font-size: 0.75rem; color: #94a3b8; margin: 2px 0 0 0;">Daftar transaksi penjualan terbitan kasir secara kronologis.</p>
                </div>
                <a href="{{ route('sales.index') }}" style="font-size: 0.75rem; font-weight: 600; color: #2563eb; text-decoration: none;">
                    Semua Nota &rarr;
                </a>
            </div>

            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.775rem;">
                <thead>
                    <tr style="background: #f8fafc; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f1f5f9;">
                        <th style="padding: 0.75rem 1.25rem; font-weight: 600;">No. Invoice</th>
                        <th style="padding: 0.75rem 1.25rem; font-weight: 600;">Pelanggan</th>
                        <th style="padding: 0.75rem 1.25rem; font-weight: 600;">Total Bayar</th>
                        <th style="padding: 0.75rem 1.25rem; font-weight: 600; text-align: right;">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSales ?? [] as $sale)
                    <tr style="border-bottom: 1px solid #f8fafc;">
                        <td style="padding: 0.75rem 1.25rem; font-family: monospace; font-weight: 600; color: #0f172a;">
                            {{ $sale->invoice_number ?? $sale->sale_number }}
                        </td>
                        <td style="padding: 0.75rem 1.25rem; color: #475569;">
                            {{ $sale->customer_name ?? 'Pelanggan Umum' }}
                        </td>
                        <td style="padding: 0.75rem 1.25rem; font-weight: 700; color: #0f172a;">
                            Rp {{ number_format($sale->total, 0, ',', '.') }}
                        </td>
                        <td style="padding: 0.75rem 1.25rem; text-align: right; color: #94a3b8;">
                            {{ $sale->created_at ? $sale->created_at->diffForHumans() : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 2.5rem 1.25rem; text-align: center; color: #94a3b8; font-size: 0.8rem;">
                            Belum ada riwayat transaksi penjualan yang tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Daftar Prioritas Restock -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="font-size: 0.875rem; font-weight: 700; color: #0f172a; margin: 0;">Prioritas Restock</h2>
                    <p style="font-size: 0.75rem; color: #94a3b8; margin: 2px 0 0 0;">Barang mendekati kuota habis.</p>
                </div>
                <span style="font-size: 0.7rem; font-weight: 700; background: #fff1f2; color: #e11d48; padding: 2px 8px; border-radius: 4px; border: 1px solid #ffe4e6;">
                    {{ isset($lowStockItems) ? $lowStockItems->count() : 0 }} SKU
                </span>
            </div>

            <div style="padding: 0.75rem 1.25rem;">
                @forelse($lowStockItems ?? [] as $item)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.65rem 0; border-bottom: 1px solid #f8fafc;">
                    <div style="min-width: 0; padding-right: 0.5rem;">
                        <p style="font-size: 0.775rem; font-weight: 600; color: #0f172a; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 170px;">{{ $item->name }}</p>
                        <p style="font-size: 0.68rem; font-family: monospace; color: #94a3b8; margin: 2px 0 0 0;">{{ $item->sku }}</p>
                    </div>
                    <div style="text-align: right; flex-shrink: 0;">
                        <span style="font-size: 0.7rem; font-weight: 700; background: #fee2e2; color: #b91c1c; padding: 2px 7px; border-radius: 4px;">
                            Sisa: {{ $item->stock }}
                        </span>
                        <span style="display: block; font-size: 0.65rem; color: #94a3b8; margin-top: 2px;">Min: {{ $item->minimum_stock }}</span>
                    </div>
                </div>
                @empty
                <div style="padding: 2rem 0; text-align: center; color: #94a3b8; font-size: 0.8rem;">
                    Semua stok gudang dalam kondisi aman.
                </div>
                @endforelse
            </div>

            <div style="padding: 0.85rem 1.25rem; background: #f8fafc; border-top: 1px solid #f1f5f9;">
                <a href="{{ route('purchases.create') }}" style="display: block; text-align: center; font-size: 0.75rem; font-weight: 600; color: #2563eb; text-decoration: none; padding: 0.45rem; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.375rem;">
                    Buat PO Restock (Stock-In) &rarr;
                </a>
            </div>
        </div>

    </div>

</div>
@endsection