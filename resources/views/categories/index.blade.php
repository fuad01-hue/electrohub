@extends(view()->exists('layouts.app') ? 'layouts.app' : 'app')

@section('content')
<div style="background-color: #f8fafc; min-height: 100vh; padding: 1.75rem 2rem;">

    <!-- 1. Header & Title Section -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; padding-bottom: 1.25rem; margin-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem;">
                <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #e2e8f0; color: #334155; padding: 2px 8px; border-radius: 4px;">Master Data</span>
                <span style="font-size: 0.75rem; color: #94a3b8;">Taksonomi & Etalase Gudang</span>
            </div>
            <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.02em;">Struktur Kategori Barang</h1>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem;">Pengelompokan jenis inventaris elektronik untuk klasifikasi katalog kasir dan pelaporan stok.</p>
        </div>

        <div>
            <a href="{{ route('products.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #ffffff; color: #334155; text-decoration: none; padding: 0.55rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; border: 1px solid #cbd5e1; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Lihat Katalog Produk
            </a>
        </div>
    </div>

    <!-- Alert Notifikasi Flash -->
    @if(session('success'))
    <div style="background-color: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.25rem; font-size: 0.8rem; display: flex; align-items: center; gap: 0.5rem;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.25rem; font-size: 0.8rem;">
        <ul style="margin: 0; padding-left: 1.25rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- 2. Dual Workspace Layout (Form Input + Data Table) -->
    <div style="display: grid; grid-template-columns: 340px 1fr; gap: 1.5rem; align-items: start;">
        
        <!-- Kolom Kiri: Form Registrasi Kategori Baru -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: sticky; top: 1.5rem;">
            <div style="padding-bottom: 0.85rem; margin-bottom: 1rem; border-bottom: 1px solid #f1f5f9;">
                <h2 style="font-size: 0.875rem; font-weight: 700; color: #0f172a; margin: 0;">Tambah Klasifikasi</h2>
                <p style="font-size: 0.75rem; color: #94a3b8; margin: 2px 0 0 0;">Daftarkan label baru untuk item perangkat.</p>
            </div>

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1.15rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.03em;">
                        Nama Kategori <span style="color: #e11d48;">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Misal: Storage & Memory" 
                           style="width: 100%; font-size: 0.825rem; padding: 0.6rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box; transition: all 0.15s ease;">
                    <span style="font-size: 0.7rem; color: #94a3b8; display: block; margin-top: 0.35rem;">Gunakan penamaan ringkas dan deskriptif.</span>
                </div>

                <button type="submit" style="width: 100%; display: flex; justify-content: center; align-items: center; gap: 0.45rem; background-color: #0f172a; color: #ffffff; border: none; padding: 0.65rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: background 0.15s ease;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                    Simpan Kategori
                </button>
            </form>
        </div>

        <!-- Kolom Kanan: Enterprise Taxonomy Table -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="font-size: 0.875rem; font-weight: 700; color: #0f172a; margin: 0;">Daftar Kategori Aktif</h2>
                    <p style="font-size: 0.75rem; color: #94a3b8; margin: 2px 0 0 0;">Total {{ $categories->count() }} kelompok barang terhubung.</p>
                </div>
            </div>

            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.8rem;">
                <thead>
                    <tr style="background: #f8fafc; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0;">
                        <th style="padding: 0.85rem 1.25rem; font-weight: 700; width: 50px;">#</th>
                        <th style="padding: 0.85rem 1rem; font-weight: 700;">Nama Kelompok Kategori</th>
                        <th style="padding: 0.85rem 1rem; font-weight: 700;">Produk Terhubung</th>
                        <th style="padding: 0.85rem 1.25rem; font-weight: 700; text-align: right; width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $category)
                    @php
                        $productCount = $category->products_count ?? ($category->products ? $category->products->count() : 0);
                    @endphp
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;">
                        
                        <!-- Nomor Urut -->
                        <td style="padding: 0.85rem 1.25rem; font-family: monospace; font-size: 0.75rem; color: #94a3b8;">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </td>

                        <!-- Nama Kategori -->
                        <td style="padding: 0.85rem 1rem;">
                            <div style="font-weight: 700; color: #0f172a; font-size: 0.85rem;">
                                {{ $category->name }}
                            </div>
                            <span style="font-size: 0.68rem; font-family: monospace; color: #94a3b8;">
                                ID: CAT-{{ str_pad($category->id, 3, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>

                        <!-- Relasi Jumlah SKU -->
                        <td style="padding: 0.85rem 1rem;">
                            <span style="display: inline-flex; align-items: center; gap: 0.35rem; background: #f1f5f9; color: #334155; padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 600; border: 1px solid #e2e8f0;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                {{ $productCount }} SKU Terdaftar
                            </span>
                        </td>

                        <!-- Aksi (Edit & Hapus) -->
                        <td style="padding: 0.85rem 1.25rem; text-align: right;">
                            <div style="display: inline-flex; align-items: center; gap: 0.3rem;">
                                
                                <!-- Edit -->
                                <a href="{{ route('categories.edit', $category) }}" title="Edit Kategori" 
                                   style="padding: 5px 7px; color: #2563eb; background: #eff6ff; border: 1px solid #dbeafe; border-radius: 0.375rem; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.15s ease;">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                </a>

                                <!-- Hapus -->
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display: inline;" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Kategori" 
                                            style="padding: 5px 7px; color: #e11d48; background: #fff1f2; border: 1px solid #ffe4e6; border-radius: 0.375rem; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s ease;">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2M10 11v6M14 11v6"/></svg>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 3rem 1.25rem; text-align: center; color: #94a3b8;">
                            <p style="font-size: 0.85rem; font-weight: 600; color: #64748b; margin: 0;">Belum ada kategori yang terdaftar.</p>
                            <span style="font-size: 0.75rem; color: #94a3b8; display: block; margin-top: 0.25rem;">Gunakan formulir di sisi kiri untuk menambahkan kategori pertama.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection