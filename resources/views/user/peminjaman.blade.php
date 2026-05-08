@extends('layouts.app')
@section('title', 'Peminjaman Buku')

@section('content')
@php
// Data dummy tanpa URL cover gambar
$mock_books = [
    [
        'id' => 1,
        'judul' => 'Morfologi: Kajian Proses Pembentukan Kata',
        'jenis' => 'Pendidikan',
        'tersedia' => true,
        'penulis' => 'Prof. Dr. Drs. I Wayan Simpen, M.Hum.',
        'tahun' => '2021',
        'sinopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ornare quis purus ac auctor. Integer non est quis quam commodo faucibus at sed ante. Mauris dolor nibh, pretium eget justo eu, tincidunt mollis magna.'
    ],
    [
        'id' => 2,
        'judul' => 'Atomic Habits',
        'jenis' => 'Pengembangan Diri',
        'tersedia' => true,
        'penulis' => 'James Clear',
        'tahun' => '2018',
        'sinopsis' => 'Perubahan kecil yang memberikan hasil luar biasa. Buku ini membahas sistem yang terbukti dan mudah diterapkan dalam kehidupan sehari-hari.'
    ]
];
@endphp

<div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 border-b border-gray-200 pb-4">
    <p class="text-gray-500 font-bold text-lg">Pilih buku yang ingin kamu pinjam.</p>
    <div class="relative w-full md:w-80">
        <input type="text" placeholder="Cari judul buku..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm transition-all">
    </div>
</div>

<div class="space-y-6">
    @foreach($mock_books as $buku)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col hover:shadow-lg transition-all duration-300">
        <div class="flex-1 flex flex-col">
            <h3 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2">{{ $buku['judul'] }}</h3>
            
            <div class="text-lg text-gray-800 font-bold mb-4">
                {{ $buku['penulis'] }} <span class="font-normal text-gray-500 ml-1">({{ $buku['tahun'] }})</span>
            </div>
            
            <p class="text-gray-600 leading-relaxed mb-6">{{ $buku['sinopsis'] }}</p>

            <div class="mt-auto flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pt-4 border-t border-gray-100">
                <div class="text-sm">
                    <span class="text-gray-500">Kategori:</span> 
                    <span class="font-semibold text-gray-800">{{ $buku['jenis'] }}</span> 
                    <span class="mx-2 text-gray-300 hidden sm:inline">|</span>
                    <br class="sm:hidden">
                    <span class="font-bold {{ $buku['tersedia'] ? 'text-green-600' : 'text-red-600' }}">
                        {{ $buku['tersedia'] ? 'Tersedia' : 'Tidak Tersedia' }}
                    </span>
                </div>
                
                @if($buku['tersedia'])
                    <button onclick="openModal('{{ $buku['judul'] }}')" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-8 rounded-lg shadow-md transition-all inline-flex justify-center items-center gap-2">
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
    @endforeach
</div>

<div id="borrowModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 transform transition-all">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800" id="modalBookTitle">Konfirmasi Peminjaman</h3>
                <p class="text-gray-500 mt-2">Kapan kamu akan mengembalikan buku ini?</p>
            </div>

            <form action="#" onsubmit="event.preventDefault(); confirmBorrow();" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Kembali</label>
                        <input type="date" required id="returnDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Jam Kembali</label>
                        <input type="time" required id="returnTime" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
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

    function openModal(title) {
        bookTitleSpan.innerText = "Pinjam: " + title;
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    function confirmBorrow() {
        const date = document.getElementById('returnDate').value;
        const time = document.getElementById('returnTime').value;
        alert(`Buku Berhasil Dipinjam!\nRencana kembali: ${date} jam ${time}`);
        window.location.href = '/user/dashboard';
    }
</script>
@endsection