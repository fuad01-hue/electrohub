@extends(view()->exists('layouts.app') ? 'layouts.app' : 'app')

@section('content')
<div style="background-color: #f8fafc; min-height: 100vh; padding: 1.75rem 2rem;">

    <!-- 1. Header Section -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; padding-bottom: 1.25rem; margin-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem;">
                <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #e2e8f0; color: #334155; padding: 2px 8px; border-radius: 4px;">Pengaturan Usaha</span>
                <span style="font-size: 0.75rem; color: #94a3b8;">Aksesibilitas & Pengguna Sistem</span>
            </div>
            <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.02em;">Manajemen Akun Staf & Hak Akses</h1>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem;">Kelola kredensial login operasional kasir, administrator gudang, dan otorisasi menu sistem.</p>
        </div>

        <div>
            <span style="display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.75rem; color: #64748b; background: #ffffff; padding: 0.5rem 0.85rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Otorisasi Aktif: <strong>Role-Based Access (RBAC)</strong>
            </span>
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

    <!-- 2. Dual Workspace Layout (Form Registrasi Staf + Tabel Pengguna) -->
    <div style="display: grid; grid-template-columns: 360px 1fr; gap: 1.5rem; align-items: start;">
        
        <!-- Kolom Kiri: Form Registrasi Akun Staf Baru -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: sticky; top: 1.5rem;">
            <div style="padding-bottom: 0.85rem; margin-bottom: 1rem; border-bottom: 1px solid #f1f5f9;">
                <h2 style="font-size: 0.875rem; font-weight: 700; color: #0f172a; margin: 0;">Tambah Pengguna Baru</h2>
                <p style="font-size: 0.75rem; color: #94a3b8; margin: 2px 0 0 0;">Daftarkan akun kasir atau pengelola baru.</p>
            </div>

            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 0.95rem;">
                    <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                        Nama Lengkap <span style="color: #e11d48;">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Rian Kasir" 
                           style="width: 100%; font-size: 0.8rem; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 0.95rem;">
                    <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                        Alamat Email Login <span style="color: #e11d48;">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="kasir1@perusahaan.com" 
                           style="width: 100%; font-size: 0.8rem; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 0.95rem;">
                    <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                        Hak Akses / Peran <span style="color: #e11d48;">*</span>
                    </label>
                    <select name="role" required style="width: 100%; font-size: 0.8rem; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                        <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff (Kasir & Operator Gudang)</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Pengelola Master Data & Laporan)</option>
                    </select>
                    <span style="font-size: 0.68rem; color: #94a3b8; display: block; margin-top: 0.3rem;">Staff hanya bisa memproses transaksi kasir dan melihat katalog barang.</span>
                </div>

                <div style="margin-bottom: 0.95rem;">
                    <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                        Password Awal <span style="color: #e11d48;">*</span>
                    </label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter" 
                           style="width: 100%; font-size: 0.8rem; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.03em;">
                        Konfirmasi Password <span style="color: #e11d48;">*</span>
                    </label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password di atas" 
                           style="width: 100%; font-size: 0.8rem; padding: 0.55rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: #f8fafc; color: #0f172a; box-sizing: border-box;">
                </div>

                <button type="submit" style="width: 100%; display: flex; justify-content: center; align-items: center; gap: 0.45rem; background-color: #0f172a; color: #ffffff; border: none; padding: 0.65rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                    Simpan Akun Baru
                </button>
            </form>
        </div>

        <!-- Kolom Kanan: Tabel Pengguna Terdaftar -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="font-size: 0.875rem; font-weight: 700; color: #0f172a; margin: 0;">Pengguna Aktif</h2>
                    <p style="font-size: 0.75rem; color: #94a3b8; margin: 2px 0 0 0;">Daftar seluruh akun yang memiliki hak akses login ke sistem.</p>
                </div>
            </div>

            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.8rem;">
                <thead>
                    <tr style="background: #f8fafc; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0;">
                        <th style="padding: 0.85rem 1.25rem; font-weight: 700; width: 45px;">#</th>
                        <th style="padding: 0.85rem 1rem; font-weight: 700;">Identitas Pengguna</th>
                        <th style="padding: 0.85rem 1rem; font-weight: 700;">Tingkat Akses (Role)</th>
                        <th style="padding: 0.85rem 1rem; font-weight: 700;">Waktu Registrasi</th>
                        <th style="padding: 0.85rem 1.25rem; font-weight: 700; text-align: right; width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        
                        <!-- Nomor Urut -->
                        <td style="padding: 0.85rem 1.25rem; font-family: monospace; font-size: 0.75rem; color: #94a3b8;">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </td>

                        <!-- Identitas Pengguna -->
                        <td style="padding: 0.85rem 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.65rem;">
                                <div style="width: 32px; height: 32px; border-radius: 9999px; background: #e2e8f0; color: #334155; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; flex-shrink: 0;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: #0f172a; font-size: 0.85rem;">
                                        {{ $user->name }}
                                        @if(auth()->id() === $user->id)
                                            <span style="font-size: 0.65rem; color: #2563eb; background: #eff6ff; padding: 1px 5px; border-radius: 3px; margin-left: 3px; font-weight: 600;">Anda</span>
                                        @endif
                                    </div>
                                    <div style="font-size: 0.72rem; color: #64748b; font-family: monospace;">
                                        {{ $user->email }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Role Badge -->
                        <td style="padding: 0.85rem 1rem;">
                            @if($user->role === 'owner')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                    OWNER (Full Akses)
                                </span>
                            @elseif($user->role === 'staff')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                    STAFF / KASIR
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    CUSTOMER / PELANGGAN
                                </span>
                            @endif
                        </td>

                        <!-- Tanggal Terdaftar -->
                        <td style="padding: 0.85rem 1rem; color: #64748b; font-size: 0.75rem;">
                            {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                        </td>

                        <!-- Aksi -->
                        <td style="padding: 0.85rem 1.25rem; text-align: right;">
                            <a href="{{ route('users.edit', $user) }}" title="Edit Pengguna" 
                               style="padding: 5px 8px; color: #2563eb; background: #eff6ff; border: 1px solid #dbeafe; border-radius: 0.375rem; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; font-size: 0.72rem; font-weight: 600;">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 3px;"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                Edit
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 3rem 1.25rem; text-align: center; color: #94a3b8;">
                            <p style="font-size: 0.85rem; font-weight: 600; color: #64748b; margin: 0;">Belum ada data staf terdaftar.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection