<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk – LibroHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #2563eb;
            --radius: 14px;
        }

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
            max-width: 500px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            min-height: 520px;
        }

        /* LEFT PANEL */
        .auth-side {
            flex: 1;
            background: linear-gradient(135deg, #1e40af 0%, #7c3aed 100%);
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

        /* RIGHT PANEL */
        .auth-main {
            flex: 1;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
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
            margin: 0 0 28px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 10px !important;
            border: 1px solid #e2e8f0 !important;
            font-size: 14px !important;
            padding: 10px 14px !important;
            font-family: 'Inter', sans-serif;
            transition: all 0.18s ease;
        }

        .form-control:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12) !important;
        }

        .btn-login {
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

        .btn-login:hover {
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

        .auth-link a:hover {
            text-decoration: underline;
        }

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

    {{-- MAIN FORM --}}
    <div class="auth-main">
        
        @if(session('success'))
    <div class="alert alert-warning">
        {{ session('success') }}
    </div>
@endif

        <div class="auth-title">Selamat Datang <i class="bi bi-person-check ms-1" style="color: #2563eb;"></i></div>
        <div class="auth-subtitle">Masuk ke akunmu untuk melanjutkan</div>

        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-envelope me-1" style="color:#2563eb;"></i>
                    Alamat Email
                </label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="nama@email.com"
                       value="{{ old('email') }}"
                       required autofocus>
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
                       placeholder="Masukkan kata sandi"
                       required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>

        </form>

        <div class="auth-link">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>

    </div>
</div>

</body>
</html>