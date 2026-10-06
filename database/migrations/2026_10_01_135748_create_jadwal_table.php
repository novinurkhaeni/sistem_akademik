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
        // membuat tabel jadwal dengan kolom:
        // id sebagai primary key
        // data_mengajar_id sebagai foreign key dari tabel data_mengajar, berdasarkan primary key dari tabel data_mengajar. Tolak penghapusan jika masih digunakan
        // hari dengan tipe data enum, pilihannya ada Senin, Selasa, Rabu, Kamis, Jumat, Sabtu
        // jam_mulai dengan tipe data time
        // jam_selesai dengan tipe data time
        // ruang dengan tipe data string, panjang 50, boleh dikosongkan
        // timestamps untuk membuat kolom created_at dan updated_at
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();

            $table->foreignId('data_mengajar_id')
                ->constrained('data_mengajar')
                ->cascadeOnDelete();

            $table->enum('hari', [
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu'
            ]);

            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('ruang', 50)->nullable();
            $table->timestamps();

            // Membuat index gabungan untuk mempercepat pencarian atau pengurutan
            // data berdasarkan hari dan jam mulai.
            $table->index(['hari', 'jam_mulai']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
