@extends('layouts.app')
@section('page-title', 'Kelola Buku')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Kelola Buku</h1>
        <p class="page-subtitle">Tambah, edit, dan hapus koleksi buku perpustakaan</p>
    </div>
    <a href="{{ route('books.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Tambah Buku
    </a>
</div>

{{-- ALERT SUKSES --}}
@if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
@endif

{{-- GRID CARD BUKU --}}
<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4 mt-1">
    @forelse($books as $book)
    <div class="col">
        <div class="card h-100 border-0" style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)';" onmouseout="this.style.transform='translateY(0)';">
            
            {{-- Badge Status Overlay --}}
            <div style="position: absolute; top: 12px; right: 12px; z-index: 10;">
                @if($book->stok > 0)
                    <span style="background: rgba(16, 185, 129, 0.9); color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; backdrop-filter: blur(4px);">
                        <i class="ph-bold ph-check-circle me-1"></i>Tersedia
                    </span>
                @else
                    <span style="background: rgba(239, 68, 68, 0.9); color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; backdrop-filter: blur(4px);">
                        <i class="ph-bold ph-x-circle me-1"></i>Habis
                    </span>
                @endif
            </div>

            {{-- Cover Image --}}
            <div style="position: relative; width: 100%; padding-top: 115%;"> {{-- Aspect ratio diperpendek --}}
                <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://ui-avatars.com/api/?name='.urlencode(substr($book->judul,0,2)).'&background=random&color=fff&size=300' }}" 
                     style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
            </div>
            
            {{-- Card Body --}}
            <div class="card-body p-2 d-flex flex-column">
                <h6 style="font-weight: 700; color: #1e293b; font-size: 14px; margin-bottom: 4px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.3;">
                    {{ $book->judul }}
                </h6>
                <div style="color: #64748b; font-size: 12px; margin-bottom: 8px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    <i class="ph-duotone ph-user me-1"></i>{{ $book->penulis }}
                </div>
                
                <div class="d-inline-flex align-items-center mb-2" style="font-size: 11px; font-weight: 600; color: #475569; background: #f1f5f9; padding: 3px 8px; border-radius: 6px; align-self: flex-start;">
                    <i class="ph-bold ph-books me-2 text-primary"></i> Sisa Stok: {{ $book->stok }}
                </div>

                <div class="mt-auto"></div>

                {{-- Admin Actions --}}
                <div class="d-flex gap-2 mt-1 pt-2" style="border-top: 1px dashed #e2e8f0;">
                    <a href="{{ route('books.edit', $book->id) }}" class="btn w-50" style="background: #eff6ff; color: #3b82f6; font-weight: 600; border-radius: 6px; padding: 4px 0; font-size: 12px;">
                        <i class="ph-bold ph-pencil-simple me-1"></i> Edit
                    </a>
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="w-50" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn w-100" style="background: #fef2f2; color: #ef4444; font-weight: 600; border-radius: 6px; padding: 4px 0; font-size: 12px;">
                            <i class="ph-bold ph-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    @empty
    <div class="col-12 w-100 text-center py-5">
        <div style="padding: 40px; background: #ffffff; border-radius: 16px; border: 2px dashed #cbd5e1;">
            <i class="ph-duotone ph-books" style="font-size: 48px; color: #94a3b8; margin-bottom: 16px;"></i>
            <h5 style="color: #475569; font-weight: 600;">Belum ada koleksi buku</h5>
            <p style="color: #94a3b8; font-size: 14px; margin-bottom: 20px;">Silakan tambahkan buku pertama Anda untuk mulai mengelola perpustakaan.</p>
            <a href="{{ route('books.create') }}" class="btn btn-primary" style="font-weight: 500; border-radius: 10px;">
                <i class="ph-bold ph-plus me-2"></i> Tambah Buku Baru
            </a>
        </div>
    </div>
    @endforelse
</div>

@endsection