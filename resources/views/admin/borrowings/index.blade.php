@extends('layouts.app')
@section('page-title', 'Data Peminjaman')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Data Peminjaman</h1>
        <p class="page-subtitle">Pantau dan kelola semua aktivitas peminjaman buku</p>
    </div>
</div>

{{-- ALERT --}}
@if(session('success'))
    <div class="alert alert-success mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-body" style="padding:0;">

        {{-- HEADER --}}
        <div style="padding: 20px 24px 16px; border-bottom: 1px solid #f1f5f9;">
            <strong>Semua Data Peminjaman</strong>
        </div>

        {{-- VALIDASI TOKEN --}}
        <form action="{{ route('admin.validasi.token') }}" method="POST" style="padding:20px;">
            @csrf
            <div style="display:flex; gap:10px;">
                <input type="text" name="token" class="form-control" placeholder="Masukkan token..." required>
                <button class="btn btn-primary">Validasi Token</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table mb-0 align-middle">

                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Token</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($borrowings as $item)
                    <tr>

                        {{-- PEMINJAM --}}
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:32px;height:32px;background:#2563eb;color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;">
                                    {{ strtoupper(substr($item->user->name,0,1)) }}
                                </div>

                                <a href="javascript:void(0);"
                                   onclick="openUserModal(
                                       '{{ $item->user->name }}',
                                       '{{ $item->user->email }}',
                                       '{{ $item->user->no_hp }}',
                                       '{{ $item->user->alamat }}',
                                       '{{ $item->user->nomor_anggota }}'
                                   )"
                                   style="font-weight:600; color:#2563eb;">
                                   {{ $item->user->name }}
                                </a>
                            </div>
                        </td>

                        {{-- BUKU --}}
                        <td>{{ $item->book->judul }}</td>

                        {{-- TANGGAL --}}
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>

                        <td>
                            @if($item->tanggal_kembali)
                                {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </td>

                        {{-- TOKEN --}}
                        <td style="min-width:160px;">

                            @if($item->token && !$item->token_used)

                                <div style="font-weight:700; color:#2563eb;">
                                    {{ $item->token }}
                                </div>

                                {{-- EXPIRED --}}
                                @if($item->token_expired_at && $item->token_expired_at->isPast())
                                    <div style="font-size:11px; color:#ef4444;">
                                        ❌ Expired
                                    </div>
                                @else
                                    <div style="font-size:11px; color:#64748b;">
                                        Exp:
                                        {{ $item->token_expired_at->format('d M Y H:i') }}
                                    </div>
                                @endif

                            @elseif($item->token_used)
                                <span style="font-size:12px; color:#10b981; font-weight:600;">
                                    ✔ Digunakan
                                </span>
                            @else
                                -
                            @endif

                        </td>

                        {{-- STATUS --}}
                        <td>
                            @if($item->status == 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($item->status == 'dipinjam')
                                <span class="badge bg-primary">Dipinjam</span>
                            @else
                                <span class="badge bg-success">Dikembalikan</span>
                            @endif
                        </td>

                        {{-- DENDA --}}
                        <td>
                            <span style="color:{{ $item->denda > 0 ? 'red' : 'green' }}">
                                Rp {{ number_format($item->denda) }}
                            </span>
                        </td>

                        {{-- AKSI --}}
                        <td>

                            {{-- APPROVE --}}
                            @if($item->status == 'menunggu')
                                <form action="{{ route('admin.approve', $item->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-success">
                                        Approve
                                    </button>
                                </form>

                            {{-- RETURN --}}
                            @elseif($item->status == 'dipinjam')
                                <form action="{{ route('admin.return', $item->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-primary">
                                        Kembalikan
                                    </button>
                                </form>

                            @else
                                <span class="text-muted">Selesai</span>
                            @endif

                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted p-5">
                            Belum ada data peminjaman
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>
</div>

{{-- MODAL PROFIL --}}
<style>
.custom-modal {
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.5);
    justify-content:center;
    align-items:center;
}
.custom-modal-content {
    background:white;
    padding:20px;
    border-radius:10px;
    width:400px;
}
</style>

<div id="userModal" class="custom-modal">
    <div class="custom-modal-content">
        <h5>Profil Peminjam</h5>

        <p><b>Nama:</b> <span id="u-name"></span></p>
        <p><b>Email:</b> <span id="u-email"></span></p>
        <p><b>No HP:</b> <span id="u-nohp"></span></p>
        <p><b>Alamat:</b> <span id="u-alamat"></span></p>
        <p><b>No Anggota:</b> <span id="u-nomor"></span></p>

        <button onclick="closeUserModal()" class="btn btn-primary btn-sm mt-2">
            Tutup
        </button>
    </div>
</div>

<script>
function openUserModal(name, email, nohp, alamat, nomor) {
    document.getElementById('u-name').innerText = name;
    document.getElementById('u-email').innerText = email;
    document.getElementById('u-nohp').innerText = nohp;
    document.getElementById('u-alamat').innerText = alamat;
    document.getElementById('u-nomor').innerText = nomor;

    document.getElementById('userModal').style.display = "flex";
}

function closeUserModal() {
    document.getElementById('userModal').style.display = "none";
}
</script>

@endsection