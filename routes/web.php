<?php

use Illuminate\Support\Facades\Route;

// Halaman Login
Route::get('/', function () { return view('auth.login'); });

// Halaman User (Tinggal 2 menu)
Route::get('/user/dashboard', function () { return view('user.dashboard', ['role' => 'user']); });
Route::get('/user/peminjaman', function () { return view('user.peminjaman', ['role' => 'user']); });

// Halaman Admin
Route::get('/admin/dashboard', function () { return view('admin.dashboard', ['role' => 'admin']); });
Route::get('/admin/users', function () { return view('admin.users', ['role' => 'admin']); });
Route::get('/admin/buku', function () { return view('admin.buku.index', ['role' => 'admin']); });
Route::get('/admin/buku/tambah', function () { return view('admin.buku.create', ['role' => 'admin']); });