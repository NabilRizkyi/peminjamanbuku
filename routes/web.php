<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\AdminBorrowingController;
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


    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // ================= ADMIN =================
    Route::middleware(['role:admin'])->group(function () {

        Route::get('/admin/dashboard', [BookController::class, 'adminDashboard'])
        ->name('admin.dashboard');

        Route::resource('books', BookController::class);

        Route::get('/books/{book}/detail', [BookController::class, 'show'])
            ->name('books.detail');

        Route::get('/peminjaman', [AdminBorrowingController::class, 'index'])
            ->name('admin.borrowings');

        Route::get('/peminjam/{user}', [AdminBorrowingController::class, 'showUser'])
            ->name('admin.user.show');

        Route::post('/peminjaman/{borrowing}/return', [AdminBorrowingController::class, 'return'])
            ->name('admin.return');

        Route::post('/peminjaman/{id}/approve', [AdminBorrowingController::class, 'approve'])
            ->name('admin.approve');

        Route::post('/validasi-token', [AdminBorrowingController::class, 'validasiToken'])
            ->name('admin.validasi.token');
    });


    // ================= SISWA =================
    Route::middleware(['role:anggota'])->group(function () {

        Route::get('/anggota', [BookController::class, 'dashboard'])
            ->name('anggota.dashboard');

        Route::get('/buku/{book}', [BookController::class, 'show'])
            ->name('buku.detail');

        Route::get('/riwayat', [BorrowingController::class, 'index'])
            ->name('riwayat');

        Route::post('/pinjam/{book}', [BorrowingController::class, 'store'])
            ->name('pinjam');

        Route::post('/kembalikan/{borrowing}', [BorrowingController::class, 'return'])
            ->name('kembalikan');
    });

});

require __DIR__.'/auth.php';