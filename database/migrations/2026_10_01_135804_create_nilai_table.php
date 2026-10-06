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
