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
        Schema::create('data_mengajar', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guru_id')
                ->constrained('guru')
                ->restrictOnDelete();

            $table->foreignId('mapel_id')
                ->constrained('mapel')
                ->restrictOnDelete();

            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->restrictOnDelete();

            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajaran')
                ->restrictOnDelete();

            $table->unsignedTinyInteger('jumlah_jam')->default(0);
            $table->timestamps();

            $table->unique(
                ['guru_id', 'mapel_id', 'kelas_id', 'tahun_ajaran_id'],
                'data_mengajar_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_mengajar');
    }
};
