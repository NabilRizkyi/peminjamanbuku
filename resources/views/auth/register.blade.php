<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar – LibroHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root { --primary: #2563eb; }
        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        /* FIX 1: max-width dinaikkan agar sidebar tidak gepeng */
        .auth-wrapper {
            display: flex;
            width: 100%;
            max-width: 820px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            min-height: 540px;
        }

        /* FIX 2: sidebar lebar tetap, tidak flex:1 */
        .auth-side {
            width: 300px;
            min-width: 300px;
            background: linear-gradient(135deg, #7c3aed 0%, #3b82f6 100%);
            padding: 48px 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
        }

        .auth-side-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .auth-side-logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.05) 100%);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #ffffff;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }

        .auth-side-brand {
            font-size: 20px;
            font-weight: 700;
        }

        .auth-side-tagline {
            font-size: 13px;
            opacity: 0.8;
        }

        .auth-side-headline {
            font-size: 24px;
            font-weight: 700;
            line-height: 1.35;
            margin: 0 0 12px;
        }

        .auth-side-desc {
            font-size: 13px;
            opacity: 0.8;
            line-height: 1.6;
        }

        /* FIX 3: form area flex:1 dengan overflow scroll */
        .auth-main {
            flex: 1;
            padding: 40px 36px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            overflow-y: auto;
            max-height: 100vh;
        }

        .auth-title {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 4px;
        }

        .auth-subtitle {
            font-size: 13px;
            color: #64748b;
            margin: 0 0 20px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            border-radius: 10px !important;
            border: 1px solid #e2e8f0 !important;
            font-size: 14px !important;
            padding: 10px 14px !important;
            font-family: 'Inter', sans-serif;
            transition: all 0.18s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12) !important;
        }

        .btn-register {
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.18s ease;
            margin-top: 4px;
        }

        .btn-register:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(37,99,235,0.35);
        }

        .auth-link {
            font-size: 13px;
            text-align: center;
            color: #64748b;
            margin-top: 16px;
        }

        .auth-link a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .auth-link a:hover { text-decoration: underline; }

        /* FIX 4: alert konsisten border-radius & warna */
        .alert-success {
            border-radius: 10px !important;
            border: none !important;
            background: #ecfdf5 !important;
            color: #065f46 !important;
            border-left: 4px solid #10b981 !important;
            font-size: 13px;
        }

        .alert-danger {
            border-radius: 10px !important;
            border: none !important;
            background: #fef2f2 !important;
            color: #7f1d1d !important;
            border-left: 4px solid #ef4444 !important;
            font-size: 13px;
        }

        /* FIX 5: info box pakai warna konsisten dengan --primary */
        .auth-info-box {
            background: #eff6ff;
            color: #1e3a8a;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-top: 14px;
            border-left: 4px solid #2563eb;
            line-height: 1.5;
        }

        /* FIX 6: mobile — sembunyikan sidebar, tampilkan header kecil */
        @media (max-width: 640px) {
            .auth-wrapper {
                flex-direction: column;
                max-width: 100%;
            }

            .auth-side {
                width: 100%;
                min-width: unset;
                padding: 24px;
                flex-direction: row;
                align-items: center;
                justify-content: flex-start;
                gap: 14px;
                min-height: unset;
            }

            .auth-side-headline,
            .auth-side-desc,
            .auth-side-footer {
                display: none;
            }

            .auth-main {
                padding: 28px 20px;
            }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">

    {{-- SIDE --}}
    <div class="auth-side">
        <div class="auth-side-logo">
            <div class="auth-side-logo-icon"><i class="bi bi-book-half"></i></div>
            <div>
                <div class="auth-side-brand">Library</div>
                <div class="auth-side-tagline">Perpustakaan Digital</div>
            </div>
        </div>

        <div>
            <div class="auth-side-headline">
                Bergabung dengan<br>Library hari ini! <i class="bi bi-rocket-takeoff"></i>
            </div>
            <div class="auth-side-desc">
                Daftar sekarang dan nikmati kemudahan akses koleksi buku perpustakaan kapan saja dan di mana saja.
            </div>
        </div>

        <div class="auth-side-footer" style="font-size:12px; opacity:0.6;">
            © {{ date('Y') }} Library. Semua hak dilindungi.
        </div>
    </div>

    {{-- FORM --}}
    {{-- FIX 7: session success dipindah ke dalam .auth-main --}}
    <div class="auth-main">

        @if(session('success'))
            <div class="alert alert-success mb-3">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="auth-title">Buat Akun Baru <i class="bi bi-pencil-square"></i></div>
        <div class="auth-subtitle">Isi data berikut untuk mendaftar</div>

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <ul class="mb-0 mt-1" style="padding-left:16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-person me-1" style="color:#2563eb;"></i>
                    Nama Lengkap
                </label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Nama lengkap kamu"
                       value="{{ old('name') }}"
                       required autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-envelope me-1" style="color:#2563eb;"></i>
                    Alamat Email
                </label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="nama@email.com"
                       value="{{ old('email') }}"
                       required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-lock me-1" style="color:#2563eb;"></i>
                    Kata Sandi
                </label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Minimal 8 karakter"
                       required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-shield-lock me-1" style="color:#2563eb;"></i>
                    Konfirmasi Kata Sandi
                </label>
                <input type="password" name="password_confirmation"
                       class="form-control"
                       placeholder="Ulangi kata sandi"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-telephone me-1" style="color:#2563eb;"></i>
                    No HP
                </label>
                <input type="text" name="no_hp"
                       class="form-control"
                       pattern="^\+?[0-9]+$"
                       inputmode="numeric"
                       placeholder="Masukkan No Telepon"
                       oninput="this.value = this.value.replace(/[^0-9+]/g, '')"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-geo-alt me-1" style="color:#2563eb;"></i>
                    Alamat
                </label>
                <textarea name="alamat"
                          class="form-control"
                          placeholder="Masukkan alamat lengkap"
                          rows="3"
                          required>{{ old('alamat') }}</textarea>
            </div>

            <button type="submit" class="btn-register">
                <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
            </button>

        </form>

        <div class="auth-link">
            Sudah punya akun?
            <a href="{{ route('login') }}">Masuk di sini</a>
        </div>

        {{-- FIX 8: pakai class, bukan inline style hardcode --}}
        <div class="auth-info-box">
            <i class="bi bi-info-circle me-1"></i>
            Setelah daftar, akun kamu harus disetujui admin terlebih dahulu.
        </div>

    </div>
</div>

</body>
</html>
