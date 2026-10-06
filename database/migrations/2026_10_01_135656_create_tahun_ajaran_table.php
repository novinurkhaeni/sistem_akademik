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
        // membuat tabel tahun_ajaran dengan kolom:
        // id sebagai primary key
        // nama dengan tipe data string, panjang 20, dan bersifat unik
        // tanggal_mulai dengan tipe data date
        // tanggal_selesai dengan tipe data date
        // is_active dengan tipe data boolean, defaultnya berisi false
        // timestamps untuk membuat kolom created_at dan updated_at
        Schema::create('tahun_ajaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 20)->unique();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_ajaran');
    }
};
