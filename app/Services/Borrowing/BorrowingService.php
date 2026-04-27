<?php

namespace App\Services\Borrowing;

use App\Models\Borrowing;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BorrowingService implements BorrowingInterface
{
    public function getAllWithRelations()
    {
        return Borrowing::with(['user', 'book'])->latest()->get();
    }

    public function getByUserId(string $userId)
    {
        return Borrowing::with('book')
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function countByStatus(string $status): int
    {
        return Borrowing::where('status', $status)->count();
    }

    public function findById(string $id)
    {
        return Borrowing::findOrFail($id);
    }

    public function createBorrowing(string $userId, string $bookId, int $durasi)
    {
        $book = Book::findOrFail($bookId);

        if ($book->stok <= 0) {
            throw new \Exception('Stok buku sedang habis!');
        }

        // Cek existing
        $existingBorrow = Borrowing::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->exists();

        if ($existingBorrow) {
            throw new \Exception('Anda masih meminjam atau menunggu persetujuan untuk buku ini.');
        }

        $tanggal_pinjam = Carbon::now();
        $tanggal_kembali_rencana = Carbon::now()->addDays($durasi);

        return Borrowing::create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'tanggal_pinjam' => $tanggal_pinjam,
            'tanggal_kembali_rencana' => $tanggal_kembali_rencana,
            'tanggal_kembali' => null,
            'durasi' => $durasi,
            'status' => 'menunggu'
        ]);
    }

    public function approveBorrowing(string $id): array
    {
        $borrowing = $this->findById($id);

        if ($borrowing->status !== 'menunggu') {
            throw new \Exception('Pengajuan ini sudah diproses sebelumnya.');
        }

        $approvedAt = now();
        $tokenExpiredAt = $approvedAt->copy()->addHours(24);
        $token = strtoupper(Str::random(8));

        $borrowing->update([
            'status'            => 'dipinjam',
            'token'             => $token,
            'token_approved_at' => $approvedAt,
            'token_expired_at'  => $tokenExpiredAt,
            'token_used'        => false,
        ]);

        $borrowing->book->decrement('stok');

        return [
            'token' => $token,
            'borrowing' => $borrowing
        ];
    }

    public function validateToken(string $tokenRaw): array
    {
        $borrowing = Borrowing::where('token', strtoupper(trim($tokenRaw)))->first();

        if (! $borrowing) {
            throw new \Exception('❌ Token tidak ditemukan.');
        }

        if ($borrowing->isTokenUsed()) {
            throw new \Exception('❌ Token sudah digunakan sebelumnya dan tidak bisa dipakai lagi.');
        }

        if ($borrowing->isTokenExpired()) {
            $expiredAt = $borrowing->token_expired_at->format('d M Y H:i');
            throw new \Exception("❌ Token sudah expired sejak {$expiredAt}.");
        }

        $borrowing->update([
            'token_used' => true,
        ]);

        return [
            'nama' => $borrowing->user->name ?? '-',
            'judul' => $borrowing->book->judul ?? '-'
        ];
    }

    public function returnBorrowing(string $id): array
    {
        $borrowing = $this->findById($id);

        if ($borrowing->status === 'dikembalikan') {
            throw new \Exception('Buku ini sudah dikembalikan sebelumnya.');
        }

        $telat = now()->diffInDays($borrowing->tanggal_kembali_rencana, false);
        $denda = $telat > 0 ? (int) ($telat * 1000) : 0;

        $borrowing->update([
            'status'          => 'dikembalikan',
            'tanggal_kembali' => now(),
            'denda'           => $denda,
        ]);

        $borrowing->book->increment('stok');

        return [
            'denda' => $denda,
            'borrowing' => $borrowing
        ];
    }

    public function cancelBorrowing(string $id): void
    {
        $borrowing = $this->findById($id);

        if ($borrowing->status === 'dikembalikan') {
            throw new \Exception('Buku sudah diverifikasi kembali.');
        }

        if ($borrowing->status === 'dipinjam') {
            $borrowing->book->increment('stok');
        }

        $borrowing->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now(),
            'denda' => 0,
        ]);
    }
}
