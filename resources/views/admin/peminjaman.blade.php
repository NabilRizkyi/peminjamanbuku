@extends('layouts.app')
@section('page-title', 'Data Peminjaman')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Data Peminjaman</h1>
        <p class="page-subtitle">Pantau semua aktivitas peminjaman buku</p>
    </div>
</div>

{{-- ALERT SUCCESS --}}
@if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
@endif

{{-- TABLE CARD --}}
<div class="card">
    <div class="card-body" style="padding:0;">

        <div style="padding: 20px 24px 16px; border-bottom: 1px solid #f1f5f9;">
            <div style="font-size:15px; font-weight:600; color:#0f172a;">
                <i class="bi bi-clipboard2-data-fill me-2" style="color:#2563eb;"></i>
                Daftar Peminjaman Buku
            </div>
        </div>

        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Nama Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Tgl. Pinjam</th>
                        <th>Tgl. Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $b)
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:32px; height:32px; background: linear-gradient(135deg,#2563eb,#7c3aed); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:white; flex-shrink:0;">
                                    {{ strtoupper(substr($b->user->name, 0, 1)) }}
                                </div>
                                <span style="font-weight:600;">{{ $b->user->name }}</span>
                            </div>
                        </td>
                        <td style="color:#64748b;">{{ $b->book->judul }}</td>
                        <td style="color:#64748b;">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ \Carbon\Carbon::parse($b->tanggal_pinjam)->format('d M Y') }}
                        </td>
                        <td style="color:#64748b;">
                            @if($b->tanggal_kembali)
                                <i class="bi bi-calendar-check me-1"></i>
                                {{ \Carbon\Carbon::parse($b->tanggal_kembali)->format('d M Y') }}
                            @else
                                <span style="color:#94a3b8;">–</span>
                            @endif
                        </td>
                        <td>
                            @if($b->status == 'dipinjam')
                                <span class="badge" style="background:#fefce8; color:#ca8a04;">
                                    <i class="bi bi-arrow-up-circle me-1"></i>Dipinjam
                                </span>
                            @else
                                <span class="badge" style="background:#ecfdf5; color:#065f46;">
                                    <i class="bi bi-check-circle me-1"></i>Dikembalikan
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($b->denda > 0)
                                <span style="font-weight:700; color:#ef4444;">
                                    Rp {{ number_format($b->denda) }}
                                </span>
                            @else
                                <span style="color:#10b981; font-weight:500;">Gratis</span>
                            @endif
                        </td>
                        <td>
                            @if($b->status == 'dipinjam')
                                <form action="{{ route('admin.return', $b->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm"
                                            onclick="return confirm('Konfirmasi pengembalian buku ini?')"
                                            style="border-radius:6px; font-size:12px; font-weight:600; padding:5px 12px;">
                                        <i class="bi bi-arrow-return-left me-1"></i>Kembalikan
                                    </button>
                                </form>
                            @else
                                <span style="color:#94a3b8; font-size:13px;">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center" style="padding:40px; color:#94a3b8;">
                            <i class="bi bi-inbox" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                            Belum ada data peminjaman
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
