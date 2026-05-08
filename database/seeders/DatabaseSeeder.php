<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Perpus',
                'email' => 'admin@perpus.local',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Chico Diar Ramadhan',
                'email' => 'chico@student.undip.ac.id',
                'nim' => '21120124140150',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti.a@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }

        $categories = collect([
            'Fiksi / Novel',
            'Pendidikan / Akademik',
            'Teknologi / Sains',
            'Sejarah',
            'Pengembangan Diri',
        ])->mapWithKeys(function (string $name) {
            $category = KategoriBuku::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['nama' => $name]
            );

            return [$name => $category];
        });

        $books = [
            [
                'judul' => 'Morfologi: Kajian Proses Pembentukan Kata',
                'penulis' => 'Prof. Dr. Drs. I Wayan Simpen, M.Hum.',
                'tahun_terbit' => 2021,
                'kategori' => 'Pendidikan / Akademik',
                'stok_total' => 3,
                'stok_tersedia' => 2,
                'lokasi_rak' => 'A-01',
                'sinopsis' => 'Kajian proses pembentukan kata dalam bahasa Indonesia.',
            ],
            [
                'judul' => 'Atomic Habits',
                'penulis' => 'James Clear',
                'tahun_terbit' => 2018,
                'kategori' => 'Pengembangan Diri',
                'stok_total' => 4,
                'stok_tersedia' => 3,
                'lokasi_rak' => 'B-02',
                'sinopsis' => 'Perubahan kecil yang memberikan hasil luar biasa.',
            ],
            [
                'judul' => 'Sistem Digital',
                'penulis' => 'Ronald J. Tocci',
                'tahun_terbit' => 2017,
                'kategori' => 'Teknologi / Sains',
                'stok_total' => 2,
                'stok_tersedia' => 1,
                'lokasi_rak' => 'C-03',
            ],
            [
                'judul' => 'Bumi Manusia',
                'penulis' => 'Pramoedya Ananta Toer',
                'tahun_terbit' => 1980,
                'kategori' => 'Fiksi / Novel',
                'stok_total' => 5,
                'stok_tersedia' => 5,
                'lokasi_rak' => 'D-01',
            ],
            [
                'judul' => 'Naruto Vol 1',
                'penulis' => 'Masashi Kishimoto',
                'tahun_terbit' => 1999,
                'kategori' => 'Fiksi / Novel',
                'stok_total' => 1,
                'stok_tersedia' => 0,
                'lokasi_rak' => 'D-05',
            ],
        ];

        foreach ($books as $book) {
            Buku::updateOrCreate(
                ['judul' => $book['judul']],
                [
                    'penulis' => $book['penulis'],
                    'tahun_terbit' => $book['tahun_terbit'],
                    'kategori_buku_id' => $categories[$book['kategori']]->id,
                    'stok_total' => $book['stok_total'],
                    'stok_tersedia' => $book['stok_tersedia'],
                    'lokasi_rak' => $book['lokasi_rak'],
                    'sinopsis' => $book['sinopsis'] ?? null,
                ]
            );
        }

        $chico = User::where('email', 'chico@student.undip.ac.id')->firstOrFail();
        $siti = User::where('email', 'siti.a@gmail.com')->firstOrFail();

        $loans = [
            [
                'kode_peminjaman' => 'PJM-20260501-001',
                'user_id' => $chico->id,
                'buku_id' => Buku::where('judul', 'Morfologi: Kajian Proses Pembentukan Kata')->firstOrFail()->id,
                'tanggal_pinjam' => '2026-05-01 09:00:00',
                'tanggal_jatuh_tempo' => '2026-05-10 10:30:00',
                'tanggal_kembali' => '2026-05-10 10:30:00',
                'status' => 'kembali',
                'kondisi_kembali' => 'Baik',
            ],
            [
                'kode_peminjaman' => 'PJM-20260508-002',
                'user_id' => $chico->id,
                'buku_id' => Buku::where('judul', 'Atomic Habits')->firstOrFail()->id,
                'tanggal_pinjam' => '2026-05-08 14:00:00',
                'tanggal_jatuh_tempo' => '2026-05-15 14:00:00',
                'status' => 'dipinjam',
            ],
            [
                'kode_peminjaman' => 'PJM-20260428-003',
                'user_id' => $siti->id,
                'buku_id' => Buku::where('judul', 'Sistem Digital')->firstOrFail()->id,
                'tanggal_pinjam' => '2026-04-28 09:00:00',
                'tanggal_jatuh_tempo' => '2026-05-05 09:00:00',
                'status' => 'terlambat',
            ],
        ];

        foreach ($loans as $loan) {
            Peminjaman::updateOrCreate(
                ['kode_peminjaman' => $loan['kode_peminjaman']],
                $loan
            );
        }
    }
}
