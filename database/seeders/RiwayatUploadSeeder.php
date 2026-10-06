<?php

namespace Database\Seeders;

use App\Models\RiwayatUpload;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RiwayatUploadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RiwayatUpload::factory()->count(10)->create();
    }
}
