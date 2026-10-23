<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $title ?? 'SIAKAD SMK Ma’arif 9 Kebumen' }}</title>

    {{-- Bootstrap CSS Online --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons Online --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f5f7fb;
            font-family: Arial, sans-serif;
        }

        .navbar-brand {
            font-weight: 700;
        }

        .main-content {
            min-height: calc(100vh - 140px);
            padding-top: 24px;
            padding-bottom: 32px;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .table th {
            white-space: nowrap;
        }

        footer {
            font-size: 14px;
        }
    </style>
</head>

<body>

    {{-- Navigasi --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid px-lg-4">

            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-mortarboard-fill me-2"></i>
                SIAKAD
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
                aria-controls="navbarMenu" aria-expanded="false" aria-label="Buka navigasi">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        @if (auth()->user()->role?->nama_role === 'superadmin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('superadmin.siswa.index') }}">
                                    Siswa
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('superadmin.guru.index') }}">
                                    Guru
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('superadmin.karyawan.index') }}">
                                    Karyawan
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('superadmin.mapel.index') }}">
                                    Mata Pelajaran
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('superadmin.kelas.index') }}">
                                    Kelas
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('superadmin.data-mengajar.index') }}">
                                    Data Mengajar
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->role?->nama_role === 'admin_tu')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin-tu.karyawan.index') }}">
                                    Karyawan
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->role?->nama_role === 'guru')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('guru.data-mengajar.index') }}">
                                    Data Mengajar
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('guru.penilaian.index') }}">
                                    Penilaian
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('guru.nilai.index') }}">
                                    Nilai
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->role?->nama_role === 'siswa')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('siswa.nilai.index') }}">
                                    Nilai Saya
                                </a>
                            </li>
                        @endif
                    @endauth

                </ul>

                <div class="d-flex align-items-center gap-3 text-white">
                    @auth
                        <span class="small">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ auth()->user()->username }}
                        </span>

                        <form action="{{ route('auth.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-box-arrow-right me-1"></i>
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('auth.login') }}" class="btn btn-outline-light btn-sm">
                            Login
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    {{-- Konten halaman --}}
    <main class="container-fluid px-lg-4 main-content">

        {{-- Notifikasi berhasil --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Notifikasi gagal --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger mt-3" role="alert">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ $slot }}

    </main>

    {{-- Footer --}}
    <footer class="bg-white border-top py-3">
        <div class="container-fluid px-lg-4 text-center text-muted">
            &copy; {{ date('Y') }} SIAKAD SMK Ma’arif 9 Kebumen
        </div>
    </footer>

    {{-- Bootstrap JS Online --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
