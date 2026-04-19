<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;

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
}