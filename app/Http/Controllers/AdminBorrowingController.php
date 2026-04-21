<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminBorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book'])->latest()->get();
        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function return($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status === 'dikembalikan') {
            return back()->with('error', 'Sudah dikembalikan');
        }

        // HITUNG TERLAMBAT DARI TANGGAL RENCANA
        $telat = now()->diffInDays($borrowing->tanggal_kembali_rencana, false);

        $denda = 0;
        if ($telat > 0) {
            $denda = $telat * 1000;
        }

        $borrowing->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now(),
            'denda' => $denda
        ]);

        $borrowing->book->increment('stok');

        return back()->with('success', 'Buku dikembalikan');
    }

    public function approve($id)
{
    $borrowing = Borrowing::findOrFail($id);

    $book = $borrowing->book;

     $now = now();

    // ✅ Generate token random
    $token = strtoupper(Str::random(8));

    $borrowing->update([
        'status' => 'dipinjam',
        'token' => $token,
        'token_expired_at' => $now->copy()->addDay(),
        'token_used' => false
    ]);

    $book->decrement('stok');

    return back()->with('success', 'Peminjaman disetujui + token dibuat');
}

public function validasiToken(Request $request)
{
    $request->validate([
        'token' => 'required'
    ]);

    $borrowing = Borrowing::where('token', $request->token)->first();

    if (!$borrowing) {
        return back()->with('error', 'Token tidak ditemukan');
    }

    if ($borrowing->token_used) {
        return back()->with('error', 'Token sudah digunakan');
    }

    if (now()->gt($borrowing->token_expired_at)) {
        return back()->with('error', 'Token sudah expired');
    }

    // ✅ tandai sudah dipakai
    $borrowing->update([
        'token_used' => true
    ]);

    return back()->with('success', 'Token valid, buku boleh diambil');
}

}