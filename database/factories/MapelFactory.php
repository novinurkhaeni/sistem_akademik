<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MapelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mapel = fake()->randomElement([
            ['nama' => 'Pendidikan Agama dan Budi Pekerti', 'kelompok' => 'Umum'],
            ['nama' => 'Pendidikan Pancasila', 'kelompok' => 'Umum'],
            ['nama' => 'Bahasa Indonesia', 'kelompok' => 'Umum'],
            ['nama' => 'Matematika', 'kelompok' => 'Umum'],
            ['nama' => 'Bahasa Inggris', 'kelompok' => 'Umum'],
            ['nama' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan', 'kelompok' => 'Umum'],
            ['nama' => 'Sejarah', 'kelompok' => 'Umum'],
            ['nama' => 'Seni Budaya', 'kelompok' => 'Umum'],
            ['nama' => 'Informatika', 'kelompok' => 'Umum'],
            ['nama' => 'Projek Kreatif dan Kewirausahaan', 'kelompok' => 'Kejuruan'],
            ['nama' => 'Dasar-Dasar Keahlian', 'kelompok' => 'Kejuruan'],
            ['nama' => 'Konsentrasi Keahlian', 'kelompok' => 'Kejuruan'],
            ['nama' => 'Praktik Kerja Lapangan', 'kelompok' => 'Kejuruan'],
            ['nama' => 'Koding dan Kecerdasan Artifisial', 'kelompok' => 'Kejuruan'],
            ['nama' => 'Pemrograman Web', 'kelompok' => 'Kejuruan'],
            ['nama' => 'Basis Data', 'kelompok' => 'Kejuruan'],
            ['nama' => 'Pemrograman Berbasis Teks, Grafis, dan Multimedia', 'kelompok' => 'Kejuruan'],
            ['nama' => 'Pemrograman Perangkat Bergerak', 'kelompok' => 'Kejuruan'],
            ['nama' => 'Bahasa Jawa', 'kelompok' => 'Muatan Lokal'],
        ]);

        return [
            'kode_mapel' => strtoupper(fake()->unique()->bothify('MP###')),
            'nama_mapel' => $mapel['nama'],
            'kelompok' => $mapel['kelompok'],
            'deskripsi' => 'Mata pelajaran ' . $mapel['nama'],
            'is_active' => true,
        ];
    }
}
