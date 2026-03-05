<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Dashboard\KategoriKeuanganController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\AkunKeuanganController;
use App\Http\Controllers\Dashboard\TransaksiController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ==============================
// DASHBOARD ROUTES (GROUPED)
// ==============================
Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {
    
    // 1️⃣ Dashboard utama (bisa diakses admin & member)
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    
    // 2️⃣ Manajemen User — hanya admin
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::get('users/{id}/history', [UserController::class, 'history'])->name('users.history');
    });

    // 3️⃣ Kategori & Akun — bisa diakses admin & member
    Route::resource('kategori', KategoriKeuanganController::class);
    Route::resource('akun', AkunKeuanganController::class);

    // 4️⃣ Transaksi — admin & member bisa CRUD sendiri
    Route::middleware(['role:admin,member'])->group(function () {
        // 📄 Lihat semua transaksi milik user login
        Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');

        // ➕ Tambah transaksi (store)
        Route::post('transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');

        // ✏️ Edit transaksi (hanya milik sendiri)
        Route::put('transaksi/{transaksi}', [TransaksiController::class, 'update'])->name('transaksi.update');

        // 🗑️ Hapus transaksi (hanya milik sendiri)
        Route::delete('transaksi/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

        // 🔹 Ekspor transaksi ke PDF & Excel (admin & member)
        Route::get('transaksi/export/pdf', [TransaksiController::class, 'exportPdf'])
            ->name('transaksi.export.pdf');

        Route::get('transaksi/export/excel', [TransaksiController::class, 'exportExcel'])
            ->name('transaksi.export.excel');
    });
});