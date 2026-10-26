@extends(view()->exists('layouts.app') ? 'layouts.app' : 'app')

@section('content')
<div style="background-color: #f8fafc; min-height: 100vh; padding: 1.75rem 2rem;">

    <!-- 1. Header & Back Navigation -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; padding-bottom: 1.25rem; margin-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem;">
                <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #e2e8f0; color: #334155; padding: 2px 8px; border-radius: 4px;">Master Data</span>
                <span style="font-size: 0.75rem; color: #94a3b8;">Registrasi Inventaris Baru</span>
            </div>
            <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.02em;">Pendaftaran Item Produk Elektronik</h1>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem;">Lengkapi parameter SKU, spesifikasi perangkat keras, struktur harga, dan batas aman stok fisik.</p>
        </div>

        <div>
            <a href="{{ route('products.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #ffffff; color: #334155; text-decoration: none; padding: 0.55rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; border: 1px solid #cbd5e1; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Kembali ke Katalog
            </a>
        </div>
    </div>

    <!-- Error Validation Handling -->
    @if($errors->any())
    <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.85rem 1.25rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.8rem;">
        <div style="font-weight: 700; margin-bottom: 0.25rem;">Terdapat kesalahan pada isian formulir:</div>
        <ul style="margin: 0; padding-left: 1.25rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- 2. Main Form Formatter -->
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="display: grid; grid-template-columns: 320px 1fr; gap: 1.5rem; align-items: start;">
            
            <!-- Kolom Kiri: Upload Media & Panduan Regulasi Stok -->
            <div style="display: flex; flex-direction: column; gap: 1rem; position: sticky; top: 1.5rem;">
                
                <!-- Card Asset Gambar -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.03em;">
                        Foto / Visual Unit
                    </label>

                    <div style="width: 100%; height: 210px; border: 2px dashed #cbd5e1; border-radius: 0.5rem; background: #f8fafc; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; overflow: hidden; padding: 0.75rem; box-sizing: border-box; text-align: center;">
                        <img id="image-preview" src="#" alt="Pratinjau Foto" style="display: none; width: 100%; height: 100%; object-fit: contain; border-radius: 0.375rem;">
                        <div id="placeholder-box" style="display: flex; flex-direction: column; align-items: center;">
                            <div style="width: 40px; height: 40px; border-radius: 9999px; background: #e2e8f0; display: flex; align-items: center; justify-content: center; margin-bottom: 0.5rem; color: #64748b;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                            </div>
                            <span style="font-size: 0.75rem; font-weight: 600; color: #475569;">Pilih Berkas Gambar</span>
                            <span style="font-size: 0.68rem; color: #94a3b8; margin-top: 2px;">Format JPG, PNG, atau WEBP</span>
                        </div>
                    </div>

                    <div style="margin-top: 0.85rem;">
                        <input type="file" name="image" id="image-input" accept="image/png, image/jpeg, image/webp" 
                               style="font-size: 0.75rem; width: 100%; color: #64748b; file-selector-button: border-radius: 4px; file-selector-button: border: 1px solid #cbd5e1; file-selector-button: background: #f8fafc; file-selector-button: padding: 4px 8px; file-selector-button: font-size: 0.75rem; cursor: pointer;">
                        <span style="font-size: 0.68rem; color: #94a3b8; display: block; margin-top: 0.35rem;">Batas ukuran berkas maksimal 2MB.</span>
                    </div>
                </div>

                <!-- Card Kebijakan Stok Awal -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.15rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <div style="display: flex; align-items: center; gap: 0.4rem; color: #0f172a; font-weight: 700; font-size: 0.75rem; margin-bottom: 0.35rem;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        Ketentuan Stok Masuk
                    </div>
                    <p style="font-size: 0.72rem; color: #64748b; margin: 0; line-height: 1.45;">
                        Sesuai standar pembukuan inventaris, kuota fisik awal didaftarkan bernilai <strong>0</strong>. Penambahan unit fisik dilakukan secara resmi melalui modul <strong>Pembelian (Stock-In)</strong> dari distributor resmi.
                    </p>
                </div>

            </div>

            <!-- Kolom Kanan: Rincian Spesifikasi & Finansial -->
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                
                <!-- Section 1: Identitas & Klasifikasi Unit -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <div style="padding-bottom: 0.75rem; margin-bottom: 1rem; border-bottom: 1px solid #f1f5f9;">
                        <h2 style="font-size: 0.875rem; font-weight: 700; color: #0f172a; margin: 0;">Identitas & Klasifikasi Perangkat</h2>
                        <p style="font-size: 0.75rem; color: #94a3b8; margin: 2px 0 0 0;">Spesifikasi umum untuk pelabelan sistem dan etalase kasir.</p>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                                Kode SKU Inventaris <span style="color: #e11d48;">*</span>
                            </label>
                            <input type="text" name="sku" value="{{ old('sku') }}" required placeholder="Contoh: LPT-ROG-G16" 
                                   style="width: 100%; font-size: 0.8rem; font-family: monospace; font-weight: 600; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                        </div>

                        <div>
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                                Kategori Perangkat <span style="color: #e11d48;">*</span>
                            </label>
                            <select name="category_id" required 
                                    style="width: 100%; font-size: 0.8rem; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                                <option value="" disabled selected>-- Pilih Klasifikasi Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                                Nama Lengkap Produk <span style="color: #e11d48;">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: ASUS ROG Strix G16 (2025)" 
                                   style="width: 100%; font-size: 0.8rem; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                        </div>

                        <div>
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                                Brand / Principal
                            </label>
                            <input type="text" name="brand" value="{{ old('brand') }}" placeholder="Contoh: ASUS, MSI, Apple" 
                                   style="width: 100%; font-size: 0.8rem; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                            Spesifikasi Teknis Ringkas
                        </label>
                        <textarea name="specifications" rows="3" placeholder="Contoh: Intel Core i7-13650HX, 16GB DDR5, SSD 1TB NVMe, RTX 4060 8GB, 16-inch 165Hz..." 
                                  style="width: 100%; font-size: 0.8rem; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box; resize: vertical;">{{ old('specifications') }}</textarea>
                    </div>
                </div>

                <!-- Section 2: Struktur Harga & Ambang Batas Minimum -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <div style="padding-bottom: 0.75rem; margin-bottom: 1rem; border-bottom: 1px solid #f1f5f9;">
                        <h2 style="font-size: 0.875rem; font-weight: 700; color: #0f172a; margin: 0;">Parameter Finansial & Ambang Stok</h2>
                        <p style="font-size: 0.75rem; color: #94a3b8; margin: 2px 0 0 0;">Nilai dasar perhitungan laba serta kuota pengingat restock gudang.</p>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                                Harga Modal (Beli) <span style="color: #e11d48;">*</span>
                            </label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); font-size: 0.75rem; font-weight: 700; color: #94a3b8;">Rp</span>
                                <input type="number" name="purchase_price" value="{{ old('purchase_price') }}" required min="0" placeholder="0" 
                                       style="width: 100%; font-size: 0.8rem; font-family: monospace; font-weight: 700; padding: 0.55rem 0.75rem 0.55rem 2.1rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                            </div>
                        </div>

                        <div>
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                                Harga Jual Retail <span style="color: #e11d48;">*</span>
                            </label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); font-size: 0.75rem; font-weight: 700; color: #94a3b8;">Rp</span>
                                <input type="number" name="selling_price" value="{{ old('selling_price') }}" required min="0" placeholder="0" 
                                       style="width: 100%; font-size: 0.8rem; font-family: monospace; font-weight: 700; padding: 0.55rem 0.75rem 0.55rem 2.1rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                            </div>
                        </div>

                        <div>
                            <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                                Batas Alert Minimum <span style="color: #e11d48;">*</span>
                            </label>
                            <input type="number" name="minimum_stock" value="{{ old('minimum_stock', 5) }}" required min="1" 
                                   style="width: 100%; font-size: 0.8rem; font-family: monospace; font-weight: 700; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                            <span style="font-size: 0.68rem; color: #94a3b8; display: block; margin-top: 0.3rem;">Memicu alert di dashboard jika stok &le; angka ini.</span>
                        </div>
                    </div>
                </div>

                <!-- Action Confirmation Footer -->
                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 0.75rem; padding-top: 0.5rem;">
                    <a href="{{ route('products.index') }}" style="background: #ffffff; color: #475569; text-decoration: none; padding: 0.6rem 1.15rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; border: 1px solid #cbd5e1;">
                        Batal
                    </a>
                    <button type="submit" style="display: inline-flex; align-items: center; gap: 0.45rem; background-color: #0f172a; color: #ffffff; border: none; padding: 0.6rem 1.25rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan & Daftarkan SKU
                    </button>
                </div>

            </div>

        </div>
    </form>

</div>

<script>
    document.getElementById('image-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('image-preview');
                const placeholder = document.getElementById('placeholder-box');
                preview.src = event.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection