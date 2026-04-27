<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BorrowingController extends Controller
{
    // =========================
    // LIST DATA
    // =========================
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $borrowings = Borrowing::with(['user', 'book'])
                ->latest()
                ->paginate(10);

            return view('admin.borrowings.index', compact('borrowings'));
        } else {
            $borrowings = Borrowing::with(['book'])
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(10);

            return view('anggota.riwayat', compact('borrowings'));
        }
    }

    // =========================
    // PINJAM BUKU
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'durasi'  => 'required|integer|min:1|max:30'
        ]);

        $durasi = (int) $request->durasi;
        $book   = Book::findOrFail($request->book_id);

        if ($book->stok <= 0) {
            return back()->with('error', 'Stok buku habis');
        }

        $token   = 'TRX-' . strtoupper(Str::random(8));
        $now     = now();
        $expired = $now->copy()->addDay();

        Borrowing::create([
            'user_id'          => Auth::id(),
            'book_id'          => $request->book_id,
            'tanggal_pinjam'   => $now,
            'tanggal_kembali'  => $now->copy()->addDays($durasi),
            'durasi'           => $durasi,
            'status'           => 'menunggu',
            'denda'            => 0,
            'token'            => $token,
            'token_expired_at' => $expired,
            'token_used'       => false,
        ]);

        $book->decrement('stok');

        return redirect()->route('riwayat')
            ->with('success', 'Pengajuan peminjaman berhasil, menunggu approval admin');
    }

    // =========================
    // KEMBALIKAN BUKU
    // =========================
    public function kembalikan($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan');
        }

        if ($borrowing->status == 'dikembalikan') {
            return back()->with('error', 'Buku sudah dikembalikan');
        }

        $today    = now();
        $dueDate  = Carbon::parse($borrowing->tanggal_kembali);
        $lateDays = $dueDate->diffInDays($today, false);
        $denda    = $lateDays > 0 ? $lateDays * 1000 : 0;

        $borrowing->book->increment('stok');

        $borrowing->update([
            'status' => 'dikembalikan',
            'denda'  => $denda,
        ]);

        return back()->with('success', 'Buku berhasil dikembalikan');
    }

    // =========================
    // APPROVE PEMINJAMAN
    // =========================
    public function approve($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses tidak diizinkan');
        }

        $borrowing = Borrowing::findOrFail($id);
        $book      = $borrowing->book;

        if ($book->stok <= 0) {
            return back()->with('error', 'Stok habis!');
        }

        $token = 'TRX-' . strtoupper(Str::random(8));

        $borrowing->update([
            'status'           => 'approved',
            'token'            => $token,
            'token_expired_at' => now()->addDay(),
            'token_used'       => false,
        ]);

        return back()->with('success', 'Disetujui + token dibuat');
    }
}
