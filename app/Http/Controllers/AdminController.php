<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View|RedirectResponse
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        return view('admin.dashboard', [
            'role' => 'admin',
            'totalJudulBuku' => Buku::count(),
            'bukuDipinjam' => Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])->count(),
        ]);
    }

    public function users(): View|RedirectResponse
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $users = User::where('role', 'user')
            ->with(['peminjaman' => fn ($query) => $query->with('buku')->latest('tanggal_pinjam')])
            ->withCount([
                'peminjaman as active_loans_count' => fn ($query) => $query->whereIn('status', ['dipinjam', 'terlambat']),
            ])
            ->orderBy('name')
            ->get();

        return view('admin.users', [
            'role' => 'admin',
            'users' => $users,
        ]);
    }

    public function pengembalian(): View|RedirectResponse
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        return view('admin.pengembalian', [
            'role' => 'admin',
            'loans' => Peminjaman::with(['user', 'buku'])
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->latest('tanggal_pinjam')
                ->get(),
        ]);
    }

    public function storePengembalian(Request $request): RedirectResponse
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $validated = $request->validate([
            'peminjaman_id' => ['required', 'exists:peminjaman,id'],
            'return_date' => ['required', 'date'],
            'return_time' => ['required', 'date_format:H:i'],
            'kondisi_kembali' => ['nullable', 'string'],
        ]);

        $returnedAt = "{$validated['return_date']} {$validated['return_time']}:00";

        DB::transaction(function () use ($validated, $returnedAt) {
            $loan = Peminjaman::whereKey($validated['peminjaman_id'])
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->lockForUpdate()
                ->firstOrFail();

            $loan->update([
                'tanggal_kembali' => $returnedAt,
                'status' => 'kembali',
                'kondisi_kembali' => $validated['kondisi_kembali'] ?? null,
            ]);

            Buku::whereKey($loan->buku_id)->increment('stok_tersedia');
        });

        return redirect()
            ->route('admin.pengembalian')
            ->with('success', 'Pengembalian buku berhasil dicatat.');
    }

    private function ensureAdmin(): ?RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'admin') {
            return redirect()->route('user.dashboard');
        }

        return null;
    }
}
