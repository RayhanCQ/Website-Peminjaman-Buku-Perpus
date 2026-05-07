@extends('layouts.app')
@section('title', 'User Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-indigo-500">
        <h3 class="text-gray-500 text-sm font-bold uppercase">Buku Sedang Dipinjam</h3>
        <p class="text-3xl font-extrabold text-gray-800 mt-2">2</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-orange-500">
        <h3 class="text-gray-500 text-sm font-bold uppercase">Total Riwayat Pinjaman</h3>
        <p class="text-3xl font-extrabold text-gray-800 mt-2">15</p>
    </div>
</div>

<div class="bg-indigo-50 p-6 rounded-xl border border-indigo-100">
    <h3 class="font-bold text-indigo-800 text-lg">Halo, Selamat Datang Kembali! 👋</h3>
    <p class="text-indigo-600 mt-1">Jangan lupa kembalikan buku tepat waktu ya!</p>
</div>
@endsection