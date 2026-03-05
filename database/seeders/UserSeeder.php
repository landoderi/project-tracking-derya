<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ✅ Nonaktifkan foreign key constraint sementara
        Schema::disableForeignKeyConstraints();

        // ✅ Kosongkan tabel user secara aman
        User::query()->delete();

        // ✅ Aktifkan kembali foreign key constraint
        Schema::enableForeignKeyConstraints();

        // ✅ Tambahkan user baru
        User::create([
            'name' => 'Admin',
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Member',
            'role' => 'member',
            'email' => 'member@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
