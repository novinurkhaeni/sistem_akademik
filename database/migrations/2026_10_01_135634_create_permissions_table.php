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
        // membuat tabel permissions dengan kolom:
        // id sebagai primary key
        // nama_permission dengan tipe data string, panjang 100, dan bersifat unik
        // deskripsi dengan tipe data string, dan boleh dikosongkan. panjang kolom dikosongkan berarti otomatis menggunakan panjang maksimal string yaitu 255
        // timestamps untuk membuat kolom created_at dan updated_at
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('nama_permission', 100)->unique();
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
