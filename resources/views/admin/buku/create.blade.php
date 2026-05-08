@extends('layouts.app')
@section('title', 'Tambah Buku Baru')

@section('content')
<div class="max-w-2xl mx-auto mt-6">
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
        <div class="mb-8 border-b border-gray-100 pb-4 flex items-center gap-4">
            <a href="{{ route('admin.buku.index') }}" class="text-gray-400 hover:text-indigo-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="text-2xl font-bold text-gray-800">Tambah Buku Baru</h2>
        </div>

        <form action="{{ route('admin.buku.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Judul Buku</label>
                <input type="text" name="judul" value="{{ old('judul') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all" placeholder="Contoh: Pemrograman Laravel 11">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Penulis</label>
                <input type="text" name="penulis" value="{{ old('penulis') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all" placeholder="Masukkan nama penulis buku...">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Tema / Kategori Buku</label>
                <select name="kategori_buku_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all bg-white">
                    <option value="" disabled {{ old('kategori_buku_id') ? '' : 'selected' }}>Pilih Tema...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('kategori_buku_id') == $category->id)>{{ $category->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" min="1000" max="2100" class="w-full md:w-1/3 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all" placeholder="2026">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Stok Awal</label>
                <input type="number" name="stok_total" value="{{ old('stok_total') }}" min="0" required class="w-full md:w-1/3 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all" placeholder="0">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Sinopsis</label>
                <textarea name="sinopsis" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all" placeholder="Opsional">{{ old('sinopsis') }}</textarea>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.buku.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-green-500 text-white font-bold rounded-lg hover:bg-green-600 shadow-md transition-all flex items-center gap-2">
                    Simpan Buku
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
