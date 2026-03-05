<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan nama tabelnya 'kategori_keuangan' (sesuai Model Anda)
        Schema::table('kategori_keuangan', function (Blueprint $table) {
            // Menambahkan kolom user_id sebagai foreign key
            $table->foreignId('user_id')->after('id')->constrained('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('kategori_keuangan', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};