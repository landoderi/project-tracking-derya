<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'tanggal',
        'jenis',
        'kategori_id',
        'akun_id',
        'jumlah',
        'keterangan',
        'user_id',
    ];

    // 🔗 Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // 🔗 Relasi ke Akun
    public function akun()
    {
        return $this->belongsTo(AkunKeuangan::class, 'akun_id');
    }
}
