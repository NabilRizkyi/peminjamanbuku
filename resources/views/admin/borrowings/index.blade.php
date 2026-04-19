@extends('layouts.app')
@section('page-title', 'Data Peminjaman')

@section('content')

{{-- HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Data Peminjaman</h1>
        <p class="page-subtitle">Pantau dan kelola semua aktivitas peminjaman buku</p>
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
                <i class="bi bi-clipboard2-data-fill me-2" style="color:#2563eb;"></i>
                Semua Data Peminjaman
            </div>
        </div>

        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Tgl. Pinjam</th>
                        <th>Tgl. Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $item)
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:32px; height:32px; background: linear-gradient(135deg,#2563eb,#7c3aed); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:white; flex-shrink:0;">
                                    {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                </div>
                                <span style="font-weight:600;">{{ $item->user->name }}</span>
                            </div>
                        </td>

                        <td style="color:#64748b;">{{ $item->book->judul }}</td>

                        <td style="color:#64748b; font-size:13px;">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $item->tanggal_pinjam->format('d M Y') }}
                        </td>

                        <td style="color:#64748b; font-size:13px;">
                            @if($item->tanggal_kembali)
                                <i class="bi bi-calendar-check me-1"></i>
                                {{ $item->tanggal_kembali->format('d M Y') }}
                            @else
                                <span style="color:#94a3b8;">–</span>
                            @endif
                        </td>

                        <td>
                            @if($item->status == 'dipinjam')
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
                            <span style="font-weight:700; color:{{ $item->denda_realtime > 0 ? '#ef4444' : '#10b981' }};">
                                Rp {{ number_format($item->denda_realtime) }}
                            </span>
                        </td>

                        <td>
                            @if($item->status == 'dipinjam')
                                <form action="{{ route('admin.return', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('Konfirmasi pengembalian buku ini?')"
                                            class="btn btn-sm"
                                            style="background:#eff6ff; color:#2563eb; border:none; border-radius:6px; font-size:12px; font-weight:600; padding:5px 12px;">
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
                        <td colspan="7" class="text-center" style="padding:50px; color:#94a3b8;">
                            <i class="bi bi-inbox" style="font-size:36px; display:block; margin-bottom:10px; color:#cbd5e1;"></i>
                            <div style="font-size:16px; font-weight:600; color:#475569;">Belum ada data peminjaman</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection