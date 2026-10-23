<x-layout title="Dashboard Siswa">
    <h3 class="fw-bold">Dashboard Siswa</h3>
    <p class="text-secondary">
        Selamat datang, {{ $user->username }}.
    </p>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5>Informasi Akademik</h5>
            <p class="text-secondary mb-0">
                Informasi kelas, jadwal pelajaran, dan nilai
                siswa dapat ditampilkan pada halaman ini.
            </p>
        </div>
    </div>
</x-layout>
