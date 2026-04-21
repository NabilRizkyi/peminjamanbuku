@extends('layouts.app')

@section('content')

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
        <div class="alert alert-warning">
            Buku tidak ditemukan
        </div>
    @endif

    {{-- LIST BUKU --}}
    <div class="row">

        @forelse($filteredBooks as $book)
        <div class="col-lg-4 col-md-6 mb-3">

            <div class="card card-custom p-3 h-100 shadow-sm">

                <div class="d-flex gap-3">

                    {{-- COVER --}}
                    @if($book->cover)
                        <img src="{{ asset('storage/'.$book->cover) }}"
                             width="70" height="100"
                             style="object-fit:cover; border-radius:8px;">
                    @else
                        <div style="width:70px;height:100px;background:#eee;border-radius:8px;"></div>
                    @endif

                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-semibold">{{ $book->judul }}</h6>
                        <small class="text-muted">{{ $book->penulis }}</small>

                        <div class="mt-2">

                            <div class="mt-2">

    <a href="/buku/{{ $book->id }}" 
       class="text-black hover:text-gray-700 transition"
       style="color:black; text-decoration:none;">

        Lihat Selengkapnya →
    </a>

</div>

                        </div>
                    </div>

                    <span class="badge bg-info text-dark align-self-start">
                        Stok: {{ $book->stok }}
                    </span>

                </div>

            </div>

        </div>
        @empty
        <div class="col-12 text-center text-muted">
            Belum ada buku tersedia
        </div>
        @endforelse

    </div>

</div>

@endsection