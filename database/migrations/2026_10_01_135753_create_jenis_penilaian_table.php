<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // membuat tabel jenis_penilaian dengan kolom:
        // id sebagai primary key
        // kode dengan tipe data string, panjang 30, dan bersifat unik
        // nama dengan tipe data string, panjang 100
        // kategori dengan tipe data string, panjang 30
        // timestamps untuk membuat kolom created_at dan updated_at
        Schema::create('jenis_penilaian', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();
            $table->string('nama', 100);
            $table->string('kategori', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_penilaian');
    }
};
