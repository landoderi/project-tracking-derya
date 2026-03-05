<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('jenis', ['pemasukan', 'pengeluaran']);
            
            // Relasi ke tabel Kategori
            $table->foreignId('kategori_id')
                  ->constrained('kategori_keuangan')
                  ->onDelete('cascade'); 
            
            // Relasi ke tabel Akun
            $table->foreignId('akun_id')
                  ->constrained('akun_keuangan')
                  ->onDelete('cascade');

            // Relasi ke tabel User
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->decimal('jumlah', 15, 2);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};