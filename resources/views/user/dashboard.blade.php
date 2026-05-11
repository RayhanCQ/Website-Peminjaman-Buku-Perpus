@extends('layouts.app')
@section('title', 'User Dashboard')

@section('content')
@if($overdueLoans->isNotEmpty())
    <div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 p-5 shadow-sm">
        <div class="flex flex-col gap-3">
            <div>
                <h3 class="font-extrabold text-red-700 text-lg">Pengembalian Buku Terlambat</h3>
                <p class="text-red-600 text-sm mt-1">Segera kembalikan buku berikut ke admin perpustakaan.</p>
            </div>
            <div class="space-y-2">
                @foreach($overdueLoans as $loan)
                    <div class="bg-white/70 border border-red-100 rounded-lg px-4 py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                        <span class="font-bold text-gray-800">{{ $loan->buku?->judul ?? 'Buku sudah dihapus' }}</span>
                        <span class="text-sm font-semibold text-red-600">
                            Jatuh tempo {{ $loan->tanggal_jatuh_tempo->format('d M Y H:i') }} WIB
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-indigo-500">
        <h3 class="text-gray-500 text-sm font-bold uppercase">Buku Sedang Dipinjam</h3>
        <p class="text-3xl font-extrabold text-gray-800 mt-2">{{ $activeBorrowCount }}</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-orange-500">
        <h3 class="text-gray-500 text-sm font-bold uppercase">Total Riwayat Pinjaman</h3>
        <p class="text-3xl font-extrabold text-gray-800 mt-2">{{ $loanHistoryCount }}</p>
    </div>
</div>

<div class="bg-indigo-50 p-6 rounded-xl border border-indigo-100">
    <h3 class="font-bold text-indigo-800 text-lg">Halo, {{ auth()->user()->name }}!</h3>
    <p class="text-indigo-600 mt-1">Jangan lupa kembalikan buku tepat waktu ya!</p>
</div>
@endsection
