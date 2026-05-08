@extends('layouts.app')
@section('title', 'Keseluruhan User')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="bg-indigo-600 p-2 rounded-lg text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Daftar Aktivitas Peminjam</h3>
        </div>
        <span class="bg-indigo-100 text-indigo-700 px-4 py-1.5 rounded-full text-xs font-bold shadow-sm">Total {{ $users->count() }} Anggota</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left min-w-max border-collapse">
            <thead class="bg-gray-50 text-gray-600 text-xs uppercase tracking-widest font-bold">
                <tr>
                    <th class="p-5 border-b">Informasi Pengguna</th>
                    <th class="p-5 border-b text-center">Aktif</th>
                    <th class="p-5 border-b">Detail Buku & Estimasi Pengembalian</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-5 align-top">
                            <div class="font-bold text-gray-900 text-base">{{ $user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                            @if($user->nim)
                                <div class="mt-2 text-[10px] font-bold text-indigo-500 uppercase tracking-tighter">NIM {{ $user->nim }}</div>
                            @endif
                        </td>
                        <td class="p-5 text-center align-top">
                            <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-700 font-extrabold text-lg border border-gray-200">
                                {{ $user->active_loans_count }}
                            </div>
                        </td>
                        <td class="p-5">
                            @if($user->peminjaman->isEmpty())
                                <div class="text-sm text-gray-500">Belum ada riwayat peminjaman.</div>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($user->peminjaman as $loan)
                                        @php
                                            $isLate = in_array($loan->status, ['terlambat']) || (! $loan->tanggal_kembali && $loan->tanggal_jatuh_tempo->isPast());
                                            $statusClass = $loan->status === 'kembali'
                                                ? 'border-green-100 text-green-600 bg-white'
                                                : ($isLate ? 'border-red-100 text-red-600 bg-red-50/50' : 'border-indigo-100 text-indigo-600 bg-indigo-50/30');
                                            $badgeClass = $loan->status === 'kembali'
                                                ? 'bg-green-500'
                                                : ($isLate ? 'bg-red-500' : 'bg-indigo-600');
                                            $label = $loan->status === 'kembali' ? 'Kembali' : ($isLate ? 'Terlambat' : 'Dipinjam');
                                            $dateLabel = $loan->status === 'kembali' ? 'Dikembalikan' : ($isLate ? 'Harusnya' : 'Estimasi');
                                            $dateValue = $loan->status === 'kembali' ? $loan->tanggal_kembali : $loan->tanggal_jatuh_tempo;
                                        @endphp
                                        <div class="{{ $statusClass }} border rounded-xl p-4 shadow-sm relative overflow-hidden group">
                                            <div class="absolute top-0 right-0 {{ $badgeClass }} text-white text-[10px] px-2 py-1 font-bold rounded-bl-lg uppercase">{{ $label }}</div>
                                            <h4 class="font-bold text-sm mb-2 pr-16 line-clamp-1">{{ $loan->buku?->judul ?? 'Buku sudah dihapus' }}</h4>
                                            <div class="space-y-1">
                                                <div class="flex items-center gap-2 text-xs">
                                                    {{ $dateLabel }}:
                                                    <span class="font-bold">{{ $dateValue?->format('d M Y') ?? '-' }}</span>
                                                </div>
                                                <div class="flex items-center gap-2 text-xs">
                                                    Pukul:
                                                    <span class="font-bold">{{ $dateValue?->format('H:i') ?? '-' }} WIB</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-8 text-center text-gray-500">Belum ada user peminjam.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
