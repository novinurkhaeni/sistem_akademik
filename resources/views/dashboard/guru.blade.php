<x-layout title="Dashboard Guru">
    <h3 class="fw-bold">Dashboard Guru</h3>
    <p class="text-secondary">
        Selamat datang, {{ $user->username }}.
    </p>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5>Aktivitas Pembelajaran</h5>
            <p class="text-secondary mb-0">
                Informasi kelas yang diajar, jadwal, penilaian,
                dan pengelolaan nilai akan ditampilkan di sini.
            </p>
        </div>
    </div>
</x-layout>
