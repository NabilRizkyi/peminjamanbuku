@extends('layouts.app')

@section('content')

<style>
    .pagination {
        gap: 6px;
    }

    .pagination .page-link {
        border-radius: 8px !important;
        border: none;
        color: #334155;
        padding: 6px 12px;
        font-weight: 500;
    }

    .pagination .page-item.active .page-link {
        background: #3b82f6;
        color: white;
    }

    .pagination .page-link:hover {
        background: #e2e8f0;
    }
</style>

<div class="container-custom">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold">Welcome, {{ auth()->user()->name }}</h4>
    </div>

    {{-- SEARCH --}}
    <form method="GET" action="/anggota" class="mb-4 d-flex gap-2">
        <input type="text" name="search" class="form-control"
            placeholder="Cari judul, penulis..."
            value="{{ request('search') }}">

        <button class="btn btn-primary">Cari</button>
        <a href="/anggota" class="btn btn-secondary">Reset</a>
    </form>

    {{-- FILTER --}}
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
        <div class="alert alert-warning">
            Buku tidak ditemukan
        </div>
    @endif

    {{-- GRID RAPI --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

        @forelse($filteredBooks as $book)
        <div class="col">

            <div class="card h-100 shadow-sm border-0"
                 style="border-radius: 14px; transition:.2s;"
                 onmouseover="this.style.transform='translateY(-4px)'"
                 onmouseout="this.style.transform='translateY(0)'">

                <div class="card-body d-flex">

                    {{-- COVER --}}
                    <div style="width:80px; height:110px; flex-shrink:0;">
                        @if($book->cover)
                            <img src="{{ asset('storage/'.$book->cover) }}"
                                 style="width:100%; height:100%; object-fit:cover; border-radius:8px;">
                        @else
                            <div style="width:100%; height:100%; background:#eee; border-radius:8px;"></div>
                        @endif
                    </div>

                    {{-- INFO --}}
                    <div class="ms-3 d-flex flex-column w-100">

                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-1 fw-semibold">{{ $book->judul }}</h6>
                                <small class="text-muted">{{ $book->penulis }}</small>
                            </div>

                            <span class="badge bg-info text-dark align-self-start">
                                Stok: {{ $book->stok }}
                            </span>
                        </div>

                        {{-- PUSH BUTTON KE BAWAH --}}
                        <div class="mt-auto pt-3">
                            <a href="/buku/{{ $book->id }}"
                               style="text-decoration:none; color:black; font-weight:600;">
                                Lihat Selengkapnya →
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        </div>
        @empty
        <div class="col-12 text-center text-muted">
            Belum ada buku tersedia
        </div>
        @endforelse

    </div>

    {{-- PAGINATION (WAJIB DI LUAR ROW) --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $books->onEachSide(1)->links() }}
    </div>

</div>

@endsection