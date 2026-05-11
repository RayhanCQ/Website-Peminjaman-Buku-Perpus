<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        DB::statement('ALTER TABLE `peminjaman` DROP FOREIGN KEY `peminjaman_buku_id_foreign`');
        DB::statement('ALTER TABLE `peminjaman` MODIFY `buku_id` BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE `peminjaman` ADD CONSTRAINT `peminjaman_buku_id_foreign` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`) ON DELETE SET NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        DB::statement('ALTER TABLE `peminjaman` DROP FOREIGN KEY `peminjaman_buku_id_foreign`');
        DB::statement('ALTER TABLE `peminjaman` ADD CONSTRAINT `peminjaman_buku_id_foreign` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`) ON DELETE RESTRICT');
    }
};
