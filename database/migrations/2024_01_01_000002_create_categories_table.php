<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk membuat tabel categories.
 * Tabel ini menyimpan data kategori barang.
 *
 * Dijalankan SEBELUM migration tabel items karena items
 * memiliki foreign key yang merujuk ke categories.id.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            // Primary key BIGINT sesuai ketentuan ujian
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
