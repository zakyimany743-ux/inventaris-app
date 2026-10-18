<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk membuat tabel items.
 * Tabel ini menyimpan data barang inventaris.
 *
 * Dijalankan SETELAH migration tabel categories karena
 * tabel items memiliki foreign key category_id yang
 * merujuk ke categories.id.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            // Primary key BIGINT sesuai ketentuan ujian
            $table->bigIncrements('id');

            // Foreign key ke categories.id
            // onDelete('restrict') untuk mencegah penghapusan kategori
            // yang masih memiliki barang (integritas referensial)
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('restrict');

            $table->string('name');
            $table->decimal('price', 12, 2);  // Harga barang
            $table->integer('stock')->default(0); // Jumlah stok
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
