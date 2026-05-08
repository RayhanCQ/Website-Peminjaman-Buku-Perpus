<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserLibraryController extends Controller
{
    public function dashboard(): View|RedirectResponse
    {
        if ($redirect = $this->ensureUser()) {
            return $redirect;
        }

        $user = Auth::user();

        return view('user.dashboard', [
            'role' => 'user',
            'activeBorrowCount' => $user->peminjaman()->whereIn('status', ['dipinjam', 'terlambat'])->count(),
            'loanHistoryCount' => $user->peminjaman()->count(),
        ]);
    }

    public function peminjaman(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->ensureUser()) {
            return $redirect;
        }

        $search = $request->string('search')->toString();

        $books = Buku::with('kategori')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('judul', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%");
                });
            })
            ->orderBy('judul')
            ->get();

        return view('user.peminjaman', [
            'role' => 'user',
            'books' => $books,
            'search' => $search,
        ]);
    }

    public function storePeminjaman(Request $request): RedirectResponse
    {
        if ($redirect = $this->ensureUser()) {
            return $redirect;
        }

        $validated = $request->validate([
            'buku_id' => ['required', 'exists:buku,id'],
            'return_date' => ['required', 'date', 'after_or_equal:today'],
            'return_time' => ['required', 'date_format:H:i'],
        ]);

        $returnAt = "{$validated['return_date']} {$validated['return_time']}:00";

        DB::transaction(function () use ($validated, $returnAt) {
            $book = Buku::whereKey($validated['buku_id'])->lockForUpdate()->firstOrFail();

            if ($book->stok_tersedia < 1) {
                throw ValidationException::withMessages([
                    'buku_id' => 'Stok buku sedang kosong.',
                ]);
            }

            $book->decrement('stok_tersedia');

            Peminjaman::create([
                'kode_peminjaman' => 'PJM-' . now()->format('YmdHis') . '-' . Auth::id(),
                'user_id' => Auth::id(),
                'buku_id' => $book->id,
                'tanggal_pinjam' => now(),
                'tanggal_jatuh_tempo' => $returnAt,
                'status' => 'dipinjam',
            ]);
        });

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Buku berhasil dipinjam.');
    }

    private function ensureUser(): ?RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return null;
    }
}
