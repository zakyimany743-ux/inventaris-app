<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Mengisi tabel categories dengan 3 kategori awal.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Aksesori'],
            ['name' => 'Perangkat Komputer'],
            ['name' => 'Penyimpanan'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}
