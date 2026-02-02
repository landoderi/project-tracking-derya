<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriKeuangan extends Model
{
    use HasFactory;

    protected $table = 'kategori_keuangan';

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
