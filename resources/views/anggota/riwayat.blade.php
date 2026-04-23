@extends('layouts.app')

@section('content')

<div class="container-custom">

    <h4 class="fw-semibold mb-4">Riwayat Peminjaman</h4>

    <div class="card card-custom p-4 shadow-sm">

        <div class="table-responsive">
            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Token</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($borrowings as $item)
                    <tr>

                        {{-- BUKU --}}
                        <td class="d-flex align-items-center gap-3">

                            @if($item->book && $item->book->cover)
                                <img src="{{ asset('storage/'.$item->book->cover) }}"
                                     width="50" height="70"
                                     style="object-fit:cover; border-radius:6px;">
                            @else
                                <div style="width:50px;height:70px;background:#eee;border-radius:6px;"></div>
                            @endif

                            <div>
                                <strong>{{ $item->book->judul ?? 'Buku tidak ditemukan' }}</strong><br>
                                <small class="text-muted">
                                    {{ $item->book->penulis ?? '-' }}
                                </small>
                            </div>

                        </td>

                        {{-- TANGGAL --}}
                        <td>
                            <small>
                                Pinjam: {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}<br>

                                @if($item->tanggal_kembali)
                                    Kembali: {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                                @else
                                    <span class="text-muted">Belum dikembalikan</span>
                                @endif
                            </small>
                        </td>

                        {{-- STATUS (UPDATED) --}}
                        <td>
                            @if($item->status == 'menunggu')
                                <span class="badge bg-warning text-dark">
                                    Menunggu Persetujuan
                                </span>

                            @elseif($item->status == 'dipinjam')
                                <span class="badge bg-primary">
                                    Dipinjam
                                </span>

                            @elseif($item->status == 'dikembalikan')
                                <span class="badge bg-success">
                                    Dikembalikan
                                </span>

                            @else
                                <span class="badge bg-secondary">
                                    -
                                </span>
                            @endif
                        </td>

                        <td>

                        {{-- TOKEN --}}
                    @if($item->token && !$item->token_used)
                <div>
                    <span class="badge bg-warning text-dark">
                        Token: <strong>{{ $item->token }}</strong>
                    </span>
                </div>
                    <div style="margin-top:4px;">
                        <small style="color:#ef4444;">
                        Berlaku sampai:
                        {{ \Carbon\Carbon::parse($item->token_expired_at)->format('d M Y H:i') }}
                        </small>
                    </div>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                    </td>

                        {{-- DENDA --}}
                        <td>
                            @if($item->denda > 0)
                                <span class="text-danger fw-bold">
                                    Rp {{ number_format($item->denda) }}
                                </span>
                            @else
                                <span class="text-success">Gratis</span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td>
                            @if($item->status == 'dipinjam')
                                <form action="{{ route('anggota.kembalikan', $item->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-success">
        Kembalikan
    </button>
</form>

                            @elseif($item->status == 'menunggu')
                                <span class="text-muted">Menunggu approval</span>

                            @else
                                <span class="text-muted">Selesai</span>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Belum ada riwayat peminjaman
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection