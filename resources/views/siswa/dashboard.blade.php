@extends('layouts.app')
@section('page-title', 'Katalog Buku')

@section('content')

{{-- HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Katalog Buku</h1>
        <p class="page-subtitle">Selamat datang, <strong>{{ auth()->user()->name }}</strong>! Temukan buku yang ingin kamu pinjam <i class="bi bi-book ms-1"></i></p>
    </div>
</div>

{{-- SEARCH BAR --}}
<form method="GET" action="/siswa" class="mb-4">
    <div style="display:flex; gap:10px; max-width:480px;">
        <div style="position:relative; flex:1;">
            <i class="bi bi-search" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:15px;"></i>
            <input type="text" name="search"
                   style="width:100%; padding:10px 14px 10px 40px; border:1px solid #e2e8f0; border-radius:10px; font-family:'Inter',sans-serif; font-size:14px; outline:none; transition:border 0.18s;"
                   placeholder="Cari judul atau penulis..."
                   value="{{ request('search') }}"
                   onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
        </div>
        <button type="submit" class="btn btn-primary" style="padding:10px 18px;">
            <i class="bi bi-search"></i>
        </button>
        @if(request('search'))
            <a href="/siswa" class="btn btn-secondary" style="padding:10px 14px;">
                <i class="bi bi-x-lg"></i>
            </a>
        @endif
    </div>
</form>

{{-- FILTER SEARCH --}}
@php
    $filteredBooks = $books;
    if(request('search')){
        $filteredBooks = $books->filter(function($book){
            return str_contains(strtolower($book->judul), strtolower(request('search')))
                || str_contains(strtolower($book->penulis), strtolower(request('search')));
        });
    }
@endphp

{{-- NOT FOUND --}}
@if(request('search') && $filteredBooks->isEmpty())
    <div class="alert alert-warning d-flex align-items-center gap-2">
        <i class="bi bi-exclamation-triangle-fill"></i>
        Buku dengan kata kunci "<strong>{{ request('search') }}</strong>" tidak ditemukan.
    </div>
@endif

{{-- BOOK GRID --}}
<div class="row g-3">
    @forelse($filteredBooks as $book)
    <div class="col-lg-4 col-md-6">
        <div class="card h-100" style="transition: transform 0.2s ease, box-shadow 0.2s ease;"
             onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.1)'"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
            <div class="card-body" style="padding:18px;">
                <div style="display:flex; gap:14px; align-items:flex-start;">

                    {{-- COVER --}}
                    @if($book->cover)
                        <img src="{{ asset('storage/'.$book->cover) }}"
                             style="width:72px; height:100px; object-fit:cover; border-radius:8px; flex-shrink:0; box-shadow:0 2px 8px rgba(0,0,0,0.12);">
                    @else
                        <div style="width:72px; height:100px; background:linear-gradient(135deg,#e0e7ff,#ddd6fe); border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi bi-book" style="font-size:24px; color:#6366f1;"></i>
                        </div>
                    @endif

                    {{-- INFO --}}
                    <div style="flex:1; overflow:hidden;">
                        <h6 style="font-size:14px; font-weight:700; color:#0f172a; margin:0 0 4px; line-height:1.3;">
                            {{ $book->judul }}
                        </h6>
                        <div style="font-size:12px; color:#64748b; margin-bottom:10px;">
                            <i class="bi bi-person me-1"></i>{{ $book->penulis }}
                        </div>

                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                            @if($book->stok > 0)
                                <span class="badge" style="background:#ecfdf5; color:#065f46; font-size:11px;">
                                    <i class="bi bi-check-circle me-1"></i>Stok: {{ $book->stok }}
                                </span>
                            @else
                                <span class="badge" style="background:#fef2f2; color:#991b1b; font-size:11px;">
                                    <i class="bi bi-x-circle me-1"></i>Habis
                                </span>
                            @endif
                        </div>

                        <a href="/buku/{{ $book->id }}"
                           style="font-size:13px; color:#2563eb; text-decoration:none; font-weight:600; display:inline-flex; align-items:center; gap:4px;">
                            Lihat Detail <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div style="text-align:center; padding:60px 20px; color:#94a3b8;">
            <i class="bi bi-book" style="font-size:48px; display:block; margin-bottom:12px; color:#cbd5e1;"></i>
            <div style="font-size:16px; font-weight:600; color:#475569;">Belum ada buku tersedia</div>
            <div style="font-size:13px; margin-top:4px;">Silakan hubungi admin untuk menambah koleksi buku.</div>
        </div>
    </div>
    @endforelse
</div>

@endsection