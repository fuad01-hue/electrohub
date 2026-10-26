@extends(view()->exists('layouts.app') ? 'layouts.app' : 'app')

@section('content')
<div style="background-color: #f8fafc; min-height: 100vh; padding: 1.75rem 2rem;">

    <!-- 1. Header Section & Action Button -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; padding-bottom: 1.25rem; margin-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem;">
                <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #e2e8f0; color: #334155; padding: 2px 8px; border-radius: 4px;">Point of Sale (POS)</span>
                <span style="font-size: 0.75rem; color: #94a3b8;">Audit Trail Penjualan</span>
            </div>
            <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.02em;">Log Transaksi Penjualan (Stock-Out)</h1>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem;">Histori faktur kasir, rekap nilai transaksi pelanggan, dan rekaman pemotongan stok inventaris otomatis.</p>
        </div>

        <div style="display: flex; gap: 0.625rem; align-items: center;">
            <a href="{{ route('sales.create') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background-color: #2563eb; color: #ffffff; text-decoration: none; padding: 0.55rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                Buka Mesin Kasir (Stock-Out)
            </a>
        </div>
    </div>

    <!-- 2. Ringkasan Kasir (Summary Cards Strip) -->
    @php
        $totalOmzet = isset($sales) ? $sales->sum('total') : 0;
        $totalNota = isset($sales) ? $sales->count() : 0;
        $avgTicket = $totalNota > 0 ? ($totalOmzet / $totalNota) : 0;
    @endphp
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
        
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem 1.25rem;">
            <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">Total Omzet Kasir</span>
            <div style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-top: 0.25rem;">
                Rp {{ number_format($totalOmzet, 0, ',', '.') }}
            </div>
            <span style="font-size: 0.7rem; color: #94a3b8; display: block; margin-top: 0.2rem;">Akumulasi penerimaan kas riil</span>
        </div>

        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem 1.25rem;">
            <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">Volume Struk Terbit</span>
            <div style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-top: 0.25rem;">
                {{ $totalNota }} <span style="font-size: 0.75rem; font-weight: 500; color: #94a3b8;">Faktur Penjualan</span>
            </div>
            <span style="font-size: 0.7rem; color: #94a3b8; display: block; margin-top: 0.2rem;">Total closing pesanan selesai</span>
        </div>

        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem 1.25rem;">
            <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">Rata-rata Nilai Belanja</span>
            <div style="font-size: 1.4rem; font-weight: 800; color: #2563eb; margin-top: 0.25rem;">
                Rp {{ number_format($avgTicket, 0, ',', '.') }}
            </div>
            <span style="font-size: 0.7rem; color: #94a3b8; display: block; margin-top: 0.2rem;">Average Order Value (AOV)</span>
        </div>

    </div>

    <!-- 3. Enterprise Sales Log Data Grid -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2 style="font-size: 0.875rem; font-weight: 700; color: #0f172a; margin: 0;">Histori Faktur Penjualan</h2>
                <p style="font-size: 0.75rem; color: #94a3b8; margin: 2px 0 0 0;">Catatan transaksi kasir terdaftar secara kronologis.</p>
            </div>
        </div>

        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.8rem;">
            <thead>
                <tr style="background: #f8fafc; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 0.85rem 1.25rem; font-weight: 700;">No. Faktur (Invoice)</th>
                    <th style="padding: 0.85rem 1rem; font-weight: 700;">Tanggal & Waktu</th>
                    <th style="padding: 0.85rem 1rem; font-weight: 700;">Pelanggan</th>
                    <th style="padding: 0.85rem 1rem; font-weight: 700;">Total Pembayaran</th>
                    <th style="padding: 0.85rem 1rem; font-weight: 700;">Kasir Bertugas</th>
                    <th style="padding: 0.85rem 1.25rem; font-weight: 700; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;">
                    
                    <!-- No Invoice -->
                    <td style="padding: 0.85rem 1.25rem;">
                        <span style="font-family: monospace; font-size: 0.75rem; font-weight: 700; background: #f1f5f9; color: #0f172a; padding: 3px 8px; border-radius: 4px; border: 1px solid #e2e8f0;">
                            {{ $sale->invoice_number ?? $sale->sale_number }}
                        </span>
                    </td>

                    <!-- Waktu -->
                    <td style="padding: 0.85rem 1rem; color: #334155; font-size: 0.78rem;">
                        {{ $sale->created_at ? $sale->created_at->format('d M Y') : '-' }}
                        <span style="font-size: 0.68rem; color: #94a3b8; display: block; margin-top: 1px;">
                            {{ $sale->created_at ? $sale->created_at->format('H:i') . ' WIB' : '' }}
                        </span>
                    </td>

                    <!-- Pelanggan -->
                    <td style="padding: 0.85rem 1rem;">
                        <div style="font-weight: 700; color: #0f172a; font-size: 0.825rem;">
                            {{ $sale->customer_name ?? 'Pelanggan Umum' }}
                        </div>
                        <span style="font-size: 0.68rem; color: #94a3b8;">
                            Transaksi Retail / POS
                        </span>
                    </td>

                    <!-- Total Bayar -->
                    <td style="padding: 0.85rem 1rem; font-weight: 800; color: #0f172a; font-family: monospace; font-size: 0.85rem;">
                        Rp {{ number_format($sale->total, 0, ',', '.') }}
                    </td>

                    <!-- Kasir Bertugas -->
                    <td style="padding: 0.85rem 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.4rem;">
                            <div style="width: 22px; height: 22px; border-radius: 9999px; background: #e2e8f0; color: #475569; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 700;">
                                {{ strtoupper(substr($sale->user->name ?? 'K', 0, 1)) }}
                            </div>
                            <span style="font-size: 0.75rem; color: #475569; font-weight: 600;">
                                {{ $sale->user->name ?? 'Kasir Bertugas' }}
                            </span>
                        </div>
                    </td>

                    <!-- Aksi -->
                    <td style="padding: 0.85rem 1.25rem; text-align: right;">
                        @if(Route::has('sales.show'))
                        <a href="{{ route('sales.show', $sale) }}" title="Lihat Struk / Nota" 
                           style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 5px 9px; color: #2563eb; background: #eff6ff; border: 1px solid #dbeafe; border-radius: 0.375rem; text-decoration: none; font-size: 0.72rem; font-weight: 600;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            Struk Nota
                        </a>
                        @else
                        <span style="font-size: 0.72rem; color: #059669; font-weight: 600; background: #ecfdf5; border: 1px solid #a7f3d0; padding: 2px 7px; border-radius: 4px;">
                            Lunas
                        </span>
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 3rem 1.25rem; text-align: center; color: #94a3b8;">
                        <p style="font-size: 0.85rem; font-weight: 600; color: #64748b; margin: 0;">Belum ada riwayat transaksi penjualan.</p>
                        <span style="font-size: 0.75rem; color: #94a3b8; display: block; margin-top: 0.25rem;">Klik "Buka Mesin Kasir" untuk mencatat penjualan pertama.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Footer -->
        @if(method_exists($sales, 'hasPages') && $sales->hasPages())
        <div style="padding: 0.85rem 1.25rem; background: #f8fafc; border-top: 1px solid #e2e8f0;">
            {{ $sales->links() }}
        </div>
        @endif
    </div>

</div>
@endsection