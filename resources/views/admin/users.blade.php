@extends('layouts.app')
@section('title', 'Keseluruhan User')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="bg-indigo-600 p-2 rounded-lg text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Daftar Aktivitas Peminjam</h3>
        </div>
        <span class="bg-indigo-100 text-indigo-700 px-4 py-1.5 rounded-full text-xs font-bold shadow-sm">Total 2 Anggota Aktif</span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left min-w-max border-collapse">
            <thead class="bg-gray-50 text-gray-600 text-xs uppercase tracking-widest font-bold">
                <tr>
                    <th class="p-5 border-b">Informasi Pengguna</th>
                    <th class="p-5 border-b text-center">Total</th>
                    <th class="p-5 border-b">Detail Buku & Estimasi Pengembalian</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="p-5 align-top">
                        <div class="font-bold text-gray-900 text-base">Chico Diar Ramadhan</div>
                        <div class="text-sm text-gray-500">chico@student.undip.ac.id</div>
                        <div class="mt-2 text-[10px] font-bold text-indigo-500 uppercase tracking-tighter">NIM 21120124140150</div>
                    </td>
                    <td class="p-5 text-center align-top">
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-700 font-extrabold text-lg border border-gray-200">
                            2
                        </div>
                    </td>
                    <td class="p-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm relative overflow-hidden group">
                                <div class="absolute top-0 right-0 bg-green-500 text-white text-[10px] px-2 py-1 font-bold rounded-bl-lg uppercase">Kembali</div>
                                <h4 class="font-bold text-gray-800 text-sm mb-2 pr-12 line-clamp-1">Morfologi: Kajian Proses</h4>
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Dikembalikan: <span class="font-bold">10 Mei 2026</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Pukul: <span class="font-bold text-gray-700">10:30 WIB</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-indigo-50/30 border border-indigo-100 rounded-xl p-4 shadow-sm relative overflow-hidden group">
                                <div class="absolute top-0 right-0 bg-indigo-600 text-white text-[10px] px-2 py-1 font-bold rounded-bl-lg uppercase">Dipinjam</div>
                                <h4 class="font-bold text-indigo-900 text-sm mb-2 pr-12 line-clamp-1">Atomic Habits</h4>
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 text-xs text-indigo-600">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Estimasi: <span class="font-bold">15 Mei 2026</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-indigo-600">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Pukul: <span class="font-bold text-indigo-900">14:00 WIB</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="p-5 align-top">
                        <div class="font-bold text-gray-900 text-base">Siti Aminah</div>
                        <div class="text-sm text-gray-500">siti.a@gmail.com</div>
                    </td>
                    <td class="p-5 text-center align-top">
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-700 font-extrabold text-lg border border-gray-200">
                            1
                        </div>
                    </td>
                    <td class="p-5">
                        <div class="bg-red-50/50 border border-red-100 rounded-xl p-4 shadow-sm relative overflow-hidden group max-w-sm">
                            <div class="absolute top-0 right-0 bg-red-500 text-white text-[10px] px-2 py-1 font-bold rounded-bl-lg uppercase">Terlambat</div>
                            <h4 class="font-bold text-red-900 text-sm mb-2 pr-12 line-clamp-1">Sistem Digital</h4>
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 text-xs text-red-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Harusnya: <span class="font-bold">05 Mei 2026</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-red-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Pukul: <span class="font-bold">09:00 WIB</span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection