<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - ElectroHub Retail System</title>
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    
</head>
<body>

<div class="auth-wrapper row g-0">
    
    <!-- Kolom Kiri: Visual Branding -->
    <div class="col-lg-6 d-none d-lg-flex visual-pane">
        <div class="illustration-box">
            <svg class="img-fluid mb-4" viewBox="0 0 500 400" fill="none" xmlns="http://www.w3.org/2000/svg" style="max-height: 320px;">
                <ellipse cx="250" cy="365" rx="190" ry="16" fill="#E2E8F0" />
                <rect x="75" y="90" width="350" height="260" rx="20" fill="#FFFFFF" stroke="#E2E8F0" stroke-width="3" />
                
                <!-- Kanopi Toko -->
                <path d="M75 110C75 98.9543 83.9543 90 95 90H405C416.046 90 425 98.9543 425 110V140C405 140 395 160 375 160C355 160 345 140 325 140C305 140 295 160 275 160C255 160 245 140 225 140C205 140 195 160 175 160C155 160 145 140 125 140C105 140 95 160 75 160V110Z" fill="#2563EB" />
                <path d="M125 140C145 140 155 160 175 160C195 160 205 140 225 140V90H175H125V140Z" fill="#1D4ED8" />
                <path d="M275 160C295 160 305 140 325 140V90H275V160Z" fill="#1D4ED8" />
                <path d="M375 160C395 160 405 140 425 140V90H375V160Z" fill="#1D4ED8" />
                
                <!-- Terminal POS -->
                <rect x="110" y="185" width="130" height="95" rx="8" fill="#F1F5F9" stroke="#CBD5E1" stroke-width="2" />
                <rect x="122" y="198" width="50" height="8" rx="4" fill="#2563EB" />
                <rect x="122" y="214" width="105" height="4" rx="2" fill="#94A3B8" />
                <rect x="122" y="224" width="85" height="4" rx="2" fill="#CBD5E1" />
                <rect x="122" y="246" width="60" height="18" rx="4" fill="#10B981" />
                <path d="M165 280L160 305H190L185 280H165Z" fill="#64748B" />
                <rect x="150" y="305" width="50" height="6" rx="3" fill="#475569" />

                <!-- Mockup Hardware Laptop -->
                <rect x="270" y="200" width="125" height="80" rx="6" fill="#0F172A" />
                <rect x="280" y="210" width="105" height="60" rx="3" fill="#1E293B" />
                <polygon points="332,230 345,242 320,242" fill="#EF4444" />
                <path d="M255 280H410C412.2 280 414 281.8 414 284V286C414 288.2 412.2 290 410 290H255C252.8 290 251 288.2 251 286V284C251 281.8 252.8 280 255 280Z" fill="#94A3B8" />

                <!-- Invoice Mengambang -->
                <g filter="drop-shadow(0 8px 16px rgba(0,0,0,0.06))">
                    <rect x="330" y="125" width="100" height="65" rx="8" fill="#FFFFFF" stroke="#E2E8F0" />
                    <circle cx="348" cy="145" r="8" fill="#DCFCE7" />
                    <path d="M345 145L347 147L352 142" stroke="#16A34A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <rect x="362" y="140" width="52" height="5" rx="2.5" fill="#334155" />
                    <rect x="362" y="149" width="35" height="4" rx="2" fill="#94A3B8" />
                    <rect x="342" y="166" width="76" height="12" rx="3" fill="#F8FAFC" />
                </g>

                <!-- Box Stok -->
                <rect x="100" y="295" width="45" height="45" rx="4" fill="#FDE68A" stroke="#F59E0B" stroke-width="1.5" />
                <path d="M100 310H145" stroke="#F59E0B" stroke-width="1.5" />
                <path d="M122.5 310V340" stroke="#F59E0B" stroke-width="1.5" />
            </svg>

            <h4 class="fw-bold text-dark mb-2">Kelola Retail & Kasir Terpadu</h4>
            <p class="text-secondary small mb-0 px-3">
                Satu platform untuk sinkronisasi katalog unit, pencatatan transaksi kasir, serta akurasi inventaris fisik tanpa selisih stok.
            </p>
        </div>
    </div>

    <!-- Kolom Kanan: Form Autentikasi Standar -->
    <div class="col-lg-6 form-pane">
        <div class="form-container">
            
            <!-- Logo Brand -->
            <div class="mb-4">
                <a href="{{ url('/') }}" class="text-decoration-none d-inline-flex align-items-center gap-2">
                    <div class="bg-primary text-white rounded-3 p-2 d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 36px; height: 36px;">
                        <i class="bi bi-cpu-fill fs-5"></i>
                    </div>
                    <span class="fs-4 fw-bold text-dark"><span class="text-primary">Electro</span>Hub</span>
                </a>
            </div>

            <div class="mb-4">
                <h3 class="fw-bold text-dark mb-1">Masuk ke Portal</h3>
                <p class="text-secondary small">Masukkan kredensial akun untuk mengakses sistem operasional.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger py-2 px-3 small border-0 rounded-3 mb-3">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Input Email -->
                <div class="mb-3">
                    <label for="email" class="form-label small fw-semibold text-secondary mb-1">Email Karyawan</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                           class="form-control" required autofocus placeholder="nama@electrohub.com">
                </div>

                <!-- Input Password -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="form-label small fw-semibold text-secondary mb-0">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none small" style="font-size: 0.78rem; color: var(--brand-primary);">
                                Lupa kata sandi?
                            </a>
                        @endif
                    </div>
                    <div class="input-group">
                        <input id="password" type="password" name="password" class="form-control" required placeholder="••••••••">
                        <span class="input-group-text toggle-password" onclick="togglePasswordVisibility()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label text-secondary small" for="remember_me">
                        Ingat sesi saya
                    </label>
                </div>

                <button type="submit" class="btn btn-brand w-100 shadow-sm d-flex align-items-center justify-content-center gap-2">
                    <span>Masuk ke Dashboard</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <div class="text-center mt-4 pt-2">
                <a href="{{ url('/') }}" class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-1">
                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda Utama
                </a>
            </div>

            <div class="text-center mt-5">
                <span class="text-muted" style="font-size: 0.75rem;">
                    &copy; {{ date('Y') }} ElectroHub Retail Enterprise. All rights reserved.
                </span>
            </div>

        </div>
    </div>

</div>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        }
    }
</script>

</body>
</html>