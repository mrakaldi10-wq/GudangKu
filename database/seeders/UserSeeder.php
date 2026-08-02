<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas Gudang',
            'email' => 'gudang@admin.com',
            'password' => bcrypt('gudang123'),
            'role' => 'petugas_gudang',
        ]);

        User::create([
            'name' => 'Pemilik Perusahaan',
            'email' => 'pemilik@admin.com',
            'password' => bcrypt('pemilik123'),
            'role' => 'pemilik',
        ]);
    }
}
