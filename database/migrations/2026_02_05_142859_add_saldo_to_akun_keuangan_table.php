<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('akun_keuangan', function (Blueprint $table) {
            // Tambahkan kolom saldo aktif
            $table->decimal('saldo', 15, 2)->default(0)->after('saldo_awal');
        });
    }

    public function down(): void
    {
        Schema::table('akun_keuangan', function (Blueprint $table) {
            $table->dropColumn('saldo');
        });
    }
};
