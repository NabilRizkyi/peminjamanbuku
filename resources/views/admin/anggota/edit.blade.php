@extends('layouts.app')

@section('page-title', 'Edit Anggota')

@section('content')

<div class="page-header">
    <h1 class="page-title">Edit Anggota</h1>
</div>

<div class="card mt-3">
    <div class="card-body">

        <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" 
                       class="form-control"
                       value="{{ $anggota->name }}" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" 
                       class="form-control"
                       value="{{ $anggota->email }}" required>
            </div>

            <div class="mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" 
                       class="form-control"
                       value="{{ $anggota->no_hp }}" required>
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" required>{{ $anggota->alamat }}</textarea>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Kembali</a>

        </form>

    </div>
</div>

@endsection