<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BukuController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        return view('admin.buku.index', [
            'role' => 'admin',
            'availableBooks' => Buku::with('kategori')
                ->withCount(['peminjaman as active_loans_count' => fn ($query) => $query->aktif()])
                ->where('stok_tersedia', '>', 0)
                ->orderBy('judul')
                ->get(),
            'emptyBooks' => Buku::with('kategori')
                ->withCount(['peminjaman as active_loans_count' => fn ($query) => $query->aktif()])
                ->where('stok_tersedia', 0)
                ->orderBy('judul')
                ->get(),
            'archivedBooks' => Buku::onlyTrashed()
                ->with('kategori')
                ->withCount(['peminjaman as active_loans_count' => fn ($query) => $query->aktif()])
                ->orderBy('judul')
                ->get(),
        ]);
    }

    public function create(): View|RedirectResponse
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        return view('admin.buku.create', [
            'role' => 'admin',
            'categories' => KategoriBuku::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'penulis' => ['required', 'string', 'max:255'],
            'kategori_buku_id' => ['required', 'exists:kategori_buku,id'],
            'tahun_terbit' => ['nullable', 'integer', 'min:1000', 'max:2100'],
            'stok_total' => ['required', 'integer', 'min:0'],
            'sinopsis' => ['nullable', 'string'],
        ]);

        Buku::create([
            ...$validated,
            'stok_tersedia' => $validated['stok_total'],
        ]);

        return redirect()
            ->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function archive(string $bookId): RedirectResponse
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $book = Buku::whereKey($bookId)->firstOrFail();
        $book->delete();

        return redirect()
            ->route('admin.buku.index')
            ->with('success', "Buku {$book->judul} berhasil diarsipkan.");
    }

    public function forceDelete(string $bookId): RedirectResponse
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $book = Buku::withTrashed()->whereKey($bookId)->firstOrFail();

        if ($book->peminjaman()->aktif()->exists()) {
            return redirect()
                ->route('admin.buku.index')
                ->withErrors(['buku' => 'Buku masih punya peminjaman aktif. Selesaikan pengembalian dulu sebelum hapus permanen.']);
        }

        $title = $book->judul;

        try {
            $book->forceDelete();
        } catch (QueryException) {
            return redirect()
                ->route('admin.buku.index')
                ->withErrors(['buku' => 'Buku belum bisa dihapus permanen karena masih terhubung dengan data peminjaman. Jalankan migrasi database terbaru, lalu coba lagi.']);
        }

        return redirect()
            ->route('admin.buku.index')
            ->with('success', "Buku {$title} berhasil dihapus permanen.");
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
