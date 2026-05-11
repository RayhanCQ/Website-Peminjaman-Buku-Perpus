<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LibraryManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_archive_book_and_hide_it_from_user_borrowing_list(): void
    {
        $admin = $this->createUser('admin');
        $user = $this->createUser('user');
        $book = $this->createBook('Clean Architecture');

        $this->actingAs($admin)
            ->delete(route('admin.buku.archive', $book))
            ->assertRedirect(route('admin.buku.index'));

        $this->assertSoftDeleted('buku', ['id' => $book->id]);
        $this->flushSession();

        $this->actingAs($user)
            ->get(route('user.peminjaman'))
            ->assertOk()
            ->assertDontSeeText('Clean Architecture');
    }

    public function test_user_dashboard_shows_overdue_alert_and_updates_status(): void
    {
        $user = $this->createUser('user');
        $book = $this->createBook('Database Systems');

        $loan = Peminjaman::create([
            'kode_peminjaman' => 'PJM-TEST-001',
            'user_id' => $user->id,
            'buku_id' => $book->id,
            'tanggal_pinjam' => now()->subDays(3),
            'tanggal_jatuh_tempo' => now()->subHour(),
            'status' => Peminjaman::STATUS_DIPINJAM,
        ]);

        $this->actingAs($user)
            ->get(route('user.dashboard'))
            ->assertOk()
            ->assertSeeText('Pengembalian Buku Terlambat')
            ->assertSeeText('Database Systems');

        $this->assertDatabaseHas('peminjaman', [
            'id' => $loan->id,
            'status' => Peminjaman::STATUS_TERLAMBAT,
        ]);
    }

    public function test_admin_can_force_delete_book_without_active_loans(): void
    {
        $admin = $this->createUser('admin');
        $user = $this->createUser('user');
        $book = $this->createBook('Archived History');

        $loan = Peminjaman::create([
            'kode_peminjaman' => 'PJM-TEST-002',
            'user_id' => $user->id,
            'buku_id' => $book->id,
            'tanggal_pinjam' => now()->subDays(5),
            'tanggal_jatuh_tempo' => now()->subDays(2),
            'tanggal_kembali' => now()->subDay(),
            'status' => Peminjaman::STATUS_KEMBALI,
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.buku.force-delete', $book))
            ->assertRedirect(route('admin.buku.index'));

        $this->assertDatabaseMissing('buku', ['id' => $book->id]);
        $this->assertDatabaseHas('peminjaman', [
            'id' => $loan->id,
            'buku_id' => null,
        ]);
    }

    private function createUser(string $role): User
    {
        return User::create([
            'name' => ucfirst($role).' Test',
            'email' => "{$role}@example.test",
            'password' => 'password',
            'role' => $role,
        ]);
    }

    private function createBook(string $title): Buku
    {
        $category = KategoriBuku::create([
            'nama' => $title.' Category',
            'slug' => str($title)->slug().'-category',
        ]);

        return Buku::create([
            'kategori_buku_id' => $category->id,
            'judul' => $title,
            'penulis' => 'Tester',
            'tahun_terbit' => 2026,
            'stok_total' => 1,
            'stok_tersedia' => 1,
        ]);
    }
}
