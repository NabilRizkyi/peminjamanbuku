@extends('layouts.app')
@section('page-title', 'Laporan')

@section('content')

<div class="container-fluid">
<div class="card shadow-sm">
<div class="card-body">

    <div class="mb-3">
    <h4 class="fw-bold">Laporan Peminjaman</h4>
    <small class="text-muted">
        Data periode {{ \Carbon\Carbon::create()->month((int)($bulan ?? now()->month))->translatedFormat('F') }}
    </small>
</div>

    <!-- ================= FILTER ================= -->
    <form method="GET" class="mb-4">
        <div class="row g-3">

            <!-- TIPE -->
            <div class="col-md-3">
                <label class="form-label">Tipe</label>
                <select name="tipe" id="tipeLaporan" class="form-select">
                    <option value="bulanan" {{ ($tipe ?? 'bulanan') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                    <option value="mingguan" {{ ($tipe ?? '') == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                </select>
            </div>

            <!-- BULAN -->
            <div class="col-md-3">
                <label class="form-label">Bulan</label>
                <select name="bulan" class="form-select">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ ($bulan ?? now()->month) == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- TAHUN -->
            <div class="col-md-3">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select">
                    @for ($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ ($tahun ?? now()->year) == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- MINGGU -->
            <div class="col-md-3" id="fieldMinggu">
                <label class="form-label">Minggu</label>
                <select name="minggu" class="form-select">
                    @for ($m = 1; $m <= 4; $m++)
                        <option value="{{ $m }}" {{ ($minggu ?? 1) == $m ? 'selected' : '' }}>
                            Minggu ke-{{ $m }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- BUTTON -->
            <div class="col-md-12 d-flex gap-2">
                <button class="btn btn-primary">
                    🔍 Filter
                </button>

                <a href="{{ route('laporan.pdf', request()->all()) }}" class="btn btn-danger">
                    Export PDF
                </a>
            </div>

        </div>
    </form>

    <!-- ================= SUMMARY ================= -->
   <div class="row mb-4">

    <!-- TOTAL PEMINJAMAN -->
    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h6>Total Peminjaman</h6>
            <h3>{{ $totalPeminjaman ?? 0 }}</h3>
        </div>
    </div>

    <!-- TOTAL DENDA -->
    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h6>Total Denda</h6>
            <h3>Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}</h3>
        </div>
    </div>

    <!-- TOTAL BUKU -->
    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h6>Total Buku</h6>
            <h3>{{ $totalBuku ?? 0 }}</h3>
        </div>
    </div>

    <!-- TOTAL ANGGOTA -->
    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h6>Total Anggota</h6>
            <h3>{{ $totalAnggota ?? 0 }}</h3>
        </div>
    </div>

</div>

    <!-- ================= TABLE ================= -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Buku</th>
                    <th>Tanggal</th>
                    <th>Durasi</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->book->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}</td>
                    <td>{{ $item->durasi }} hari</td>
                    <td>
                        <span class="badge bg-{{ $item->status == 'dipinjam' ? 'warning' : 'success' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
</div>
</div>

<!-- ================= SCRIPT ================= -->
<script>
    const tipe = document.getElementById('tipeLaporan');
    const fieldMinggu = document.getElementById('fieldMinggu');

    function toggleMinggu() {
        if (tipe.value === 'mingguan') {
            fieldMinggu.style.display = 'block';
        } else {
            fieldMinggu.style.display = 'none';
        }
    }

    toggleMinggu();
    tipe.addEventListener('change', toggleMinggu);
</script>

@endsection