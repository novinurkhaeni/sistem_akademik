<?php

namespace Database\Seeders;

use App\Models\JenisPenilaian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat 5 data jenis penilaian menggunakan JenisPenilaianFactory
        JenisPenilaian::factory()->count(5)->create();
    }
}
