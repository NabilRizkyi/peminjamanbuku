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

    // ================= DASHBOARD =================
    Route::get('/dashboard', function () {

        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('anggota.dashboard');

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

        // 🔥 ADMIN PEMINJAMAN
        Route::get('/admin/peminjaman', [AdminBorrowingController::class, 'index'])
            ->name('admin.borrowings');

<<<<<<< HEAD
        Route::get('/peminjam/{user}', [AdminBorrowingController::class, 'showUser'])
            ->name('admin.user.show');

        Route::post('/peminjaman/{borrowing}/return', [AdminBorrowingController::class, 'return'])
            ->name('admin.return');

        Route::post('/peminjaman/{id}/approve', [AdminBorrowingController::class, 'approve'])
            ->name('admin.approve');

        Route::post('/peminjaman/{id}/cancel', [AdminBorrowingController::class, 'cancel'])
            ->name('admin.cancel');

        Route::post('/validasi-token', [AdminBorrowingController::class, 'validasiToken'])
=======
        Route::post('/admin/peminjaman/{id}/approve', [AdminBorrowingController::class, 'approve'])
            ->name('admin.approve');

        Route::post('/admin/peminjaman/{id}/return', [AdminBorrowingController::class, 'return'])
            ->name('admin.return');

        Route::post('/admin/validasi-token', [AdminBorrowingController::class, 'validasiToken'])
>>>>>>> 4cbfe0c1ccd138ae29ba694be9cba2bd5ba3058e
            ->name('admin.validasi.token');
<<<<<<< HEAD
=======


        // ================= APPROVAL USER =================
        Route::post('/admin/anggota/{id}/approve', [UserController::class, 'approve'])
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
>>>>>>> 856d5ac925529bc4eaa6bd5b89b64563fe18f814
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
<<<<<<< HEAD
=======

        Route::post('/kembalikan/{id}', [BorrowingController::class, 'kembalikan'])
            ->name('anggota.kembalikan');
>>>>>>> 4cbfe0c1ccd138ae29ba694be9cba2bd5ba3058e
    });

});

require __DIR__.'/auth.php';