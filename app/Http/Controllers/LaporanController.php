<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
{
    $tipe = $request->tipe ?? 'bulanan';
    $bulan = $request->bulan ?? now()->month;
    $tahun = $request->tahun ?? now()->year;
    $minggu = $request->minggu ?? 1;

    $query = Borrowing::with(['user', 'book']);

    // ================= BULANAN =================
    if ($tipe == 'bulanan') {

        $query->whereMonth('tanggal_pinjam', $bulan)
              ->whereYear('tanggal_pinjam', $tahun);
    }

    // ================= MINGGUAN =================
    else if ($tipe == 'mingguan') {

        $startOfMonth = Carbon::create($tahun, $bulan, 1);

        $startDate = $startOfMonth->copy()
            ->addWeeks($minggu - 1)
            ->startOfWeek(Carbon::MONDAY);

        $endDate = $startDate->copy()
            ->endOfWeek(Carbon::SUNDAY);

        $query->whereBetween('tanggal_pinjam', [$startDate, $endDate]);
    }

    $data = $query->latest()->get();

    $totalPeminjaman = $data->count();
    $totalDenda = $data->sum('denda');

    // ✅ PINDAHKAN KE SINI (SEBELUM RETURN)
    $totalBuku = Book::count();

    // kalau role belum pasti, pakai ini dulu biar aman
    $totalAnggota = User::count();
    // kalau sudah fix pakai siswa:
    // $totalAnggota = User::where('role', 'siswa')->count();

    return view('admin.laporan.index', compact(
        'data',
        'tipe',
        'bulan',
        'tahun',
        'minggu',
        'totalPeminjaman',
        'totalDenda',
        'totalBuku',
        'totalAnggota'
    ));

        $totalBuku = Book::count();
        $totalAnggota = User::where('role', 'siswa')->count();
    }

    
    public function exportPdf(Request $request)
{
    $tipe   = $request->tipe ?? 'bulanan';
    $bulan  = (int) ($request->bulan ?? now()->month);
    $tahun  = (int) ($request->tahun ?? now()->year);
    $minggu = (int) ($request->minggu ?? 1);

    // ✅ WAJIB ADA (INI YANG KURANG)
    $query = Borrowing::with(['user', 'book']);

    // ================= FILTER + PERIODE =================
    if ($tipe == 'bulanan') {

        $query->whereMonth('tanggal_pinjam', $bulan)
              ->whereYear('tanggal_pinjam', $tahun);

        $periode = Carbon::create($tahun, $bulan, 1)
            ->translatedFormat('F Y');
    }

    elseif ($tipe == 'mingguan') {

        $start = Carbon::create($tahun, $bulan, 1)
            ->addWeeks($minggu - 1)
            ->startOfWeek();

        $end = (clone $start)->endOfWeek();

        $query->whereBetween('tanggal_pinjam', [$start, $end]);

        $periode = $start->translatedFormat('d F Y') . ' - ' .
                   $end->translatedFormat('d F Y');
    }

    $data = $query->get();

    // ================= SUMMARY =================
    $totalPeminjaman = $data->count();
    $totalDenda      = $data->sum('denda');
    $totalBuku       = Book::count();
    $totalAnggota    = User::where('role', 'anggota')->count();

    // ================= PDF =================
    $pdf = Pdf::loadView('admin.laporan.pdf', [
        'data' => $data,
        'periode' => $periode,
        'totalPeminjaman' => $totalPeminjaman,
        'totalDenda' => $totalDenda,
        'totalBuku' => $totalBuku,
        'totalAnggota' => $totalAnggota,
    ]);

    return $pdf->download('laporan-peminjaman.pdf');
}
}