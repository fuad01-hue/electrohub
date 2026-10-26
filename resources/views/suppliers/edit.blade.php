@extends('layouts.app')

@section('title', 'Edit Supplier - ' . $supplier->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Edit Data Supplier</h3>
        <p class="text-muted small mb-0">Perbarui informasi kontak dan alamat untuk <strong>{{ $supplier->name }}</strong>.</p>
    </div>
    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label fw-medium">Nama Perusahaan/Toko <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $supplier->name) }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-medium">Nomor Telepon / WA</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $supplier->phone) }}">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-medium">Email Utama</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $supplier->email) }}">
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-medium">Alamat Lengkap</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address', $supplier->address) }}</textarea>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection