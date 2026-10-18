<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Membuat akun pengguna untuk pengujian login.
     * Password disimpan menggunakan hashing (bcrypt).
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@inventaris.test'],
            [
                'name'     => 'Admin Inventaris',
                'email'    => 'admin@inventaris.test',
                // Hash::make() akan menghasilkan password ter-hash (bcrypt)
                'password' => Hash::make('password123'),
            ]
        );
    }
}
