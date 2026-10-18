<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Database Seeder Utama
 *
 * Menjalankan semua seeder secara berurutan:
 * 1. UserSeeder      -> buat akun pengguna
 * 2. CategorySeeder  -> buat 3 kategori
 * 3. ItemSeeder      -> buat 5 barang (terhubung ke kategori)
 *
 * Urutan ini penting karena ItemSeeder memerlukan kategori yang sudah ada.
 *
 * Jalankan dengan perintah: php artisan db:seed
 * Atau bersamaan dengan migration: php artisan migrate:fresh --seed
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ItemSeeder::class,
        ]);
    }
}
