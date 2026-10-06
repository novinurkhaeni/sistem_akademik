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
        // membuat tabel nilai dengan kolom:
        // id sebagai primary key
        // penilaian_id sebagai foreign key dari tabel penilaian, berdasarkan primary key dari tabel penilaian. Tolak penghapusan jika masih digunakan
        // siswa_id sebagai foreign key dari tabel siswa, berdasarkan primary key dari tabel siswa. Tolak penghapusan jika masih digunakan
        // nilai dengan tipe data desimal, dengan panjang sebelum koma 5, setelah koma 2
        // catatan dengan tipe data text, boleh dikosongkan
        // timestamps untuk membuat kolom created_at dan updated_at
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();

            $table->foreignId('penilaian_id')
                ->constrained('penilaian')
                ->cascadeOnDelete();

            $table->foreignId('siswa_id')
                ->constrained('siswa')
                ->restrictOnDelete();

            $table->decimal('nilai', 5, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Memastikan satu siswa hanya memiliki satu nilai
            // untuk setiap penilaian yang sama.
            $table->unique(
                ['penilaian_id', 'siswa_id'],
                'nilai_penilaian_siswa_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
