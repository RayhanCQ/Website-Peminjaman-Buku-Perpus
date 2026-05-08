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
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_buku_id')->nullable()->constrained('kategori_buku')->nullOnDelete();
            $table->string('judul');
            $table->string('penulis');
            $table->unsignedSmallInteger('tahun_terbit')->nullable();
            $table->string('penerbit')->nullable();
            $table->string('isbn', 30)->nullable()->unique();
            $table->text('sinopsis')->nullable();
            $table->unsignedInteger('stok_total')->default(0);
            $table->unsignedInteger('stok_tersedia')->default(0);
            $table->string('lokasi_rak', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['judul', 'penulis']);
            $table->index('stok_tersedia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
