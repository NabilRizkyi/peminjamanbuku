@extends('layouts.app')
@section('page-title', 'Riwayat Peminjaman')

@section('content')

{{-- HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Riwayat Peminjaman</h1>
        <p class="page-subtitle">Daftar buku yang sedang atau pernah kamu pinjam</p>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="card">
    <div class="card-body" style="padding:0;">

        <div style="padding: 20px 24px 16px; border-bottom: 1px solid #f1f5f9;">
            <div style="font-size:15px; font-weight:600; color:#0f172a;">
                <i class="bi bi-clock-history me-2" style="color:#2563eb;"></i>
                Data Peminjaman
            </div>
        </div>

        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $item)
                    <tr>
                        <td>
                            <div style="font-weight:700; color:#0f172a;">{{ $item->book->judul }}</div>
                            <div style="font-size:12px; color:#64748b; margin-top:2px;">{{ $item->book->penulis }}</div>
                        </td>

                        <td>
                            @if($item->status == 'returned')
                                <span class="badge" style="background:#ecfdf5; color:#065f46;">
                                    <i class="bi bi-check-circle me-1"></i>Dikembalikan
                                </span>
                            @else
                                <span class="badge" style="background:#fefce8; color:#ca8a04;">
                                    <i class="bi bi-arrow-up-circle me-1"></i>Dipinjam
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($item->denda)
                                <span style="font-weight:700; color:#ef4444;">
                                    Rp {{ number_format($item->denda) }}
                                </span>
                            @else
                                <span style="color:#10b981; font-weight:500;">Gratis</span>
                            @endif
                        </td>

                        <td>
                            @if($item->status == 'borrowed')
                                <form action="/kembalikan/{{ $item->id }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin mengembalikan buku ini?')">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-sm"
                                            style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; border-radius:6px; font-size:12px; font-weight:600; padding:5px 12px;">
                                        <i class="bi bi-arrow-return-left me-1"></i>Kembalikan
                                    </button>
                                </form>
                            @else
                                <span style="color:#94a3b8; font-size:13px;">–</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center" style="padding:50px; color:#94a3b8;">
                            <i class="bi bi-journal-x" style="font-size:36px; display:block; margin-bottom:10px; color:#cbd5e1;"></i>
                            <div style="font-size:15px; font-weight:600; color:#475569;">Belum ada riwayat peminjaman</div>
                            <div style="font-size:13px; margin-top:4px;">
                                <a href="{{ route('siswa.dashboard') }}" style="color:#2563eb; font-weight:500; text-decoration:none;">
                                    Jelajahi katalog buku →
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection