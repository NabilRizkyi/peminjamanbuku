<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Borrowing\BorrowingInterface;
use App\Models\Borrowing;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AdminBorrowingController extends Controller
{
    private BorrowingInterface $borrowingService;

    public function __construct(BorrowingInterface $borrowingService)
    {
        $this->borrowingService = $borrowingService;
    }

    // =========================
    // LIST SEMUA PEMINJAMAN
    // =========================
    public function index()
    {
        $borrowings = $this->borrowingService->getAllWithRelations();
        return view('admin.borrowings.index', compact('borrowings'));
    }

    // =========================
    // APPROVE + BUAT TOKEN
    // =========================
    public function approve(string $id)
    {
        try {
            $result = $this->borrowingService->approveBorrowing($id);
            $token = $result['token'];
            return back()->with('success', "Peminjaman disetujui. Token: {$token} (berlaku 24 jam).");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // =========================
    // VALIDASI TOKEN
    // =========================
    public function validasiToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);

        try {
            $result = $this->borrowingService->validateToken($request->token);
            $nama  = $result['nama'];
            $judul = $result['judul'];
            return back()->with('success', "✅ Token valid. Buku \"{$judul}\" boleh diambil oleh {$nama}.");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // =========================
    // RETURN BUKU
    // =========================
    public function return(string $id)
    {
        try {
            $result = $this->borrowingService->returnBorrowing($id);
            $denda = $result['denda'];
            $dendaMsg = $denda > 0 ? " Denda: Rp " . number_format($denda) : '';
            return back()->with('success', 'Buku berhasil dikembalikan.' . $dendaMsg);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // =========================
    // BATAL PEMINJAMAN
    // =========================
    public function cancel(string $id)
    {
        try {
            $this->borrowingService->cancelBorrowing($id);
            return back()->with('success', 'Peminjaman berhasil dibatalkan dan stok dikembalikan.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // =========================
    // LAPORAN
    // =========================
    public function laporan(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $borrowings = Borrowing::with(['user', 'book'])
            ->whereMonth('tanggal_pinjam', $bulan)
            ->whereYear('tanggal_pinjam', $tahun)
            ->latest()
            ->get();

        return view('admin.laporan.index', compact('borrowings', 'bulan', 'tahun'));
    }

    // =========================
    // EXPORT PDF
    // =========================
    public function exportPdf(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $borrowings = Borrowing::with(['user', 'book'])
            ->whereMonth('tanggal_pinjam', $bulan)
            ->whereYear('tanggal_pinjam', $tahun)
            ->get();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('borrowings', 'bulan', 'tahun'));

        return $pdf->download('laporan-peminjaman.pdf');
    }
}
