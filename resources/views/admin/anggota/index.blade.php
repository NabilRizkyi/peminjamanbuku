@extends('layouts.app')
@section('page-title', 'Kelola Anggota')

@section('content')

<div class="page-header">
    <h1 class="page-title">Kelola Anggota</h1>
    <a href="{{ route('anggota.create') }}" 
           class="btn btn-primary" 
           style="border-radius:10px; font-size:13px;">
            <i class="bi bi-person-plus me-1"></i> Anggota
        </a>
</div>

<form method="GET" action="" class="mb-4 d-flex gap-2">
        
        <input type="text" name="search"
               value="{{ request('search') }}"
               class="form-control"
               placeholder="Cari nama, email, atau no HP...">

        <button class="btn btn-primary">
            🔍
        </button>

        <a href="{{ url('/admin/anggota') }}" class="btn btn-secondary">
            Reset
        </a>
</form>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card mt-3">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Foto Profil</th>
                    <th>Nomor Anggota</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
@forelse($users as $user)
<tr>
    <td>
        @if($user->photo)
            <img src="{{ asset('storage/' . $user->photo) }}" 
                 width="50" height="50"
                 style="object-fit:cover; border-radius:50%;">
        @else
            <img src="https://ui-avatars.com/api/?name={{ $user->name }}" 
                 width="50" height="50"
                 style="border-radius:50%;">
        @endif
    </td>

    <td>{{ $user->nomor_anggota }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->no_hp }}</td>
    <td>{{ $user->alamat }}</td>

    <!-- STATUS -->
    <td>
        @if($user->status == 'approved')
            <span class="badge bg-success">Aktif</span>
        @else
            <span class="badge bg-warning">Pending</span>
        @endif
    </td>

    <!-- AKSI -->
    <td>
        <div class="d-flex align-items-center gap-2">
        <!-- APPROVE (hanya jika pending) -->
        @if($user->status != 'approved')
        <form action="{{ route('anggota.approve', $user->id) }}" method="POST">
            @csrf
            <button class="btn btn-success btn-sm">Approve</button>
        </form>
        @endif

        <!-- EDIT -->
        <a href="{{ route('anggota.edit', $user->id) }}" 
           class="btn btn-warning btn-sm">
            Edit
        </a>

        <!-- DELETE -->
        <form action="{{ route('anggota.destroy', $user->id) }}" 
              method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm"
                onclick="return confirm('Yakin mau hapus anggota ini?')">
                Hapus
            </button>
        </form>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center">Belum ada anggota</td>
</tr>
@endforelse
</tbody>

        </table>

    </div>
</div>

@endsection