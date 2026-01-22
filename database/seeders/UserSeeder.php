<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::truncate();

        $admin = \App\Models\User::create([
            'name' => 'Admin',
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);

        $petugas = \App\Models\User::create([
            'name' => 'Member',
            'role' => 'member',
            'email' => 'member@example.com',
            'password' => bcrypt('password')
        ]);
    }
}
