@extends('layouts.app')
@section('page-title', 'Dashboard Admin')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard Admin</h1>
        <p class="page-subtitle">Selamat datang, {{ auth()->user()->name }} <i class="bi bi-person-check ms-1" style="color: #2563eb;"></i></p>
    </div>
    <div class="text-muted" style="font-size:13px;">
        <i class="bi bi-calendar3 me-1"></i>
        {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: #eff6ff;">
                <i class="bi bi-book-fill" style="color:#2563eb;"></i>
            </div>
            <div>
                <div class="stat-value">{{ $totalBuku }}</div>
                <div class="stat-label">Total Buku</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: #fefce8;">
                <i class="bi bi-arrow-up-circle-fill" style="color:#ca8a04;"></i>
            </div>
            <div>
                <div class="stat-value">{{ $totalDipinjam }}</div>
                <div class="stat-label">Sedang Dipinjam</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: #f0fdf4;">
                <i class="bi bi-check-circle-fill" style="color:#16a34a;"></i>
            </div>
            <div>
                <div class="stat-value">{{ $totalSelesai }}</div>
                <div class="stat-label">Dikembalikan</div>
            </div>
        </div>
    </div>

</div>

{{-- BUKU TERBARU --}}
<div class="card">
    <div class="card-body" style="padding: 0;">
        <div style="padding: 20px 24px 16px; border-bottom: 1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
            <div style="font-size:15px; font-weight:600; color:#0f172a;">
                <i class="bi bi-clock-history me-2" style="color:#2563eb;"></i>
                Buku Terbaru Ditambahkan
            </div>
            <a href="{{ route('books.index') }}" style="font-size:13px; color:#2563eb; text-decoration:none; font-weight:500;">
                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div style="padding: 24px; background: #f8fafc;">
            <div class="row g-3">
                @forelse($recentBooks as $book)
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border-0" style="background:#ffffff; border-radius:12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 12px;">
                        <div class="d-flex gap-3 align-items-center">
                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://ui-avatars.com/api/?name='.urlencode(substr($book->judul,0,2)).'&background=random&color=fff&size=80' }}" 
                                 style="width: 55px; height: 80px; object-fit: cover; border-radius: 6px; box-shadow: 0 4px 6px rgba(0,0,0,0.06); flex-shrink:0;">
                            
                            <div style="overflow: hidden; width: 100%;">
                                <div style="font-weight:600; color:#1e293b; margin-bottom:2px; font-size:14px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ $book->judul }}
                                </div>
                                <div style="color:#64748b; font-size:12px; margin-bottom:8px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ $book->penulis }}
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    @if($book->stok > 0)
                                        <span style="font-size:11px; font-weight:600; color:#2563eb; background:#eff6ff; padding:2px 8px; border-radius:4px; display:inline-flex; align-items:center;">
                                            <i class="ph-bold ph-check me-1"></i> {{ $book->stok }} Tersedia
                                        </span>
                                    @else
                                        <span style="font-size:11px; font-weight:600; color:#dc2626; background:#fef2f2; padding:2px 8px; border-radius:4px; display:inline-flex; align-items:center;">
                                            <i class="ph-bold ph-x me-1"></i> Habis
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center" style="padding: 40px; background:#ffffff; border-radius:12px; border:1px dashed #cbd5e1;">
                        <i class="ph-duotone ph-books" style="font-size:32px; display:block; margin-bottom:8px; color:#94a3b8;"></i>
                        <span style="color:#64748b; font-weight:500;">Belum ada data buku</span>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection