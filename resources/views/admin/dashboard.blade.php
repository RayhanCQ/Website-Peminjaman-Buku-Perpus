@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-indigo-500">
        <h3 class="text-gray-500 text-sm font-bold uppercase">Total Judul Buku</h3>
        <p class="text-3xl font-extrabold text-indigo-600 mt-2">458</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-orange-500">
        <h3 class="text-gray-500 text-sm font-bold uppercase">Buku Dipinjam</h3>
        <p class="text-3xl font-extrabold text-orange-500 mt-2">45</p>
    </div>
</div>
<div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
    <h3 class="font-bold text-blue-800 text-lg">Semangat Bertugas Admin! 🛠️</h3>
    <p class="text-blue-600 mt-1">Gunakan menu di samping untuk mengelola buku dan memantau peminjaman.</p>
</div>
@endsection