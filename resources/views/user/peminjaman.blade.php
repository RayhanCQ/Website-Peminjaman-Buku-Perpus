@extends('layouts.app')
@section('title', 'Peminjaman Buku')

@section('content')
@php
$mock_books = [
    [
        'id' => 1,
        'judul' => 'Morfologi: Kajian Proses Pembentukan Kata',
        'jenis' => 'Pendidikan',
        'tersedia' => true,
        'penulis' => 'Prof. Dr. Drs. I Wayan Simpen, M.Hum.',
        'tahun' => '2021',
        'sinopsis' => 'Membongkar struktur kata untuk memahami makna: Analisis mendalam bagaimana morfem dirakit menjadi kata yang bermakna.',
        'cover' => 'data:image/jpeg;base64,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'
    ],
    [
        'id' => 2,
        'judul' => 'Atomic Habits',
        'jenis' => 'Pengembangan Diri',
        'tersedia' => true,
        'penulis' => 'James Clear',
        'tahun' => '2018',
        'sinopsis' => 'Perubahan kecil yang memberikan hasil luar biasa. Buku ini membahas sistem yang terbukti.',
        'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTa4kw_Z-TDF1wb-ZcJiCMIMlFsg5KGSFevgegLNYGiP8NRbAv1FUW-v0mquXPpyHJM639EAxiXXrWIgBca9iWrb0pYJg3uX6BlVGJxiCBXzg&s=10'
    ]
];
@endphp

<div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 border-b border-gray-200 pb-4">
    <p class="text-gray-500 font-bold text-lg">Pilih buku yang ingin kamu pinjam.</p>
    <div class="relative w-full md:w-80">
        <input type="text" placeholder="Cari judul buku..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm">
    </div>
</div>

<div class="space-y-8">
    @foreach($mock_books as $buku)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col md:flex-row gap-8 hover:shadow-lg transition-all">
        <div class="w-full md:w-48 shrink-0">
            <img src="{{ $buku['cover'] }}" class="w-48 h-auto object-cover rounded-lg shadow-md">
        </div>
        <div class="flex-1 flex flex-col">
            <h3 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $buku['judul'] }}</h3>
            <div class="text-lg text-gray-800 font-bold mb-4">
                {{ $buku['penulis'] }} <span class="font-normal text-gray-600 ml-1">{{ $buku['tahun'] }}</span>
            </div>
            <p class="text-gray-600 leading-relaxed mb-6">{{ $buku['sinopsis'] }}</p>

            <div class="mt-auto">
                <button onclick="openModal('{{ $buku['judul'] }}')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition-all inline-flex items-center gap-2">
                    Pinjam Buku Ini
                </button>
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