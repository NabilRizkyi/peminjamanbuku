<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    // =========================
    // LIST DATA
    // =========================
    public function index()
    {
        // ✅ AMBIL DATA + PAGINATION
        if (Auth::user()->role == 'admin') {
            $borrowings = Borrowing::with(['user', 'book'])
                ->latest()
                ->paginate(10);
        } else {
            $borrowings = Borrowing::with(['book'])
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(10);
        }

        // ✅ AUTO DENDA (HANYA YANG MASIH DIPINJAM)
        foreach ($borrowings as $item) {

            if ($item->status != 'dipinjam') {
                continue;
            }

            $today = Carbon::today();
            $dueDate = Carbon::parse($item->tanggal_kembali);

            $lateDays = $dueDate->diffInDays($today, false);

            if ($lateDays > 0) {
                $denda = $lateDays * 1000;

                if ($item->denda != $denda) {
                    $item->update([
                        'denda' => $denda
                    ]);
                }
            }
        }

        // ✅ RETURN VIEW (HARUS DI LUAR FOREACH)
        if (Auth::user()->role == 'admin') {
            return view('admin.borrowings.index', compact('borrowings'));
        } else {
            return view('anggota.riwayat', compact('borrowings'));
        }
    }

    // =========================
    // PINJAM BUKU
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'tanggal_pinjam' => Carbon::today(),
            'tanggal_kembali' => Carbon::today()->addDays(3),
            'status' => 'dipinjam',
            'denda' => 0
        ]);

        return redirect()->back()->with('success', 'Buku berhasil dipinjam');
    }

    // =========================
    // KEMBALIKAN BUKU
    // =========================
    public function kembalikan($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        // ❗ JANGAN PROSES LAGI KALAU SUDAH DIKEMBALIKAN
        if ($borrowing->status == 'dikembalikan') {
            return back()->with('error', 'Buku sudah dikembalikan');
        }

        $today = Carbon::today();
        $dueDate = Carbon::parse($borrowing->tanggal_kembali);

        $lateDays = $dueDate->diffInDays($today, false);

        if ($lateDays > 0) {
            $denda = $lateDays * 1000;
        } else {
            $denda = 0;
        }

        $borrowing->update([
            'status' => 'dikembalikan',
            'denda' => $denda
        ]);

        return redirect()->back()->with('success', 'Buku dikembalikan');
    }
}