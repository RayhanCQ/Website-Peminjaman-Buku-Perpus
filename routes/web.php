<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\UserLibraryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserLibraryController::class, 'dashboard'])->name('dashboard');
    Route::get('/peminjaman', [UserLibraryController::class, 'peminjaman'])->name('peminjaman');
    Route::post('/peminjaman', [UserLibraryController::class, 'storePeminjaman'])->name('peminjaman.store');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/pengembalian', [AdminController::class, 'pengembalian'])->name('pengembalian');
    Route::post('/pengembalian', [AdminController::class, 'storePengembalian'])->name('pengembalian.store');
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/tambah', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
});
