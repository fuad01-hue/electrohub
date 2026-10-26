@extends(view()->exists('layouts.app') ? 'layouts.app' : 'app')

@section('content')
<div style="background-color: #f8fafc; min-height: 100vh; padding: 1.75rem 2rem;">

    <!-- 1. Header Section & Back Navigation -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; padding-bottom: 1.25rem; margin-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem;">
                <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #e2e8f0; color: #334155; padding: 2px 8px; border-radius: 4px;">Point of Sale (POS)</span>
                <span style="font-size: 0.75rem; color: #94a3b8;">Terminal Kasir Retail (Stock-Out)</span>
            </div>
            <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.02em;">Mesin Kasir & Faktur Penjualan</h1>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem;">Pemrosesan transaksi kasir langsung, validasi kecukupan unit fisik gudang, dan pemotongan stok otomatis.</p>
        </div>

        <div>
            <a href="{{ route('sales.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #ffffff; color: #334155; text-decoration: none; padding: 0.55rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; border: 1px solid #cbd5e1; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Kembali ke Riwayat
            </a>
        </div>
    </div>

    <!-- Error Validation Handling -->
    @if($errors->any())
    <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.85rem 1.25rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.8rem;">
        <div style="font-weight: 700; margin-bottom: 0.25rem;">Terdapat kendala pada proses transaksi:</div>
        <ul style="margin: 0; padding-left: 1.25rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- 2. Main Sales Form -->
    <form action="{{ route('sales.store') }}" method="POST" id="sales-form">
        @csrf

        <!-- Card Bagian 1: Informasi Pelanggan & Waktu Transaksi -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.25rem; margin-bottom: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div style="padding-bottom: 0.75rem; margin-bottom: 1rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="font-size: 0.875rem; font-weight: 700; color: #0f172a; margin: 0;">Parameter Dokumen Kasir</h2>
                    <p style="font-size: 0.75rem; color: #94a3b8; margin: 2px 0 0 0;">Identitas pembeli dan tanggal penerbitan nota transaksi resmi.</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 1rem;">
                <!-- Nama Pelanggan -->
                <div>
                    <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                        Nama Pelanggan
                    </label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" placeholder="Pelanggan Umum (Kosongkan bila retail biasa)" 
                           style="width: 100%; font-size: 0.8rem; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                </div>

                <!-- Tanggal Transaksi: name="sold_at" -->
                <div>
                    <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                        Tanggal Transaksi <span style="color: #e11d48;">*</span>
                    </label>
                    <input type="date" name="sold_at" value="{{ old('sold_at', date('Y-m-d')) }}" required 
                           style="width: 100%; font-size: 0.8rem; font-family: monospace; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                </div>

                <!-- Kasir Bertugas -->
                <div>
                    <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                        Kasir Bertugas
                    </label>
                    <input type="text" value="{{ auth()->user()->name }}" disabled 
                           style="width: 100%; font-size: 0.8rem; font-weight: 600; padding: 0.55rem 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #f1f5f9; color: #64748b; box-sizing: border-box;">
                </div>
            </div>
        </div>

        <!-- Card Bagian 2: Keranjang Belanja & Line-Items -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; overflow: hidden; margin-bottom: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="font-size: 0.875rem; font-weight: 700; color: #0f172a; margin: 0;">Daftar Item Belanja (Keranjang Kasir)</h2>
                    <p style="font-size: 0.75rem; color: #94a3b8; margin: 2px 0 0 0;">Pilih item yang dibeli, kuantitas akan otomatis mengurangi saldo inventaris gudang.</p>
                </div>
                <button type="button" id="btn-add-row" 
                        style="display: inline-flex; align-items: center; gap: 0.4rem; background: #ffffff; color: #0f172a; border: 1px solid #cbd5e1; padding: 0.45rem 0.85rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700; cursor: pointer;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                    Tambah Item Belanja
                </button>
            </div>

            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.8rem;">
                <thead>
                    <tr style="background: #f8fafc; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0;">
                        <th style="padding: 0.85rem 1.25rem; font-weight: 700; width: 42%;">Produk Elektronik & Sisa Stok</th>
                        <th style="padding: 0.85rem 1rem; font-weight: 700; width: 20%;">Harga Jual Satuan</th>
                        <th style="padding: 0.85rem 1rem; font-weight: 700; width: 14%;">Qty Beli</th>
                        <th style="padding: 0.85rem 1rem; font-weight: 700; width: 20%;">Subtotal</th>
                        <th style="padding: 0.85rem 1.25rem; font-weight: 700; text-align: right; width: 4%;"></th>
                    </tr>
                </thead>
                <tbody id="items-tbody">
                    <tr class="item-row" style="border-bottom: 1px solid #f1f5f9;">
                        <!-- Produk: name="products[0][product_id]" -->
                        <td style="padding: 0.85rem 1.25rem;">
                            <select name="products[0][product_id]" class="product-select" required 
                                    style="width: 100%; font-size: 0.8rem; padding: 0.5rem 0.65rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                                <option value="" disabled selected>-- Pilih Produk untuk Dijual --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" 
                                            data-price="{{ $product->selling_price }}" 
                                            data-stock="{{ $product->stock }}"
                                            {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                        [{{ $product->sku }}] {{ $product->name }} (Sisa: {{ $product->stock }} unit){{ $product->stock <= 0 ? ' - Habis' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <!-- Harga Jual: name="products[0][unit_price]" -->
                        <td style="padding: 0.85rem 1rem;">
                            <div style="position: relative;">
                                <span style="position: absolute; left: 8px; top: 50%; transform: translateY(-50%); font-size: 0.7rem; font-weight: 700; color: #94a3b8;">Rp</span>
                                <input type="number" name="products[0][unit_price]" class="price-input" min="0" required placeholder="0" 
                                       style="width: 100%; font-size: 0.8rem; font-family: monospace; font-weight: 700; padding: 0.5rem 0.5rem 0.5rem 1.85rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: #ffffff; color: #0f172a; box-sizing: border-box;">
                            </div>
                        </td>

                        <!-- Qty: name="products[0][quantity]" -->
                        <td style="padding: 0.85rem 1rem;">
                            <input type="number" name="products[0][quantity]" class="qty-input" min="1" value="1" required 
                                   style="width: 100%; font-size: 0.8rem; font-family: monospace; font-weight: 700; padding: 0.5rem 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: #ffffff; color: #0f172a; box-sizing: border-box; text-align: center;">
                        </td>

                        <!-- Subtotal -->
                        <td style="padding: 0.85rem 1rem;">
                            <span class="subtotal-display" style="font-family: monospace; font-size: 0.85rem; font-weight: 800; color: #0f172a;">
                                Rp 0
                            </span>
                        </td>

                        <!-- Tombol Hapus Baris -->
                        <td style="padding: 0.85rem 1.25rem; text-align: right;">
                            <button type="button" class="btn-remove-row" title="Hapus Baris" 
                                    style="padding: 4px 6px; color: #94a3b8; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.25rem; cursor: pointer;">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Card Bagian 3: Summary Bar & Tombol Selesaikan Transaksi -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.02); flex-wrap: wrap; gap: 1rem;">
            <div>
                <div style="display: flex; align-items: center; gap: 0.4rem; color: #0f172a; font-weight: 700; font-size: 0.78rem;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    Integrasi Database Aman
                </div>
                <p style="font-size: 0.72rem; color: #64748b; margin: 2px 0 0 0;">
                    Stok unit diverifikasi menggunakan proteksi <em>row-locking</em> dan nomor faktur terbit otomatis.
                </p>
            </div>

            <div style="display: flex; align-items: center; gap: 2rem;">
                <div style="text-align: right;">
                    <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; display: block;">Total Pembayaran Pelanggan</span>
                    <div id="grand-total-display" style="font-size: 1.6rem; font-weight: 900; color: #0f172a; font-family: monospace; letter-spacing: -0.02em;">
                        Rp 0
                    </div>
                </div>

                <div style="display: flex; gap: 0.65rem;">
                    <a href="{{ route('sales.index') }}" style="background: #ffffff; color: #475569; text-decoration: none; padding: 0.6rem 1.15rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; border: 1px solid #cbd5e1;">
                        Batal
                    </a>
                    <button type="submit" style="display: inline-flex; align-items: center; gap: 0.45rem; background-color: #0f172a; color: #ffffff; border: none; padding: 0.65rem 1.4rem; border-radius: 0.5rem; font-size: 0.825rem; font-weight: 700; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Proses Pembayaran Kasir
                    </button>
                </div>
            </div>
        </div>

    </form>

</div>

<!-- 3. Dynamic Calculation & Line Item Script -->
<script>
    let rowIndex = 1;

    function formatRupiah(number) {
        return 'Rp ' + Number(number).toLocaleString('id-ID');
    }

    function calculateTotals() {
        let grandTotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const subtotal = price * qty;
            
            row.querySelector('.subtotal-display').textContent = formatRupiah(subtotal);
            grandTotal += subtotal;
        });

        document.getElementById('grand-total-display').textContent = formatRupiah(grandTotal);
    }

    // Event listener: Perubahan produk -> isi harga & batasi qty sesuai stok
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select')) {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const price = selectedOption.getAttribute('data-price') || 0;
            const maxStock = selectedOption.getAttribute('data-stock') || 9999;
            const row = e.target.closest('.item-row');
            
            row.querySelector('.price-input').value = price;
            
            const qtyInput = row.querySelector('.qty-input');
            qtyInput.max = maxStock;
            if (parseInt(qtyInput.value) > parseInt(maxStock)) {
                qtyInput.value = maxStock;
            }

            calculateTotals();
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('price-input') || e.target.classList.contains('qty-input')) {
            calculateTotals();
        }
    });

    // Tombol Tambah Baris
    document.getElementById('btn-add-row').addEventListener('click', function() {
        const tbody = document.getElementById('items-tbody');
        const firstRow = tbody.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);

        const select = newRow.querySelector('.product-select');
        select.name = 'products[' + rowIndex + '][product_id]';
        select.selectedIndex = 0;

        const priceInput = newRow.querySelector('.price-input');
        priceInput.name = 'products[' + rowIndex + '][unit_price]';
        priceInput.value = '';

        const qtyInput = newRow.querySelector('.qty-input');
        qtyInput.name = 'products[' + rowIndex + '][quantity]';
        qtyInput.value = 1;
        qtyInput.removeAttribute('max');

        newRow.querySelector('.subtotal-display').textContent = 'Rp 0';

        tbody.appendChild(newRow);
        rowIndex++;
    });

    // Tombol Hapus Baris
    document.addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.btn-remove-row');
        if (removeBtn) {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length > 1) {
                removeBtn.closest('.item-row').remove();
                calculateTotals();
            } else {
                alert('Transaksi penjualan kasir minimal membutuhkan satu baris produk.');
            }
        }
    });
</script>
@endsection