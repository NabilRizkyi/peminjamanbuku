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

    Route::get('/peminjaman', [BorrowingController::class, 'index'])->name('peminjaman');

    Route::post('/pinjam', [BorrowingController::class, 'store'])->name('pinjam');

    Route::post('/kembalikan/{id}', [BorrowingController::class, 'kembalikan'])
        ->name('kembalikan');

    })->name('dashboard');


    // ================= PROFILE =================
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

        Route::post('/anggota/{id}/approve', [UserController::class, 'approve'])
            ->name('anggota.approve');


        // ================= ANGGOTA MANAGEMENT =================
        Route::get('/admin/anggota', [UserController::class, 'index'])->name('anggota.index');
        Route::get('/admin/anggota/create', [UserController::class, 'create'])->name('anggota.create');
        Route::post('/admin/anggota/store', [UserController::class, 'store'])->name('anggota.store');
        Route::delete('/admin/anggota/{id}', [UserController::class, 'destroy'])->name('anggota.destroy');

        Route::get('/admin/anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
        Route::put('/admin/anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');


        // ================= LAPORAN =================
        Route::get('/admin/laporan', [LaporanController::class, 'index'])
            ->name('admin.laporan');

        Route::get('/admin/laporan/pdf', [LaporanController::class, 'exportPdf'])
            ->name('laporan.pdf');
    });


    // ================= ANGGOTA =================
    Route::middleware(['role:anggota'])->group(function () {

        Route::get('/anggota', [BookController::class, 'dashboard'])
            ->name('anggota.dashboard');

        Route::get('/buku/{book}', [BookController::class, 'show'])
            ->name('buku.detail');

        Route::get('/riwayat', [BorrowingController::class, 'index'])
            ->name('riwayat');

        Route::post('/pinjam/{book}', [BorrowingController::class, 'store'])
            ->name('pinjam');

        // ✅ FIX UTAMA
        Route::post('/kembalikan/{id}', [BorrowingController::class, 'kembalikan'])
            ->name('anggota.kembalikan');
    });

});

require __DIR__.'/auth.php';