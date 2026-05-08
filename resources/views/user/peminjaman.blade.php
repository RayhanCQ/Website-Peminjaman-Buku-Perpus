@extends('layouts.app')
@section('title', 'Peminjaman Buku')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 border-b border-gray-200 pb-4">
    <p class="text-gray-500 font-bold text-lg">Pilih buku yang ingin kamu pinjam.</p>
    <form method="GET" action="{{ route('user.peminjaman') }}" class="relative w-full md:w-80">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul atau penulis..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm transition-all">
    </form>
</div>

<div class="space-y-6">
    @forelse($books as $book)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col hover:shadow-lg transition-all duration-300">
            <div class="flex-1 flex flex-col">
                <h3 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2">{{ $book->judul }}</h3>

                <div class="text-lg text-gray-800 font-bold mb-4">
                    {{ $book->penulis }}
                    @if($book->tahun_terbit)
                        <span class="font-normal text-gray-500 ml-1">({{ $book->tahun_terbit }})</span>
                    @endif
                </div>

                <p class="text-gray-600 leading-relaxed mb-6">
                    {{ $book->sinopsis ?: 'Sinopsis belum tersedia.' }}
                </p>

                <div class="mt-auto flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pt-4 border-t border-gray-100">
                    <div class="text-sm">
                        <span class="text-gray-500">Kategori:</span>
                        <span class="font-semibold text-gray-800">{{ $book->kategori?->nama ?? '-' }}</span>
                        <span class="mx-2 text-gray-300 hidden sm:inline">|</span>
                        <br class="sm:hidden">
                        <span class="font-bold {{ $book->stok_tersedia > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $book->stok_tersedia > 0 ? 'Tersedia: ' . $book->stok_tersedia : 'Tidak Tersedia' }}
                        </span>
                    </div>

                    @if($book->stok_tersedia > 0)
                        <button type="button" data-book-title="{{ $book->judul }}" data-book-id="{{ $book->id }}" class="borrow-button w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-8 rounded-lg shadow-md transition-all inline-flex justify-center items-center gap-2">
                            Pinjam Buku
                        </button>
                    @else
                        <button disabled class="w-full sm:w-auto bg-gray-200 text-gray-400 font-bold py-2.5 px-8 rounded-lg cursor-not-allowed border border-gray-300">
                            Sedang Kosong
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center text-gray-500">
            Buku tidak ditemukan.
        </div>
    @endforelse
</div>

<div id="borrowModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 transform transition-all">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800" id="modalBookTitle">Konfirmasi Peminjaman</h3>
                <p class="text-gray-500 mt-2">Isi rencana tanggal dan jam pengembalian buku ini.</p>
            </div>

            <form action="{{ route('user.peminjaman.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="buku_id" id="modalBookId">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Rencana Tanggal Kembali</label>
                        <input type="date" required name="return_date" min="{{ now()->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Rencana Jam Kembali</label>
                        <input type="time" required name="return_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>

                <div class="pt-6 flex flex-col md:flex-row gap-3">
                    <button type="button" onclick="closeModal()" class="flex-1 px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-lg hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 shadow-lg transition">Konfirmasi Pinjam</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('borrowModal');
    const bookTitleSpan = document.getElementById('modalBookTitle');
    const bookIdInput = document.getElementById('modalBookId');

    function openModal(title, id) {
        bookTitleSpan.innerText = 'Pinjam: ' + title;
        bookIdInput.value = id;
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
        bookIdInput.value = '';
    }

    document.querySelectorAll('.borrow-button').forEach((button) => {
        button.addEventListener('click', () => {
            openModal(button.dataset.bookTitle, button.dataset.bookId);
        });
    });
</script>
@endsection
