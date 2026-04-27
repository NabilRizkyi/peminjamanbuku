<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User; // 
use Carbon\Carbon;

use App\Services\Borrowing\BorrowingInterface;

class BorrowingController extends Controller
{
    private BorrowingInterface $borrowingService;

    public function __construct(BorrowingInterface $borrowingService)
    {
        $this->borrowingService = $borrowingService;
    }

    public function index()
    {
        $borrowings = $this->borrowingService->getByUserId((string) auth()->id());
        return view('anggota.riwayat', compact('borrowings'));
    }

    public function store(Request $request, string $id)

use App\Models\Borrowing;
use App\Models\Book;
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
        } else {
            $borrowings = Borrowing::with(['book'])
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(10);
        }

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
            'book_id' => 'required|exists:books,id',
            'durasi'  => 'required|integer|min:1|max:30'
        ]);

        try {
            $this->borrowingService->createBorrowing((string) auth()->id(), $id, (int) $request->durasi);
            return redirect()->route('riwayat')->with('success', 'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan admin.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        $durasi = (int) $request->durasi;
        $book   = Book::findOrFail($request->book_id);

        if ($book->stok <= 0) {
            return back()->with('error', 'Stok buku habis');
        }

        $token   = 'TRX-' . strtoupper(Str::random(8));
        $now     = now();
        $expired = $now->copy()->addDay(); // [FIX] Dipakai di token_expired_at

        Borrowing::create([
            'user_id'          => Auth::id(),
            'book_id'          => $request->book_id,
            'tanggal_pinjam'   => $now,
            'tanggal_kembali'  => $now->copy()->addDays($durasi),
            'durasi'           => $durasi,
            'status'           => 'menunggu',
            'denda'            => 0,
            'token'            => $token,
            'token_expired_at' => $expired, // [FIX] Bukan null lagi
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

        // [FIX] Pastikan hanya pemilik yang bisa kembalikan
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

        // Kembalikan stok
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
        // [FIX] Hanya admin yang boleh approve
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
