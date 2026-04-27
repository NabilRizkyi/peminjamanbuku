<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\AdminBorrowingController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {

        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('anggota.dashboard');

    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:admin'])->group(function () {

        Route::get('/admin/dashboard', [BookController::class, 'adminDashboard'])
            ->name('admin.dashboard');

        Route::resource('books', BookController::class);

        Route::get('/books/{book}/detail', [BookController::class, 'show'])
            ->name('books.detail');

        Route::get('/admin/peminjaman', [AdminBorrowingController::class, 'index'])
            ->name('admin.borrowings');

        Route::get('/peminjam/{user}', [AdminBorrowingController::class, 'showUser'])
            ->name('admin.user.show');

        Route::post('/peminjaman/{id}/approve', [AdminBorrowingController::class, 'approve'])
            ->name('admin.approve');

        Route::post('/peminjaman/{id}/cancel', [AdminBorrowingController::class, 'cancel'])
            ->name('admin.cancel');

        Route::post('/admin/peminjaman/{id}/return', [AdminBorrowingController::class, 'return'])
            ->name('admin.return');

        Route::post('/admin/validasi-token', [AdminBorrowingController::class, 'validasiToken'])
            ->name('admin.validasi.token');
    });

    // ================= ANGGOTA =================
    Route::middleware(['role:anggota'])->group(function () {

        Route::get('/anggota', [BookController::class, 'dashboard'])
            ->name('anggota.dashboard');

        Route::get('/buku/{book}', [BookController::class, 'show'])
            ->name('buku.detail');

        Route::get('/riwayat', [BorrowingController::class, 'index'])
            ->name('riwayat');

        Route::post('/pinjam', [BorrowingController::class, 'store'])
            ->name('pinjam');

        Route::post('/kembalikan/{id}', [BorrowingController::class, 'kembalikan'])
            ->name('anggota.kembalikan');
    });

});

require __DIR__.'/auth.php';