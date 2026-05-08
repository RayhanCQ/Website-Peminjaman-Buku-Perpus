@extends('layouts.app')
@section('title', 'Pengembalian Buku')

@section('content')
<div class="max-w-3xl mx-auto mt-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="mb-8 border-b border-gray-100 pb-6">
            <h2 class="text-2xl font-extrabold text-gray-800 mb-2">Form Pengembalian Buku</h2>
            <p class="text-gray-500">Admin mencatat buku yang sudah dikembalikan oleh peminjam.</p>
        </div>

        @if($loans->isEmpty())
            <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-5 text-center text-gray-500">
                Tidak ada buku yang sedang dipinjam.
            </div>
        @else
            <form action="{{ route('admin.pengembalian.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Buku yang Dikembalikan</label>
                    <select name="peminjaman_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-white">
                        <option value="" disabled selected>Pilih data peminjaman...</option>
                        @foreach($loans as $loan)
                            @php
                                $isLate = $loan->status === 'terlambat' || $loan->tanggal_jatuh_tempo->isPast();
                            @endphp
                            <option value="{{ $loan->id }}" @selected(old('peminjaman_id') == $loan->id)>
                                {{ $loan->user?->name ?? 'User tidak ditemukan' }} - {{ $loan->buku?->judul ?? 'Buku sudah dihapus' }} - jatuh tempo {{ $loan->tanggal_jatuh_tempo->format('d M Y H:i') }}{{ $isLate ? ' - terlambat' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Pengembalian</label>
                        <input type="date" name="return_date" value="{{ old('return_date', now()->format('Y-m-d')) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Jam Pengembalian</label>
                        <input type="time" name="return_time" value="{{ old('return_time', now()->format('H:i')) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Keterangan Kondisi Buku (Opsional)</label>
                    <textarea name="kondisi_kembali" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all">{{ old('kondisi_kembali') }}</textarea>
                </div>

                <div class="pt-6 mt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="w-full md:w-auto px-8 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 shadow-md transition-all">
                        Simpan Pengembalian
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
