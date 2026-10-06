<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAjaran = TahunAjaran::where('is_active', true)->first();

        if (!$tahunAjaran) {
            $tahunAjaran = TahunAjaran::firstOrFail();
        }

        $daftarKelas = [
            ['nama_kelas' => 'X PPLG 1', 'tingkat' => 10, 'jurusan' => 'PPLG'],
            ['nama_kelas' => 'X PPLG 2', 'tingkat' => 10, 'jurusan' => 'PPLG'],
            ['nama_kelas' => 'XI PPLG 1', 'tingkat' => 11, 'jurusan' => 'PPLG'],
            ['nama_kelas' => 'XI PPLG 2', 'tingkat' => 11, 'jurusan' => 'PPLG'],
            ['nama_kelas' => 'XII PPLG 1', 'tingkat' => 12, 'jurusan' => 'PPLG'],
            ['nama_kelas' => 'XII PPLG 2', 'tingkat' => 12, 'jurusan' => 'PPLG'],
        ];

        foreach ($daftarKelas as $kelas) {
            Kelas::updateOrCreate(
                [
                    'nama_kelas' => $kelas['nama_kelas'],
                    'tahun_ajaran_id' => $tahunAjaran->id,
                ],
                array_merge($kelas, [
                    'tahun_ajaran_id' => $tahunAjaran->id,
                ])
            );
        }
    }
}