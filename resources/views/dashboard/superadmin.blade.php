<x-layout title="Dashboard Superadmin">
    <div class="mb-4">
        <h3 class="fw-bold">Dashboard Superadmin</h3>
        <p class="text-secondary">
            Selamat datang, {{ $user->username }}.
            Kelola data akademik melalui menu aplikasi.
        </p>
    </div>

    {{-- <div class="row g-3">
        @php
            $menus = [['Siswa', 'superadmin.siswa.index']];
        @endphp

        @foreach ($menus as $menu)
            <div class="col-md-6 col-xl-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $menu[0] }}</h5>
                        <p class="text-secondary">
                            Kelola data {{ strtolower($menu[0]) }}.
                        </p>
                        <a href="{{ route($menu[1]) }}" class="btn btn-primary btn-sm">
                            Buka Data
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div> --}}

    {{-- menu dashboard --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">

            {{-- Header Menu --}}
            <div class="mb-4">
                <h5 class="fw-bold mb-1">
                    Menu Pengelolaan
                </h5>
                <p class="text-secondary small mb-0">
                    Pilih menu untuk mengakses fitur aplikasi.
                </p>
            </div>

            {{-- Daftar Card Menu --}}
            <div class="row g-3">

                @forelse ($menus as $menu)
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">

                        <div class="card h-100 border shadow-sm menu-card">

                            <div class="card-body p-3 d-flex flex-column">

                                {{-- Icon Menu --}}
                                <div class="mb-3">
                                    <div
                                        class="menu-icon bg-{{ $menu['warna'] }} bg-opacity-10 text-{{ $menu['warna'] }}">
                                        <i class="bi {{ $menu['icon'] }}"></i>
                                    </div>
                                </div>

                                {{-- Judul Menu --}}
                                <h6 class="fw-bold mb-2">
                                    {{ $menu['judul'] }}
                                </h6>

                                {{-- Deskripsi --}}
                                <p class="text-secondary small mb-3">
                                    {{ $menu['deskripsi'] }}
                                </p>

                                {{-- Tombol Menu --}}
                                <div class="mt-auto">
                                    <a href="{{ route($menu['route']) }}"
                                        class="btn btn-outline-{{ $menu['warna'] }} btn-sm w-100">
                                        Buka Menu
                                        <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>

                @empty

                    <div class="col-12">
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Belum ada menu yang tersedia untuk akun Anda.
                        </div>
                    </div>
                @endforelse

            </div>
        </div>
    </div>

    {{-- STATISTIKA --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3 mb-4">

                <!-- Total Siswa -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-secondary mb-1">Total Siswa</p>
                                <h3 class="fw-bold mb-0">{{ $statistik['totalSiswa'] }}</h3>
                                <small class="text-secondary">Data seluruh siswa</small>
                            </div>
                            <div class="rounded-3 p-3 bg-primary bg-opacity-10">
                                <i class="bi bi-mortarboard-fill fs-2 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Guru -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-secondary mb-1">Total Guru</p>
                                <h3 class="fw-bold mb-0">{{ $statistik['totalGuru'] }}</h3>
                                <small class="text-secondary">Data seluruh guru</small>
                            </div>
                            <div class="rounded-3 p-3 bg-success bg-opacity-10">
                                <i class="bi bi-person-workspace fs-2 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Karyawan -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-secondary mb-1">Total Karyawan</p>
                                <h3 class="fw-bold mb-0">{{ $statistik['totalKaryawan'] }}</h3>
                                <small class="text-secondary">Data seluruh karyawan</small>
                            </div>
                            <div class="rounded-3 p-3 bg-warning bg-opacity-10">
                                <i class="bi bi-people-fill fs-2 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Mata Pelajaran -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-secondary mb-1">Mata Pelajaran</p>
                                <h3 class="fw-bold mb-0">{{ $statistik['totalMapel'] }}</h3>
                                <small class="text-secondary">Data seluruh mata pelajaran</small>
                            </div>
                            <div class="rounded-3 p-3 bg-info bg-opacity-10">
                                <i class="bi bi-book-half fs-2 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Kelas -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-secondary mb-1">Total Kelas</p>
                                <h3 class="fw-bold mb-0">{{ $statistik['totalKelas'] }}</h3>
                                <small class="text-secondary">Data seluruh kelas</small>
                            </div>
                            <div class="rounded-3 p-3 bg-danger bg-opacity-10">
                                <i class="bi bi-building fs-2 text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total User Aktif -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-secondary mb-1">Akun Pengguna Aktif</p>
                                <h3 class="fw-bold mb-0">{{ $statistik['totalUserAktif'] }}</h3>
                                <small class="text-secondary">Akun dengan status aktif</small>
                            </div>
                            <div class="rounded-3 p-3 bg-success bg-opacity-10">
                                <i class="bi bi-person-check-fill fs-2 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{-- TAHUN AJARAN --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Tahun Ajaran Aktif</h5>

                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    Aktif
                </span>
            </div>

            <!-- Tahun Ajaran -->
            <h2 class="fw-bold text-primary mb-1">
                {{ $tahun_ajaran->nama }}
            </h2>

            <hr class="text-secondary opacity-25">

            <!-- Status Akademik -->
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-secondary">
                    Status akademik
                </span>

                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                    Berjalan
                </span>
            </div>

        </div>
    </div>

    {{-- DIAGRAM SISWA --}}

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1">Grafik Jumlah Siswa</h5>
                    <p class="text-secondary mb-0">
                        Distribusi siswa berdasarkan jurusan
                    </p>
                </div>

                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                    Semua Jurusan
                </span>
            </div>

            <div style="position: relative; height: 350px;">
                <canvas id="grafikSiswa"></canvas>
            </div>

        </div>
    </div>

    {{-- CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('grafikSiswa');

        new Chart(ctx, {
            type: 'bar',

            data: {
                labels: @json($diagram_siswa->keys()),

                datasets: [{
                    label: 'Jumlah Siswa',
                    data: @json($diagram_siswa->values()),

                    backgroundColor: [
                        'rgba(13, 110, 253, 0.75)',
                        'rgba(25, 135, 84, 0.75)',
                        'rgba(255, 193, 7, 0.75)'
                    ],

                    borderRadius: 6,
                    borderSkipped: false,
                    barThickness: 45
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    },

                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' siswa';
                            }
                        }
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        title: {
                            display: true,
                            text: 'Jumlah Siswa'
                        }
                    },

                    x: {
                        title: {
                            display: true,
                            text: 'Jurusan'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>

</x-layout>
