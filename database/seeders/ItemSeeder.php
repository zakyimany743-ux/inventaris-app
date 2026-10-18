<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;

class ItemSeeder extends Seeder
{
    /**
     * Mengisi tabel items dengan 5 barang yang terhubung
     * ke kategori-kategori yang valid (sesuai ketentuan ujian).
     */
    public function run(): void
    {
        // Pastikan kategori sudah ada sebelum membuat barang.
        // Ambil kategori berdasarkan nama agar relasi valid.
        $aksesori  = Category::where('name', 'Aksesori')->first();
        $perangkat = Category::where('name', 'Perangkat Komputer')->first();
        $simpan    = Category::where('name', 'Penyimpanan')->first();

        // Jika kategori belum ada, hentikan seeding
        if (!$aksesori || !$perangkat || !$simpan) {
            throw new \Exception('Kategori belum tersedia. Jalankan CategorySeeder terlebih dahulu.');
        }

        $items = [
            [
                'name'        => 'Keyboard',
                'category_id' => $aksesori->id,
                'price'       => 150000,
                'stock'       => 10,
            ],
            [
                'name'        => 'Mouse',
                'category_id' => $aksesori->id,
                'price'       => 75000,
                'stock'       => 20,
            ],
            [
                'name'        => 'Monitor',
                'category_id' => $perangkat->id,
                'price'       => 1500000,
                'stock'       => 5,
            ],
            [
                'name'        => 'Headset',
                'category_id' => $aksesori->id,
                'price'       => 250000,
                'stock'       => 8,
            ],
            [
                'name'        => 'Flashdisk',
                'category_id' => $simpan->id,
                'price'       => 85000,
                'stock'       => 15,
            ],
        ];

        foreach ($items as $item) {
            Item::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
