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
                <li class="pt-3 flex flex-col gap-3">
                    <div>
                        <span class="font-semibold text-gray-800">{{ $book->judul }}</span>
                        <div class="text-xs text-gray-500">{{ $book->penulis }} | {{ $book->kategori?->nama ?? '-' }}</div>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-sm bg-green-100 text-green-700 px-2 py-1 rounded font-bold">Stok: {{ $book->stok_tersedia }}</span>
                            @if($book->active_loans_count > 0)
                                <span class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded font-bold">Dipinjam: {{ $book->active_loans_count }}</span>
                            @endif
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <form method="POST" action="{{ route('admin.buku.archive', $book) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Arsipkan buku ini?')" class="text-xs bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-1.5 rounded font-bold transition">
                                    Arsipkan
                                </button>
                            </form>
                            @if($book->active_loans_count > 0)
                                <button disabled class="text-xs bg-gray-100 text-gray-400 px-3 py-1.5 rounded font-bold cursor-not-allowed">
                                    Hapus Permanen
                                </button>
                            @else
                                <form method="POST" action="{{ route('admin.buku.force-delete', $book) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus permanen buku ini? Data buku tidak bisa dikembalikan.')" class="text-xs bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1.5 rounded font-bold transition">
                                        Hapus Permanen
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
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
                <li class="pt-3 flex flex-col gap-3">
                    <div>
                        <span class="font-semibold text-gray-800">{{ $book->judul }}</span>
                        <div class="text-xs text-gray-500">{{ $book->penulis }} | {{ $book->kategori?->nama ?? '-' }}</div>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-sm bg-red-100 text-red-700 px-2 py-1 rounded font-bold">Habis</span>
                            @if($book->active_loans_count > 0)
                                <span class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded font-bold">Dipinjam: {{ $book->active_loans_count }}</span>
                            @endif
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <form method="POST" action="{{ route('admin.buku.archive', $book) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Arsipkan buku ini?')" class="text-xs bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-1.5 rounded font-bold transition">
                                    Arsipkan
                                </button>
                            </form>
                            @if($book->active_loans_count > 0)
                                <button disabled class="text-xs bg-gray-100 text-gray-400 px-3 py-1.5 rounded font-bold cursor-not-allowed">
                                    Hapus Permanen
                                </button>
                            @else
                                <form method="POST" action="{{ route('admin.buku.force-delete', $book) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus permanen buku ini? Data buku tidak bisa dikembalikan.')" class="text-xs bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1.5 rounded font-bold transition">
                                        Hapus Permanen
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </li>
            @empty
                <li class="pt-2 text-sm text-gray-500">Tidak ada buku kosong.</li>
            @endforelse
        </ul>
    </div>
</div>

<div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="font-bold text-gray-700 text-lg mb-4 flex items-center gap-2">Arsip Buku</h3>
    <ul class="space-y-3 divide-y divide-gray-100">
        @forelse($archivedBooks as $book)
            <li class="pt-3 flex flex-col gap-3">
                <div>
                    <span class="font-semibold text-gray-800">{{ $book->judul }}</span>
                    <div class="text-xs text-gray-500">
                        {{ $book->penulis }} | {{ $book->kategori?->nama ?? '-' }} | Diarsipkan {{ $book->deleted_at?->format('d M Y H:i') ?? '-' }}
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-sm bg-gray-100 text-gray-700 px-2 py-1 rounded font-bold">Tersimpan di arsip</span>
                        @if($book->active_loans_count > 0)
                            <span class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded font-bold">Dipinjam: {{ $book->active_loans_count }}</span>
                        @endif
                    </div>
                    @if($book->active_loans_count > 0)
                        <button disabled class="text-xs bg-gray-100 text-gray-400 px-3 py-1.5 rounded font-bold cursor-not-allowed">
                            Hapus Permanen
                        </button>
                    @else
                        <form method="POST" action="{{ route('admin.buku.force-delete', $book->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus permanen buku arsip ini? Data buku tidak bisa dikembalikan.')" class="text-xs bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1.5 rounded font-bold transition">
                                Hapus Permanen
                            </button>
                        </form>
                    @endif
                </div>
            </li>
        @empty
            <li class="pt-2 text-sm text-gray-500">Belum ada buku yang diarsipkan.</li>
        @endforelse
    </ul>
</div>
@endsection
