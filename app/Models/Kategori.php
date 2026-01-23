<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama',
        'tipe',
    ];

    // 🔗 Relasi ke Transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'kategori_id');
    }
}
