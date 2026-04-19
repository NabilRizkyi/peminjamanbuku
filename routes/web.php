<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\AdminBorrowingController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {

    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('siswa.dashboard');

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

        Route::post('/peminjaman/{borrowing}/return', [AdminBorrowingController::class, 'return'])
            ->name('admin.return');
    });


    // ================= SISWA =================
    Route::middleware(['role:siswa'])->group(function () {

        Route::get('/siswa', [BookController::class, 'dashboard'])
            ->name('siswa.dashboard');

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