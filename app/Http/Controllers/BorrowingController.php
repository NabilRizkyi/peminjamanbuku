<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User; // ✅ HARUS DI SINI
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with('book')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('anggota.riwayat', compact('borrowings'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'durasi' => 'required|integer|min:1|max:30'
        ]);

        $book = Book::findOrFail($id);

        if ($book->stok <= 0) {
            return back()->with('error', 'Stok habis!');
        }

        $durasi = (int) $request->durasi;

        $tanggal_pinjam = Carbon::now();
        $tanggal_kembali = Carbon::now()->addDays($durasi);

        Borrowing::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'tanggal_pinjam' => $tanggal_pinjam,
            'tanggal_kembali' => $tanggal_kembali,
            'durasi' => $durasi,
            'status' => 'menunggu'
        ]);

        return back()->with('success', 'Buku berhasil dipinjam!');
    }

    public function return($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status === 'dikembalikan') {
            return back()->with('error', 'Sudah dikembalikan');
        }

        $hari = now()->diffInDays($borrowing->tanggal_pinjam);

        $denda = 0;
        if ($hari > 3) {
            $denda = ($hari - 3) * 1000;
        }

        $borrowing->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now(),
            'denda' => $denda
        ]);

        $borrowing->book->increment('stok');

        return back()->with('success', 'Buku berhasil dikembalikan');
    }

}