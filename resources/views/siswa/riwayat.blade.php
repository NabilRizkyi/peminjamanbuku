@extends('layouts.app')
@section('page-title', 'Riwayat Peminjaman')

@section('content')

{{-- HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Riwayat Peminjaman</h1>
        <p class="page-subtitle">Daftar semua buku yang pernah kamu pinjam</p>
    </div>
</div>

{{-- ALERT --}}
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
                <i class="bi bi-clock-history me-2" style="color:#2563eb;"></i>
                Riwayat Peminjaman Buku
            </div>
        </div>

        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $item)
                    <tr>

                        {{-- BUKU --}}
                        <td>
                            <div style="display:flex; align-items:center; gap:12px;">
                                @if($item->book && $item->book->cover)
                                    <img src="{{ asset('storage/'.$item->book->cover) }}"
                                         style="width:44px; height:62px; object-fit:cover; border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.1); flex-shrink:0;">
                                @else
                                    <div style="width:44px; height:62px; background:linear-gradient(135deg,#e0e7ff,#ddd6fe); border-radius:6px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                        <i class="bi bi-book" style="font-size:18px; color:#6366f1;"></i>
                                    </div>
                                @endif
                                <div>
                                    <div style="font-weight:700; color:#0f172a; font-size:14px;">
                                        {{ $item->book->judul ?? 'Buku tidak ditemukan' }}
                                    </div>
                                    <div style="font-size:12px; color:#64748b; margin-top:2px;">
                                        {{ $item->book->penulis ?? '–' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- TANGGAL --}}
                        <td>
                            <div style="font-size:13px;">
                                <div style="color:#64748b;">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    Pinjam: <strong>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</strong>
                                </div>
                                <div style="color:#94a3b8; margin-top:4px; font-size:12px;">
                                    @if($item->tanggal_kembali)
                                        <i class="bi bi-calendar-check me-1"></i>
                                        Kembali: {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                                    @else
                                        <span style="color:#f59e0b;">
                                            <i class="bi bi-clock me-1"></i>Belum dikembalikan
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- STATUS --}}
                        <td>
                            @if($item->status == 'dikembalikan')
                                <span class="badge" style="background:#ecfdf5; color:#065f46;">
                                    <i class="bi bi-check-circle me-1"></i>Dikembalikan
                                </span>
                            @else
                                <span class="badge" style="background:#fefce8; color:#ca8a04;">
                                    <i class="bi bi-arrow-up-circle me-1"></i>Dipinjam
                                </span>
                            @endif
                        </td>

                        {{-- DENDA --}}
                        <td>
                            @if($item->denda > 0)
                                <span style="font-weight:700; color:#ef4444;">
                                    Rp {{ number_format($item->denda) }}
                                </span>
                            @else
                                <span style="color:#10b981; font-weight:500;">
                                    <i class="bi bi-check me-1"></i>Gratis
                                </span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td>
                            @if($item->status == 'dipinjam')
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
                        <td colspan="5" class="text-center" style="padding:50px; color:#94a3b8;">
                            <i class="bi bi-journal-x" style="font-size:36px; display:block; margin-bottom:10px; color:#cbd5e1;"></i>
                            <div style="font-size:16px; font-weight:600; color:#475569;">Belum ada riwayat peminjaman</div>
                            <div style="font-size:13px; margin-top:4px;">
                                Yuk,
                                <a href="{{ route('siswa.dashboard') }}" style="color:#2563eb; font-weight:500; text-decoration:none;">
                                    pinjam buku sekarang!
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