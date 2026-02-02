<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriKeuanganController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Dashboard routes
Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('index');
    Route::resource('users', App\Http\Controllers\Dashboard\UserController::class);
});


Route::get('/kategori', [KategoriKeuanganController::class, 'index'])->name('kategori.index');
Route::post('/kategori', [KategoriKeuanganController::class, 'store'])->name('kategori.store');
Route::delete('/kategori/{id}', [KategoriKeuanganController::class, 'destroy'])->name('kategori.destroy');
