@extends('layouts.app')

@section('title', 'Profil Pengguna - ElectroHub')

@section('content')
<div class="space-y-6 max-w-4xl">
    <!-- Header Halaman -->
    <div>
        <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-2.5 py-1 rounded">
            PENGATURAN AKUN
        </span>
        <h1 class="text-2xl font-bold text-slate-800 mt-2">Informasi Profil & Kredensial</h1>
        <p class="text-sm text-slate-500">Perbarui data profil pribadi dan kata sandi akun login Anda.</p>
    </div>

    <!-- Alert Notifikasi Sukses -->
    @if (session('status') === 'profile-updated' || session('success'))
        <div class="p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            Perubahan data profil berhasil disimpan.
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Kartu 1: Edit Data Diri -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <h2 class="text-base font-bold text-slate-800 mb-1">Data Pribadi</h2>
            <p class="text-xs text-slate-500 mb-4">Informasi nama lengkap dan alamat surel aktif.</p>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('patch')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                        class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('name')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                        class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('email')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Hak Akses Sistem</label>
                    <input type="text" value="{{ strtoupper(auth()->user()->role) }}" disabled
                        class="w-full px-3 py-2 text-sm bg-slate-100 border border-slate-200 rounded-lg text-slate-500 font-semibold cursor-not-allowed">
                </div>

                <div class="pt-2">
                    <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold rounded-lg transition-colors">
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>

        <!-- Kartu 2: Ganti Password -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <h2 class="text-base font-bold text-slate-800 mb-1">Perbarui Kata Sandi</h2>
            <p class="text-xs text-slate-500 mb-4">Pastikan menggunakan kombinasi sandi yang aman.</p>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('put')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" required
                        class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('current_password', 'updatePassword')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kata Sandi Baru</label>
                    <input type="password" name="password" required
                        class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('password', 'updatePassword')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Ulangi Sandi Baru</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="pt-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors">
                        Ubah Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection