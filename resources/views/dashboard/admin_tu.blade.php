<x-layout title="Dashboard Admin TU">
    <h3 class="fw-bold">Dashboard Admin TU</h3>
    <p class="text-secondary">
        Selamat datang, {{ $user->username }}.
    </p>

    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h5>Administrasi Sekolah</h5>
            <p class="text-secondary mb-0">
                Halaman ini dapat dikembangkan untuk mengelola
                data karyawan dan administrasi sesuai hak akses.
            </p>
        </div>
    </div>

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
</x-layout>
