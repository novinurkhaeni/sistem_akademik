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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas', 50);
            $table->string('tingkat', 20);
            $table->string('jurusan', 100)->nullable();

            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajaran')
                ->restrictOnDelete();

            $table->timestamps();

            $table->unique(
                ['nama_kelas', 'tahun_ajaran_id'],
                'kelas_nama_tahun_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
