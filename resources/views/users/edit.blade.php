@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header Halaman & Breadcrumb -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none">Kelola Staf</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Pengguna</li>
                </ol>
            </nav>
            <h4 class="fw-bold text-dark mb-0">Perbarui Data Akun</h4>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm px-3 rounded-3 d-inline-flex align-items-center gap-1">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Notifikasi Error Validasi -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>
                    <strong>Periksa kembali formulir:</strong>
                    <ul class="mb-0 mt-1 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Card Form Edit -->
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Input Nama -->
                        <div class="mb-3">
                            <label for="name" class="form-label small fw-semibold text-secondary">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" 
                                   class="form-control rounded-3 @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}" required placeholder="Contoh: Budi Pratama">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-semibold text-secondary">Alamat Email Karyawan <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" 
                                   class="form-control rounded-3 @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" required placeholder="nama@electrohub.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pilihan Hak Akses / Role -->
                        <div class="mb-4">
                            <label for="role" class="form-label small fw-semibold text-secondary">Hak Akses Sistem (Role) <span class="text-danger">*</span></label>
                            <select name="role" id="role" class="form-select rounded-3 @error('role') is-invalid @enderror" required>
                                <option value="admin" {{ old('role', $user->role) === 'admin' || old('role', $user->role) === 'owner' ? 'selected' : '' }}>
                                    Owner / Administrator (Akses Penuh Master Data & Laporan)
                                </option>
                                <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>
                                    Staff Kasir (Khusus Modul POS & Riwayat Transaksi)
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4 border-secondary border-opacity-10">

                        <!-- Pengaturan Kata Sandi Baru -->
                        <div class="mb-3">
                            <h6 class="fw-semibold text-dark mb-1">Ganti Kata Sandi</h6>
                            <p class="text-muted small mb-3">Kosongkan kolom sandi di bawah jika tidak ingin mengubah kata sandi saat ini.</p>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label small fw-semibold text-secondary">Kata Sandi Baru</label>
                                <input type="password" name="password" id="password" 
                                       class="form-control rounded-3 @error('password') is-invalid @enderror" 
                                       placeholder="Minimal 8 karakter">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label small fw-semibold text-secondary">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="form-control rounded-3" 
                                       placeholder="Ulangi kata sandi baru">
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex align-items-center justify-content-end gap-2 pt-2">
                            <a href="{{ route('users.index') }}" class="btn btn-light px-4 rounded-3 text-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 rounded-3 fw-semibold shadow-sm">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection