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
        // membuat tabel mapel dengan kolom:
        // id sebagai primary key
        // kode_mapel dengan tipe data string, panjang 20, dan bersifat unik
        // nama_mapel dengan tipe data string, panjang 100
        // kelompok dengan tipe data string, panjang 50, dan boleh dikosongkan
        // deskripsi dengan tipe data text, dan boleh dikosongkan
        // is_active dengan tipe data boolean, defaultnya berisi true
        // timestamps untuk membuat kolom created_at dan updated_at
        Schema::create('mapel', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mapel', 20)->unique();
            $table->string('nama_mapel', 100);
            $table->string('kelompok', 50)->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapel');
    }
};
