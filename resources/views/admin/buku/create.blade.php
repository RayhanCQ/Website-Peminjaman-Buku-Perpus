@extends('layouts.app')
@section('title', 'Tambah Buku Baru')

@section('content')
<div class="max-w-2xl mx-auto mt-6">
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
        <div class="mb-8 border-b border-gray-100 pb-4 flex items-center gap-4">
            <a href="/admin/buku" class="text-gray-400 hover:text-indigo-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="text-2xl font-bold text-gray-800">Tambah Buku Baru</h2>
        </div>

        <form action="#" method="GET" onsubmit="event.preventDefault(); alert('Data Buku Berhasil Disimpan!'); window.location.href='/admin/buku';" class="space-y-6">
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Judul Buku</label>
                <input type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all" placeholder="Contoh: Pemrograman Laravel 11">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Penulis</label>
                <input type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all" placeholder="Masukkan nama penulis buku...">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Tema / Kategori Buku</label>
                <select required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all bg-white">
                    <option value="" disabled selected>Pilih Tema...</option>
                    <option value="Fiksi">Fiksi / Novel</option>
                    <option value="Pendidikan">Pendidikan / Akademik</option>
                    <option value="Teknologi">Teknologi / Sains</option>
                    <option value="Sejarah">Sejarah</option>
                    <option value="Pengembangan Diri">Pengembangan Diri</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Stok Awal</label>
                <input type="number" min="1" required class="w-full md:w-1/3 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all" placeholder="0">
            </div>
            
            <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                <a href="/admin/buku" class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-green-500 text-white font-bold rounded-lg hover:bg-green-600 shadow-md transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Buku
                </button>
            </div>
        </form>
    </div>
</div>
@endsection