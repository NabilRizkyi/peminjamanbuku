@extends('layouts.app')
@section('page-title', 'Dashboard')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Kamu berhasil masuk! Selamat datang di LibroHub.</p>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding:28px; text-align:center;">
        <i class="bi bi-book-half" style="font-size:48px; color:#2563eb; display:block; margin-bottom:12px;"></i>
        <h5 style="font-weight:700; color:#0f172a;">Selamat Datang di LibroHub! <i class="bi bi-book-half ms-1"></i></h5>
        <p style="color:#64748b; font-size:14px;">Gunakan menu di sebelah kiri untuk mengakses fitur yang tersedia.</p>
    </div>
</div>

@endsection
