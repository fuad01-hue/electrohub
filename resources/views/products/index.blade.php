@extends(view()->exists('layouts.app') ? 'layouts.app' : 'app')

@section('content')
<div style="background-color: #f8fafc; min-height: 100vh; padding: 1.75rem 2rem;">

    <!-- 1. Header & Primary Actions -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; padding-bottom: 1.25rem; margin-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem;">
                <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #e2e8f0; color: #334155; padding: 2px 8px; border-radius: 4px;">Master Data</span>
                <span style="font-size: 0.75rem; color: #94a3b8;">Katalog & Pemantauan Stok</span>
            </div>
            <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.02em;">Katalog Produk Elektronik</h1>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem;">Daftar unit barang, rincian spesifikasi teknis, harga pasar, dan kuota inventaris fisik.</p>
        </div>

        <div style="display: flex; gap: 0.625rem; align-items: center;">
            <!-- Tombol Kelola Kategori Hanya untuk Owner/Admin -->
            @can('manage-master-data')
                @if(Route::has('categories.index'))
                <a href="{{ route('categories.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #ffffff; color: #334155; text-decoration: none; padding: 0.55rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; border: 1px solid #cbd5e1; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Kelola Kategori
                </a>
                @endif
            @endcan

            <!-- Tombol Tambah Produk Hanya untuk Owner/Admin -->
            @can('manage-master-data')
            <a href="{{ route('products.create') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background-color: #2563eb; color: #ffffff; text-decoration: none; padding: 0.55rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                Tambah Produk
            </a>
            @endcan
        </div>
    </div>

    <!-- 2. Ringkasan Metrik Kartu -->
    @php
        $totalSkus = \App\Models\Product::count();
        $totalPhysicalUnits = \App\Models\Product::sum('stock');
        $lowStockTotal = \App\Models\Product::whereColumn('stock', '<=', 'minimum_stock')->count();
    @endphp
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem 1.25rem;">
            <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">Total Jenis SKU</span>
            <div style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-top: 0.25rem;">
                {{ $totalSkus }} <span style="font-size: 0.75rem; font-weight: 500; color: #94a3b8;">Item Terdaftar</span>
            </div>
        </div>

        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem 1.25rem;">
            <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">Volume Stok Fisik</span>
            <div style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-top: 0.25rem;">
                {{ number_format($totalPhysicalUnits, 0, ',', '.') }} <span style="font-size: 0.75rem; font-weight: 500; color: #94a3b8;">Unit di Gudang</span>
            </div>
        </div>

        <a href="{{ route('products.index', ['filter' => 'low_stock']) }}" style="background: {{ $lowStockTotal > 0 ? '#fff1f2' : '#ffffff' }}; border: 1px solid {{ $lowStockTotal > 0 ? '#ffe4e6' : '#e2e8f0' }}; border-radius: 0.75rem; padding: 1rem 1.25rem; text-decoration: none; display: block;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: {{ $lowStockTotal > 0 ? '#e11d48' : '#64748b' }};">Peringatan Restock</span>
                @if($lowStockTotal > 0)
                <span style="font-size: 0.65rem; font-weight: 700; background: #e11d48; color: #ffffff; padding: 1px 6px; border-radius: 9999px;">Perlu Order</span>
                @endif
            </div>
            <div style="font-size: 1.4rem; font-weight: 800; color: {{ $lowStockTotal > 0 ? '#be123c' : '#0f172a' }}; margin-top: 0.25rem;">
                {{ $lowStockTotal }} <span style="font-size: 0.75rem; font-weight: 500; color: {{ $lowStockTotal > 0 ? '#e11d48' : '#94a3b8' }};">SKU Kritis</span>
            </div>
        </a>
    </div>

    <!-- 3. Filter Kategori & Pencarian -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem; margin-bottom: 1.25rem; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
        
        <div style="display: flex; gap: 0.35rem; overflow-x: auto; padding-bottom: 0.75rem; margin-bottom: 0.75rem; border-bottom: 1px solid #f1f5f9;">
            <a href="{{ route('products.index') }}" 
               style="text-decoration: none; font-size: 0.75rem; font-weight: 600; padding: 0.4rem 0.75rem; border-radius: 0.375rem; white-space: nowrap; transition: all 0.15s ease; {{ !request('category_id') && !request('filter') ? 'background: #0f172a; color: #ffffff;' : 'background: #f8fafc; color: #475569; border: 1px solid #e2e8f0;' }}">
                Semua Produk ({{ $totalSkus }})
            </a>

            @foreach($categories as $category)
            <a href="{{ route('products.index', array_merge(request()->query(), ['category_id' => $category->id])) }}" 
               style="text-decoration: none; font-size: 0.75rem; font-weight: 600; padding: 0.4rem 0.75rem; border-radius: 0.375rem; white-space: nowrap; transition: all 0.15s ease; {{ request('category_id') == $category->id ? 'background: #0f172a; color: #ffffff;' : 'background: #f8fafc; color: #475569; border: 1px solid #e2e8f0;' }}">
                {{ $category->name }}
                <span style="font-size: 0.65rem; opacity: 0.8; margin-left: 2px;">({{ $category->products_count ?? $category->products->count() }})</span>
            </a>
            @endforeach

            <a href="{{ route('products.index', ['filter' => 'low_stock']) }}" 
               style="text-decoration: none; font-size: 0.75rem; font-weight: 600; padding: 0.4rem 0.75rem; border-radius: 0.375rem; white-space: nowrap; margin-left: auto; {{ request('filter') === 'low_stock' ? 'background: #e11d48; color: #ffffff;' : 'background: #fff1f2; color: #e11d48; border: 1px solid #ffe4e6;' }}">
                Peringatan Stok Menipis ({{ $lowStockTotal }})
            </a>
        </div>

        <form method="GET" action="{{ route('products.index') }}" style="display: flex; gap: 0.5rem; align-items: center;">
            @if(request('category_id'))
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            @endif
            @if(request('filter'))
                <input type="hidden" name="filter" value="{{ request('filter') }}">
            @endif

            <div style="position: relative; flex: 1;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%);"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama perangkat, SKU, atau brand (contoh: ROG, Lenovo, Samsung)..." 
                       style="width: 100%; font-size: 0.8rem; padding: 0.55rem 0.75rem 0.55rem 2.25rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
            </div>

            <button type="submit" style="background: #0f172a; color: #ffffff; border: none; border-radius: 0.5rem; padding: 0.55rem 1.1rem; font-size: 0.8rem; font-weight: 600; cursor: pointer; white-space: nowrap;">
                Filter
            </button>

            @if(request('search') || request('category_id') || request('filter'))
            <a href="{{ route('products.index') }}" style="background: #ffffff; color: #64748b; border: 1px solid #cbd5e1; border-radius: 0.5rem; padding: 0.55rem 0.85rem; font-size: 0.8rem; font-weight: 600; text-decoration: none; white-space: nowrap;">
                Reset
            </a>
            @endif
        </form>

    </div>

    <!-- 4. Tabel Katalog Produk -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.8rem;">
            <thead>
                <tr style="background: #f8fafc; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 0.85rem 1.25rem; font-weight: 700;">Perangkat & SKU</th>
                    <th style="padding: 0.85rem 1rem; font-weight: 700;">Kategori</th>

                    <!-- Kolom Harga Beli Hanya Muncul untuk Admin/Owner -->
                    @if(auth()->user()->isAdmin())
                    <th style="padding: 0.85rem 1rem; font-weight: 700;">Harga Beli (Modal)</th>
                    @endif

                    <th style="padding: 0.85rem 1rem; font-weight: 700;">Harga Jual</th>
                    <th style="padding: 0.85rem 1rem; font-weight: 700;">Kondisi Stok</th>
                    <th style="padding: 0.85rem 1.25rem; font-weight: 700; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                @php
                    $isLowStock = $product->stock <= $product->minimum_stock;
                @endphp
                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;">
                    
                    <!-- Nama & Spek -->
                    <td style="padding: 0.85rem 1.25rem;">
                        <div style="display: flex; align-items: center; gap: 0.85rem;">
                            <div style="width: 44px; height: 44px; border-radius: 0.5rem; border: 1px solid #e2e8f0; overflow: hidden; background: #f8fafc; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                @endif
                            </div>

                            <div style="min-width: 0;">
                                <div style="display: flex; align-items: center; gap: 0.4rem; margin-bottom: 2px;">
                                    <span style="font-family: monospace; font-size: 0.68rem; font-weight: 700; background: #f1f5f9; color: #475569; padding: 1px 6px; border-radius: 4px; border: 1px solid #e2e8f0;">
                                        {{ $product->sku }}
                                    </span>
                                    @if($product->brand)
                                    <span style="font-size: 0.68rem; font-weight: 600; color: #2563eb;">
                                        {{ $product->brand }}
                                    </span>
                                    @endif
                                </div>
                                <div style="font-weight: 700; color: #0f172a; font-size: 0.825rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 280px;">
                                    {{ $product->name }}
                                </div>
                                @if($product->specifications)
                                <div style="font-size: 0.7rem; color: #94a3b8; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 280px; margin-top: 1px;">
                                    {{ $product->specifications }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </td>

                    <!-- Kategori -->
                    <td style="padding: 0.85rem 1rem;">
                        <span style="font-size: 0.72rem; font-weight: 500; color: #334155; background: #f1f5f9; padding: 3px 8px; border-radius: 4px; border: 1px solid #e2e8f0;">
                            {{ $product->category->name ?? 'Tanpa Kategori' }}
                        </span>
                    </td>

                    <!-- Harga Beli (Hanya Owner/Admin) -->
                    @if(auth()->user()->isAdmin())
                    <td style="padding: 0.85rem 1rem; color: #64748b; font-family: monospace; font-size: 0.8rem;">
                        Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                    </td>
                    @endif

                    <!-- Harga Jual -->
                    <td style="padding: 0.85rem 1rem; font-weight: 800; color: #0f172a; font-family: monospace; font-size: 0.85rem;">
                        Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                    </td>

                    <!-- Stok -->
                    <td style="padding: 0.85rem 1rem;">
                        @if($isLowStock)
                            <div style="display: inline-flex; align-items: center; gap: 0.35rem; background: #fff1f2; border: 1px solid #ffe4e6; padding: 3px 8px; border-radius: 4px;">
                                <span style="width: 6px; height: 6px; border-radius: 9999px; background: #e11d48;"></span>
                                <span style="font-size: 0.75rem; font-weight: 700; color: #be123c;">{{ $product->stock }} Unit</span>
                                <span style="font-size: 0.65rem; color: #f43f5e;">(Min: {{ $product->minimum_stock }})</span>
                            </div>
                        @else
                            <div style="display: inline-flex; align-items: center; gap: 0.35rem; background: #f8fafc; border: 1px solid #e2e8f0; padding: 3px 8px; border-radius: 4px;">
                                <span style="width: 6px; height: 6px; border-radius: 9999px; background: #10b981;"></span>
                                <span style="font-size: 0.75rem; font-weight: 700; color: #0f172a;">{{ $product->stock }} Unit</span>
                            </div>
                        @endif
                    </td>

                    <!-- Aksi -->
                    <td style="padding: 0.85rem 1.25rem; text-align: right;">
                        <div style="display: inline-flex; align-items: center; gap: 0.25rem;">
                            
                            <!-- Detail Produk (Bisa Semua Role) -->
                            <a href="{{ route('products.show', $product) }}" title="Lihat Detail" style="padding: 6px; color: #475569; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.375rem; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>

                            <!-- Edit (Hanya Owner/Admin) -->
                            @can('manage-master-data')
                            <a href="{{ route('products.edit', $product) }}" title="Edit Produk" style="padding: 6px; color: #2563eb; background: #eff6ff; border: 1px solid #dbeafe; border-radius: 0.375rem; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                            </a>

                            <!-- Hapus (Hanya Owner/Admin) -->
                            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus produk {{ $product->name }} dari sistem inventaris?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus Produk" style="padding: 6px; color: #e11d48; background: #fff1f2; border: 1px solid #ffe4e6; border-radius: 0.375rem; display: inline-flex; align-items: center; justify-content: center; cursor: pointer;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2M10 11v6M14 11v6"/></svg>
                                </button>
                            </form>
                            @endcan

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->isAdmin() ? 6 : 5 }}" style="padding: 3rem 1.25rem; text-align: center; color: #94a3b8;">
                        <p style="font-size: 0.85rem; font-weight: 600; color: #64748b; margin: 0;">Tidak ada produk yang sesuai dengan kriteria filter.</p>
                        <a href="{{ route('products.index') }}" style="font-size: 0.75rem; color: #2563eb; text-decoration: none; font-weight: 600; margin-top: 0.35rem; display: inline-block;">Reset Filter &rarr;</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($products->hasPages())
        <div style="padding: 0.85rem 1.25rem; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 0.75rem; color: #64748b;">
                Menampilkan <span style="font-weight: 700; color: #0f172a;">{{ $products->firstItem() }}</span> - <span style="font-weight: 700; color: #0f172a;">{{ $products->lastItem() }}</span> dari <span style="font-weight: 700; color: #0f172a;">{{ $products->total() }}</span> produk
            </div>
            <div>
                {{ $products->links() }}
            </div>
        </div>
        @endif
    </div>

</div>
@endsection