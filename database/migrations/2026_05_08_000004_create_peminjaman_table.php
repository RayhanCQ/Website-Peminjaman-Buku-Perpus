<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('kode_peminjaman', 30)->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('buku_id')->nullable()->constrained('buku')->nullOnDelete();
            $table->dateTime('tanggal_pinjam');
            $table->dateTime('tanggal_jatuh_tempo');
            $table->dateTime('tanggal_kembali')->nullable();
            $table->string('status', 20)->default('dipinjam')->index();
            $table->text('kondisi_kembali')->nullable();
            $table->decimal('denda', 10, 2)->default(0);
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['buku_id', 'status']);
            $table->index('tanggal_jatuh_tempo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
