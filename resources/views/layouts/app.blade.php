<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library – Aplikasi Peminjaman Buku</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font: Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{-- Phosphor Icons --}}
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --sidebar-bg: #263b3f;
            --sidebar-hover: #1e293b;
            --sidebar-active: #2563eb;
            --sidebar-active-bg: rgba(37, 99, 235, 0.15);
            --sidebar-text: #94a3b8;
            --sidebar-width: 260px;
            --content-bg: #f1f5f9;
            --card-bg: #ffffff;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --border: #e2e8f0;
            --radius: 12px;
            --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.07), 0 10px 30px rgba(0,0,0,0.08);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--content-bg);
            margin: 0;
            color: var(--text-primary);
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar-header {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .sidebar-logo-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
        }

        .sidebar-logo-text {
            font-size: 18px;
            font-weight: 700;
            color: #f8fafc;
            letter-spacing: -0.3px;
        }

        .sidebar-logo-sub {
            font-size: 11px;
            font-weight: 400;
            color: var(--sidebar-text);
            display: block;
            margin-top: -2px;
        }

        /* ── NAV SECTION ── */
        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #475569;
            padding: 8px 10px 6px;
            margin-top: 8px;
        }

        .nav-link-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--sidebar-text);
            padding: 10px 12px;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 2px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.18s ease;
            position: relative;
        }

        .nav-link-item i, .nav-link-item [class^="ph-"] {
            font-size: 18px;
            width: 22px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-link-item:hover {
            background: var(--sidebar-hover);
            color: #f1f5f9;
        }

        .nav-link-item.active {
            background: var(--sidebar-active-bg);
            color: #60a5fa;
            font-weight: 600;
        }

        .nav-link-item.active i, .nav-link-item.active [class^="ph-"] {
            color: #60a5fa;
            font-weight: 600;
        }

        /* ── SIDEBAR BOTTOM ── */
        .sidebar-bottom {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            background: rgba(255,255,255,0.04);
            margin-bottom: 10px;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            color: white;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: #e2e8f0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 11px;
            color: var(--sidebar-text);
        }

        .btn-logout {
            width: 100%;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 13px;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.18s ease;
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
        }

        /* ── CONTENT AREA ── */
        .content-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── MAIN CONTENT ── */
        .main-content {
            padding: 28px;
            flex: 10;
            margin-left: 270px;
        }

        /* ── CARDS ── */
        .card {
            border: 1px solid var(--border) !important;
            box-shadow: var(--shadow) !important;
            border-radius: var(--radius) !important;
        }

        /* ── BUTTONS ── */
        .btn-primary {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
            font-weight: 500;
            font-size: 14px;
            border-radius: 8px !important;
            padding: 8px 16px;
            transition: all 0.18s ease;
        }

        .btn-primary:hover {
            background: var(--primary-hover) !important;
            border-color: var(--primary-hover) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3) !important;
        }

        .btn-success {
            font-weight: 500;
            font-size: 14px;
            border-radius: 8px !important;
            transition: all 0.18s ease;
        }

        .btn-warning {
            font-weight: 500;
            font-size: 14px;
            margin: 4px;
            border-radius: 8px !important;
            transition: all 0.18s ease;
        }

        .btn-danger {
            font-weight: 500;
            font-size: 14px;
            margin: 4px;
            border-radius: 8px !important;
            transition: all 0.18s ease;
        }

        .btn-secondary {
            font-weight: 500;
            font-size: 14px;
            border-radius: 8px !important;
            transition: all 0.18s ease;
        }

        /* ── FORM CONTROLS ── */
        .form-control, .form-select {
            border-radius: 8px !important;
            border: 1px solid var(--border) !important;
            font-size: 14px !important;
            padding: 10px 14px !important;
            font-family: 'Inter', sans-serif;
            transition: all 0.18s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12) !important;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        /* ── TABLE ── */
        .table {
            font-size: 14px;
        }

        .table thead th {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border) !important;
            padding: 12px 16px;
        }

        .table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9 !important;
            vertical-align: middle;
        }

        .table tbody tr:last-child td {
            border-bottom: none !important;
        }

        .table tbody tr:hover td {
            background: #f8fafc;
        }

        /* ── BADGES ── */
        .badge {
            font-size: 11px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 20px;
            letter-spacing: 0.3px;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .page-subtitle {
            font-size: 13px;
            color: var(--text-secondary);
            margin: 4px 0 0;
        }

        /* ── ALERT ── */
        .alert {
            border-radius: 10px !important;
            border: none !important;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success {
            background: #ecfdf5 !important;
            color: #065f46 !important;
            border-left: 4px solid #10b981 !important;
        }

        .alert-warning {
            background: #fffbeb !important;
            color: #78350f !important;
            border-left: 4px solid #f59e0b !important;
        }

        .alert-danger {
            background: #fef2f2 !important;
            color: #7f1d1d !important;
            border-left: 4px solid #ef4444 !important;
        }

        /* ── STAT CARD ── */
        .stat-card {
            background: white;
            border-radius: var(--radius);
            padding: 20px 24px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        /* ── SCROLLBAR ── */
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }

        /* ── PAGE FADE ── */
        .main-content { animation: fadeIn 0.25s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

{{-- ═══════════════════════════════════════ SIDEBAR ═══════════════════════════════════════ --}}
<div class="sidebar">

    {{-- HEADER --}}
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-logo">
            <div class="sidebar-logo-icon"><i class="ph-fill ph-book-open-text"></i></div>
            <div>
                <div class="sidebar-logo-text">Library</div>
                <span class="sidebar-logo-sub">Perpustakaan Digital</span>
            </div>
        </a>
    </div>

    {{-- NAV --}}
    <div class="sidebar-nav">

        @if(auth()->user()->role === 'admin')
            <div class="nav-section-label">Menu Utama</div>

            <a href="{{ route('dashboard') }}"
               class="nav-link-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="ph-duotone ph-squares-four"></i>
                Dashboard
            </a>

            <div class="nav-section-label">Administrasi</div>

            <a href="{{ route('books.index') }}"
               class="nav-link-item {{ request()->routeIs('books.*') ? 'active' : '' }}">
                <i class="ph-duotone ph-books"></i>
                Kelola Buku
            </a>

            <a href="{{ route('admin.borrowings') }}"
               class="nav-link-item {{ request()->routeIs('admin.borrowings') ? 'active' : '' }}">
                <i class="ph-duotone ph-clipboard-text"></i>
                Data Peminjaman
            </a>
            
        @endif

        @if(auth()->user()->role === 'anggota')
            <div class="nav-section-label">Peminjaman</div>

            <a href="{{ route('anggota.dashboard') }}"
               class="nav-link-item {{ request()->routeIs('anggota.dashboard') ? 'active' : '' }}">
                <i class="ph-duotone ph-book-bookmark"></i>
                Katalog Buku
            </a>

            <a href="{{ route('riwayat') }}"
               class="nav-link-item {{ request()->routeIs('riwayat') ? 'active' : '' }}">
                <i class="ph-duotone ph-clock-counter-clockwise"></i>
                Riwayat Peminjaman
            </a>
        

        @endif

        <div class="nav-section-label">Akun</div>

        <a href="{{ route('profile.edit') }}"
           class="nav-link-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="ph-duotone ph-user-circle"></i>
            Profil Saya
        </a>

    </div>

    {{-- BOTTOM --}}
    <div class="sidebar-bottom">
        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div style="overflow:hidden;">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="ph-bold ph-sign-out"></i>
                Keluar
            </button>
        </form>
    </div>

</div>

    {{-- MAIN --}}
    <div class="main-content">
        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>