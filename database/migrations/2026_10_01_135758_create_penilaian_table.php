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
        // membuat tabel penilaian dengan kolom:
        // id sebagai primary key
        // data_mengajar_id sebagai foreign key dari tabel data_mengajar, berdasarkan primary key dari tabel data_mengajar. Tolak penghapusan jika masih digunakan
        // jenis_penilaian_id sebagai foreign key dari tabel jenis_penilaian, berdasarkan primary key dari tabel jenis_penilaian. Tolak penghapusan jika masih digunakan
        // nama_penilaian dengan tipe data string, panjang 150
        // semester dengan tipe data enum, pilihannya ada ganjil, genap
        // materi dengan tipe data string, panjang 200, boleh dikosongkan
        // tanggal dengan tipe data date, boleh dikosongkan
        // bobot dengan tipe data desimal, dengan panjang sebelum koma 5, setelah koma 2, default diisi 100
        // is_published dengan tipe data boolean, default berisi false
        // timestamps untuk membuat kolom created_at dan updated_at
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();

            $table->foreignId('data_mengajar_id')
                ->constrained('data_mengajar')
                ->restrictOnDelete();

            $table->foreignId('jenis_penilaian_id')
                ->constrained('jenis_penilaian')
                ->restrictOnDelete();

            $table->string('nama_penilaian', 150);
            $table->enum('semester', ['ganjil', 'genap']);
            $table->string('materi', 200)->nullable();
            $table->date('tanggal')->nullable();
            $table->decimal('bobot', 5, 2)->default(100);
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            // Membuat index gabungan untuk mempercepat pencarian nilai
            // berdasarkan data mengajar dan semester.
            $table->index(
                ['data_mengajar_id', 'semester'],
                'penilaian_mengajar_semester_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
