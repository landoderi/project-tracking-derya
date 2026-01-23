<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AkunKeuangan extends Model
{
    use HasFactory;

    protected $table = 'akun_keuangan';

    protected $fillable = [
        'nama_akun',
        'jenis',
        'saldo_awal',
    ];

    // 🔗 Relasi ke Transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'akun_id');
    }
}
