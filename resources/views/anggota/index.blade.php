@extends('layouts.app')

@section('content')

<div class="container-custom">

    <h4 class="fw-semibold mb-4">Riwayat Peminjaman</h4>

    <div class="card card-custom p-4">

        <div class="table-responsive">
            <table class="table align-middle">

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
                            <strong>{{ $item->book->judul }}</strong><br>
                            <small class="text-muted">{{ $item->book->penulis }}</small>
                        </td>

                        <td>
                            @if($item->status == 'returned')
                                <span class="badge bg-success">Returned</span>
                            @else
                                <span class="badge bg-warning text-dark">Borrowed</span>
                            @endif
                        </td>

                        <td>
                            {{ $item->denda ?? '-' }}
                        </td>

                        <td>
                            @if($item->status == 'borrowed')
                                <form action="/kembalikan/{{ $item->id }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success btn-sm">
                                        Kembalikan
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
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