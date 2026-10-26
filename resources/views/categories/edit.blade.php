@extends('layouts.app')

@section('title', 'Edit Kategori - ' . $category->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Edit Kategori</h3>
        <p class="text-muted small mb-0">Perbarui nama kategori <strong>{{ $category->name }}</strong>.</p>
    </div>
    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 500px;">
    <div class="card-body p-4">
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="form-label fw-medium">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            </div>
            
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-save me-1"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection