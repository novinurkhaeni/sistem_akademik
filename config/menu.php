
<?php

return [

    'kelola_siswa' => [
        'judul' => 'Data Siswa',
        'icon' => 'bi-mortarboard-fill',
        'warna' => 'primary',
        'routes' => [
            'superadmin' => 'superadmin.siswa.index',
            'admin_tu'   => 'admin-tu.siswa.index',
        ],
    ],

    'kelola_guru' => [
        'judul' => 'Data Guru',
        'icon' => 'bi-person-workspace',
        'warna' => 'success',
        'routes' => [
            'superadmin' => 'superadmin.guru.index',
            'admin_tu'   => 'admin-tu.guru.index',
        ],
    ],

    'kelola_karyawan' => [
        'judul' => 'Data Karyawan',
        'icon' => 'bi-people-fill',
        'warna' => 'warning',
        'routes' => [
            'superadmin' => 'superadmin.karyawan.index',
            'admin_tu'   => 'admin-tu.karyawan.index',
        ],
    ],

    'kelola_mapel' => [
        'judul' => 'Mata Pelajaran',
        'icon' => 'bi-book-half',
        'warna' => 'info',
        'routes' => [
            'superadmin' => 'superadmin.mapel.index',
        ],
    ],

    'kelola_kelas' => [
        'judul' => 'Data Kelas',
        'icon' => 'bi-building',
        'warna' => 'danger',
        'routes' => [
            'superadmin' => 'superadmin.kelas.index',
        ],
    ],

    'kelola_mengajar' => [
        'judul' => 'Data Mengajar',
        'icon' => 'bi-journal-text',
        'warna' => 'primary',
        'routes' => [
            'superadmin' => 'superadmin.data-mengajar.index',
            'guru'       => 'guru.data-mengajar.index',
        ],
    ],

    'kelola_jadwal' => [
        'judul' => 'Jadwal Pelajaran',
        'icon' => 'bi-calendar-week',
        'warna' => 'success',
        'routes' => [
            'superadmin' => 'superadmin.jadwal.index',
        ],
    ],

    'kelola_penilaian' => [
        'judul' => 'Penilaian',
        'icon' => 'bi-clipboard-check',
        'warna' => 'warning',
        'routes' => [
            'superadmin' => 'superadmin.penilaian.index',
            'guru'       => 'guru.penilaian.index',
        ],
    ],

    'lihat_nilai' => [
        'judul' => 'Lihat Nilai',
        'icon' => 'bi-card-checklist',
        'warna' => 'info',
        'routes' => [
            'superadmin' => 'superadmin.nilai.index',
            'guru' => 'guru.nilai.index',
            'siswa' => 'siswa.nilai.index',
        ],
    ],

    'input_nilai' => [
        'judul' => 'Input Nilai',
        'icon' => 'bi-pencil-square',
        'warna' => 'success',
        'routes' => [
            'superadmin' => 'superadmin.nilai.index',
            'guru'       => 'guru.nilai.index',
        ],
    ],

    'kelola_user' => [
        'judul' => 'Kelola Pengguna',
        'icon' => 'bi-person-gear',
        'warna' => 'primary',
        'routes' => [
            'superadmin' => 'superadmin.users.index',
        ],
    ],

    'lihat_riwayat_upload' => [
        'judul' => 'Riwayat Upload',
        'icon' => 'bi-clock-history',
        'warna' => 'secondary',
        'routes' => [
            'superadmin' => 'superadmin.riwayat-upload.index',
            'admin_tu'   => 'admin-tu.riwayat-upload.index',
        ],
    ],

    'lihat_jadwal' => [
        'judul' => 'Jadwal Pelajaran',
        'icon' => 'bi-calendar-week',
        'warna' => 'success',
        'routes' => [
            'guru'  => 'guru.data-mengajar.index',
            'siswa' => 'siswa.data-mengajar.index',
        ],
    ],

];
