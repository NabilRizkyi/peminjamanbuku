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

        .auth-wrapper {
            display: flex;
            width: 100%;
            max-width: 900px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            min-height: 540px;
        }

        .auth-side {
            flex: 1;
            background: linear-gradient(135deg, #7c3aed 0%, #3b82f6 100%);
            padding: 48px 40px;
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
            font-size: 24px;
            color: #ffffff;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
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
            font-size: 26px;
            font-weight: 700;
            line-height: 1.35;
            margin: 0 0 12px;
        }

        .auth-side-desc {
            font-size: 14px;
            opacity: 0.8;
            line-height: 1.6;
        }

        .auth-main {
            flex: 1;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
        }

        .auth-title {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 6px;
        }

        .auth-subtitle {
            font-size: 13px;
            color: #64748b;
            margin: 0 0 24px;
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
            margin-top: 8px;
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
            margin-top: 20px;
        }

        .auth-link a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .auth-link a:hover { text-decoration: underline; }

        .alert-danger {
            border-radius: 10px !important;
            border: none !important;
            background: #fef2f2 !important;
            color: #7f1d1d !important;
            border-left: 4px solid #ef4444 !important;
            font-size: 13px;
        }

        @media (max-width: 640px) {
            .auth-side { display: none; }
            .auth-main { padding: 36px 24px; }
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
                <div class="auth-side-brand">LibroHub</div>
                <div class="auth-side-tagline">Perpustakaan Digital</div>
            </div>
        </div>

        <div>
            <div class="auth-side-headline">
                Bergabung dengan<br>LibroHub hari ini! <i class="bi bi-rocket-takeoff"></i>
            </div>
            <div class="auth-side-desc">
                Daftar sekarang dan nikmati kemudahan akses koleksi buku perpustakaan kapan saja dan di mana saja.
            </div>
        </div>

        <div style="font-size:12px; opacity:0.6;">
            © {{ date('Y') }} LibroHub. Semua hak dilindungi.
        </div>
    </div>

    {{-- FORM --}}
    <div class="auth-main">

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
                    <i class="bi bi-person-badge me-1" style="color:#2563eb;"></i>
                    Daftar Sebagai
                </label>
                <select name="role" class="form-select">
                    <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <button type="submit" class="btn-register">
                <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
            </button>

        </form>

        <div class="auth-link">
            Sudah punya akun?
            <a href="{{ route('login') }}">Masuk di sini</a>
        </div>

    </div>
</div>

</body>
</html>