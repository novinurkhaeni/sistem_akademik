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
