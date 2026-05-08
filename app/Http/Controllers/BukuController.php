<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
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
                ->where('stok_tersedia', '>', 0)
                ->orderBy('judul')
                ->get(),
            'emptyBooks' => Buku::with('kategori')
                ->where('stok_tersedia', 0)
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
