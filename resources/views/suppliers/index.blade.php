@extends(view()->exists('layouts.app') ? 'layouts.app' : 'app')

@section('content')
<div style="background-color: #f8fafc; min-height: 100vh; padding: 1.75rem 2rem;">

    <!-- 1. Header & Quick Action -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; padding-bottom: 1.25rem; margin-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem;">
                <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #e2e8f0; color: #334155; padding: 2px 8px; border-radius: 4px;">Master Data</span>
                <span style="font-size: 0.75rem; color: #94a3b8;">Rantai Pasok & Distribusi</span>
            </div>
            <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.02em;">Direktori Mitra Supplier</h1>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem;">Daftar vendor resmi dan distributor perangkat elektronik untuk pengadaan barang masuk (Stock-In).</p>
        </div>

        <div>
            <a href="{{ route('purchases.create') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background-color: #2563eb; color: #ffffff; text-decoration: none; padding: 0.55rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                Buat PO Pembelian (Stock-In)
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

    <!-- 2. Dual Workspace Layout (Form Registrasi + Direktori Vendor) -->
    <div style="display: grid; grid-template-columns: 360px 1fr; gap: 1.5rem; align-items: start;">
        
        <!-- Kolom Kiri: Form Registrasi Supplier Baru -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: sticky; top: 1.5rem;">
            <div style="padding-bottom: 0.85rem; margin-bottom: 1rem; border-bottom: 1px solid #f1f5f9;">
                <h2 style="font-size: 0.875rem; font-weight: 700; color: #0f172a; margin: 0;">Tambah Vendor Baru</h2>
                <p style="font-size: 0.75rem; color: #94a3b8; margin: 2px 0 0 0;">Daftarkan distributor penyuplai produk.</p>
            </div>

            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 0.95rem;">
                    <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                        Nama Perusahaan / Toko <span style="color: #e11d48;">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: PT Synnex Metrodata Indonesia" 
                           style="width: 100%; font-size: 0.8rem; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 0.95rem;">
                    <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                        Nomor Telepon / WhatsApp
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="0812-xxxx-xxxx / 021-xxxx" 
                           style="width: 100%; font-size: 0.8rem; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 0.95rem;">
                    <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                        Email Resmi
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="procurement@vendor.example" 
                           style="width: 100%; font-size: 0.8rem; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                        Alamat Kantor / Gudang
                    </label>
                    <textarea name="address" rows="3" placeholder="Alamat lengkap pergudangan atau pusat distribusi..." 
                              style="width: 100%; font-size: 0.8rem; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box; resize: vertical;">{{ old('address') }}</textarea>
                </div>

                <button type="submit" style="width: 100%; display: flex; justify-content: center; align-items: center; gap: 0.45rem; background-color: #0f172a; color: #ffffff; border: none; padding: 0.65rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                    Simpan Mitra Supplier
                </button>
            </form>
        </div>

        <!-- Kolom Kanan: Tabel Vendor Terdaftar -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="font-size: 0.875rem; font-weight: 700; color: #0f172a; margin: 0;">Daftar Pemasok Resmi</h2>
                    <p style="font-size: 0.75rem; color: #94a3b8; margin: 2px 0 0 0;">Total {{ $suppliers->count() }} mitra terhubung dengan sistem inventaris.</p>
                </div>
            </div>

            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.8rem;">
                <thead>
                    <tr style="background: #f8fafc; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0;">
                        <th style="padding: 0.85rem 1.25rem; font-weight: 700; width: 45px;">#</th>
                        <th style="padding: 0.85rem 1rem; font-weight: 700;">Identitas Supplier</th>
                        <th style="padding: 0.85rem 1rem; font-weight: 700;">Saluran Kontak</th>
                        <th style="padding: 0.85rem 1rem; font-weight: 700;">Alamat Kantor</th>
                        <th style="padding: 0.85rem 1.25rem; font-weight: 700; text-align: right; width: 90px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $index => $supplier)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        
                        <!-- Nomor Urut -->
                        <td style="padding: 0.85rem 1.25rem; font-family: monospace; font-size: 0.75rem; color: #94a3b8;">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </td>

                        <!-- Identitas Supplier -->
                        <td style="padding: 0.85rem 1rem;">
                            <div style="font-weight: 700; color: #0f172a; font-size: 0.85rem;">
                                {{ $supplier->name }}
                            </div>
                            <span style="font-size: 0.68rem; font-family: monospace; color: #94a3b8;">
                                VENDOR-{{ str_pad($supplier->id, 3, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>

                        <!-- Kontak -->
                        <td style="padding: 0.85rem 1rem;">
                            @if($supplier->phone)
                            <div style="display: flex; align-items: center; gap: 0.35rem; font-family: monospace; font-size: 0.75rem; color: #334155; font-weight: 600;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                {{ $supplier->phone }}
                            </div>
                            @endif

                            @if($supplier->email)
                            <div style="display: flex; align-items: center; gap: 0.35rem; font-size: 0.72rem; color: #64748b; margin-top: 2px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                {{ $supplier->email }}
                            </div>
                            @endif

                            @if(!$supplier->phone && !$supplier->email)
                            <span style="font-size: 0.72rem; color: #cbd5e1; font-style: italic;">Belum ada kontak</span>
                            @endif
                        </td>

                        <!-- Alamat -->
                        <td style="padding: 0.85rem 1rem;">
                            @if($supplier->address)
                            <p style="font-size: 0.75rem; color: #475569; margin: 0; max-width: 260px; line-height: 1.35;">
                                {{ $supplier->address }}
                            </p>
                            @else
                            <span style="font-size: 0.72rem; color: #cbd5e1; font-style: italic;">Belum ada alamat</span>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td style="padding: 0.85rem 1.25rem; text-align: right;">
                            <div style="display: inline-flex; align-items: center; gap: 0.3rem;">
                                
                                <!-- Edit -->
                                <a href="{{ route('suppliers.edit', $supplier) }}" title="Edit Supplier" 
                                   style="padding: 5px 7px; color: #2563eb; background: #eff6ff; border: 1px solid #dbeafe; border-radius: 0.375rem; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                </a>

                                <!-- Hapus -->
                                <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" style="display: inline;" 
                                      onsubmit="return confirm('Hapus supplier {{ $supplier->name }} dari sistem?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Supplier" 
                                            style="padding: 5px 7px; color: #e11d48; background: #fff1f2; border: 1px solid #ffe4e6; border-radius: 0.375rem; display: inline-flex; align-items: center; justify-content: center; cursor: pointer;">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2M10 11v6M14 11v6"/></svg>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 3rem 1.25rem; text-align: center; color: #94a3b8;">
                            <p style="font-size: 0.85rem; font-weight: 600; color: #64748b; margin: 0;">Belum ada mitra supplier terdaftar.</p>
                            <span style="font-size: 0.75rem; color: #94a3b8; display: block; margin-top: 0.25rem;">Gunakan formulir di sebelah kiri untuk menambahkan supplier baru.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection