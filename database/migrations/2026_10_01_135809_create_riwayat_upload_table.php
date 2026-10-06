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
        // membuat tabel riwayat_upload dengan kolom:
        // id sebagai primary key
        // user_id sebagai foreign key dari tabel users, berdasarkan primary key dari tabel users. Tolak penghapusan jika masih digunakan
        // nama_file dengan tipe data string, panjang 255
        // jenis_data dengan tipe data string, panjang 50
        // jumlah_data dengan tipe data Tiny Integer tanpa nilai negatif, default diisi 0
        // jumlah_berhasil dengan tipe data Tiny Integer tanpa nilai negatif, default diisi 0
        // jumlah_gagal dengan tipe data Tiny Integer tanpa nilai negatif, default diisi 0
        // status dengan tipe data string, panjang 30, default diproses
        // uploaded_at dengan tipe data timestamp, jika tidak diisi, otomatis menggunakan waktu saat data dibuat.
        // timestamps untuk membuat kolom created_at dan updated_at
        Schema::create('riwayat_upload', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('nama_file', 255);
            $table->string('jenis_data', 50);
            $table->unsignedInteger('jumlah_data')->default(0);
            $table->unsignedInteger('jumlah_berhasil')->default(0);
            $table->unsignedInteger('jumlah_gagal')->default(0);
            $table->string('status', 30)->default('diproses');
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();

            // Membuat index gabungan untuk mempercepat pencarian data
            // berdasarkan jenis data dan waktu upload.
            $table->index(['jenis_data', 'uploaded_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_upload');
    }
};
