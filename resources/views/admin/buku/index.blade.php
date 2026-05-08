@extends('layouts.app')
@section('title', 'Manajemen Buku')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
    <p class="text-gray-500 font-medium">List ketersediaan seluruh buku perpustakaan.</p>
    <a href="{{ route('admin.buku.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition flex items-center gap-2">
        <span>+</span> Tambah Buku
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-green-200 p-6">
        <h3 class="font-bold text-green-600 text-lg mb-4 flex items-center gap-2">List Buku Tersedia</h3>
        <ul class="space-y-3 divide-y divide-gray-100">
            @forelse($availableBooks as $book)
                <li class="pt-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <span class="font-semibold text-gray-800">{{ $book->judul }}</span>
                        <div class="text-xs text-gray-500">{{ $book->penulis }} | {{ $book->kategori?->nama ?? '-' }}</div>
                    </div>
                    <span class="text-sm bg-green-100 text-green-700 px-2 py-1 rounded font-bold">Stok: {{ $book->stok_tersedia }}</span>
                </li>
            @empty
                <li class="pt-2 text-sm text-gray-500">Belum ada buku tersedia.</li>
            @endforelse
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6">
        <h3 class="font-bold text-red-500 text-lg mb-4 flex items-center gap-2">List Buku Kosong</h3>
        <ul class="space-y-3 divide-y divide-gray-100">
            @forelse($emptyBooks as $book)
                <li class="pt-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <span class="font-semibold text-gray-800">{{ $book->judul }}</span>
                        <div class="text-xs text-gray-500">{{ $book->penulis }} | {{ $book->kategori?->nama ?? '-' }}</div>
                    </div>
                    <span class="text-sm bg-red-100 text-red-700 px-2 py-1 rounded font-bold">Habis</span>
                </li>
            @empty
                <li class="pt-2 text-sm text-gray-500">Tidak ada buku kosong.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
