<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriKeuangan extends Model
{
    use HasFactory;

    protected $table = 'kategori_keuangan';

    protected $fillable = [
        'nama',
        'tipe',
        'user_id', // 👈 WAJIB ditambahkan agar bisa disimpan lewat Controller
    ];

    /**
     * Relasi ke User (Pemilik Kategori)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Transaksi
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'kategori_id');
    }
}