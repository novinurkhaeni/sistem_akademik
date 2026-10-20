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
        // Daftar mata pelajaran yang akan digunakan sebagai
        // data dummy untuk tabel mapel.
        //
        // Setiap mata pelajaran memiliki nama dan kelompok
        // yang disimpan sebagai satu pasangan agar tidak tertukar.
        $mapel = fake()->randomElement([
            // Kelompok Umum
            [
                'nama' => 'Pendidikan Agama dan Budi Pekerti',
                'kelompok' => 'Umum',
            ],
            [
                'nama' => 'Pendidikan Pancasila',
                'kelompok' => 'Umum',
            ],
            [
                'nama' => 'Bahasa Indonesia',
                'kelompok' => 'Umum',
            ],
            [
                'nama' => 'Matematika',
                'kelompok' => 'Umum',
            ],
            [
                'nama' => 'Bahasa Inggris',
                'kelompok' => 'Umum',
            ],
            [
                'nama' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan',
                'kelompok' => 'Umum',
            ],
            [
                'nama' => 'Sejarah',
                'kelompok' => 'Umum',
            ],
            [
                'nama' => 'Seni Budaya',
                'kelompok' => 'Umum',
            ],
            [
                'nama' => 'Informatika',
                'kelompok' => 'Umum',
            ],

            // Kelompok Kejuruan
            [
                'nama' => 'Projek Kreatif dan Kewirausahaan',
                'kelompok' => 'Kejuruan',
            ],
            [
                'nama' => 'Dasar-Dasar Keahlian',
                'kelompok' => 'Kejuruan',
            ],
            [
                'nama' => 'Konsentrasi Keahlian',
                'kelompok' => 'Kejuruan',
            ],
            [
                'nama' => 'Praktik Kerja Lapangan',
                'kelompok' => 'Kejuruan',
            ],
            [
                'nama' => 'Koding dan Kecerdasan Artifisial',
                'kelompok' => 'Kejuruan',
            ],
            [
                'nama' => 'Pemrograman Web',
                'kelompok' => 'Kejuruan',
            ],
            [
                'nama' => 'Basis Data',
                'kelompok' => 'Kejuruan',
            ],
            [
                'nama' => 'Pemrograman Berbasis Teks, Grafis, dan Multimedia',
                'kelompok' => 'Kejuruan',
            ],
            [
                'nama' => 'Pemrograman Perangkat Bergerak',
                'kelompok' => 'Kejuruan',
            ],

            // Kelompok Muatan Lokal
            [
                'nama' => 'Bahasa Jawa',
                'kelompok' => 'Muatan Lokal',
            ],
        ]);

        return [
            // Membuat kode mata pelajaran secara unik.
            // Contoh: MP001, MP002, MP003
            'kode_mapel' => strtoupper(
                fake()->unique()->bothify('MP###')
            ),

            // Menyimpan nama mata pelajaran dari data yang dipilih
            'nama_mapel' => $mapel['nama'],

            // Menyimpan kelompok sesuai dengan mata pelajaran
            'kelompok' => $mapel['kelompok'],

            // Membuat deskripsi otomatis berdasarkan nama mata pelajaran
            'deskripsi' => 'Mata pelajaran ' . $mapel['nama'],

            // Mata pelajaran dibuat dalam kondisi aktif
            'is_active' => true,
        ];
    }
}
