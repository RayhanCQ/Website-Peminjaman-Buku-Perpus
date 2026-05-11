<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    public const STATUS_DIPINJAM = 'dipinjam';

    public const STATUS_TERLAMBAT = 'terlambat';

    public const STATUS_KEMBALI = 'kembali';

    protected $table = 'peminjaman';

    protected $fillable = [
        'kode_peminjaman',
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali',
        'status',
        'kondisi_kembali',
        'denda',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'datetime',
            'tanggal_jatuh_tempo' => 'datetime',
            'tanggal_kembali' => 'datetime',
            'denda' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id')->withTrashed();
    }

    public function scopeAktif(Builder $query): Builder
    {
        return $query
            ->whereNull('tanggal_kembali')
            ->whereIn('status', [self::STATUS_DIPINJAM, self::STATUS_TERLAMBAT]);
    }

    public function scopeTerlambat(Builder $query): Builder
    {
        return $query
            ->aktif()
            ->where('tanggal_jatuh_tempo', '<', now());
    }

    public static function tandaiPeminjamanTerlambat(): int
    {
        return self::query()
            ->where('status', self::STATUS_DIPINJAM)
            ->whereNull('tanggal_kembali')
            ->where('tanggal_jatuh_tempo', '<', now())
            ->update(['status' => self::STATUS_TERLAMBAT]);
    }
}
