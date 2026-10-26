@extends('layouts.app')

@section('title', 'Edit Produk - ' . $product->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Edit Produk Elektronik</h3>
        <p class="text-muted small mb-0">Perbarui detail spesifikasi, gambar, atau harga untuk <strong>{{ $product->name }}</strong>.</p>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <!-- KOLOM KIRI: GAMBAR PRODUK -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <h6 class="fw-bold mb-3 text-start"><i class="bi bi-image me-2 text-primary"></i>Foto Produk</h6>
                    
                    <div class="border rounded-3 bg-light d-flex align-items-center justify-content-center mb-3 overflow-hidden" style="height: 220px;">
                        @if($product->image)
                            <img id="imagePreview" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 220px; object-fit: contain;">
                            <div id="imagePlaceholder" class="text-muted d-none"></div>
                        @else
                            <img id="imagePreview" src="" alt="Preview" class="img-fluid d-none" style="max-height: 220px; object-fit: contain;">
                            <div id="imagePlaceholder" class="text-muted">
                                <i class="bi bi-laptop display-4 d-block mb-2 text-secondary"></i>
                                <span class="small">Belum ada foto produk</span>
                            </div>
                        @endif
                    </div>

                    <input type="file" name="image" id="imageInput" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image') <div class="invalid-feedback text-start">{{ $message }}</div> @enderror
                    <small class="text-muted d-block mt-2">Biarkan kosong jika tidak ingin mengubah foto.</small>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: FORM EDIT -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 border-bottom pb-2"><i class="bi bi-pencil-square me-2 text-primary"></i>Informasi & Spesifikasi Barang</h6>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Kode SKU <span class="text-danger">*</span></label>
                            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku) }}" required>
                            @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label fw-medium">Nama Produk Elektronik <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Merek / Brand</label>
                            <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" value="{{ old('brand', $product->brand) }}">
                            @error('brand') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">Spesifikasi Teknis</label>
                        <textarea name="specifications" rows="3" class="form-control @error('specifications') is-invalid @enderror">{{ old('specifications', $product->specifications) }}</textarea>
                        @error('specifications') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <h6 class="fw-bold mb-3 border-bottom pb-2"><i class="bi bi-cash-stack me-2 text-primary"></i>Harga & Pengaturan Stok</h6>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Harga Beli (Modal) Rp <span class="text-danger">*</span></label>
                            <input type="number" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" value="{{ old('purchase_price', $product->purchase_price) }}" min="0" required>
                            @error('purchase_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Harga Jual Rp <span class="text-danger">*</span></label>
                            <input type="number" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror" value="{{ old('selling_price', $product->selling_price) }}" min="0" required>
                            @error('selling_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Minimum Stok Alert <span class="text-danger">*</span></label>
                            <input type="number" name="minimum_stock" class="form-control @error('minimum_stock') is-invalid @enderror" value="{{ old('minimum_stock', $product->minimum_stock) }}" min="0" required>
                            @error('minimum_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center bg-light rounded-3 p-3 mt-3">
                        <div>
                            <span class="text-muted small d-block">Stok Fisik Saat Ini (Hanya berubah lewat transaksi):</span>
                            <strong class="fs-5">{{ $product->stock }} Unit</strong>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('products.index') }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('imagePlaceholder');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
            if (placeholder) placeholder.classList.add('d-none');
        }
    });
</script>
@endpush
@endsection