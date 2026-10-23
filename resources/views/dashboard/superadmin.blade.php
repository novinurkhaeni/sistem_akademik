<x-layout title="Dashboard Superadmin">
    <div class="mb-4">
        <h3 class="fw-bold">Dashboard Superadmin</h3>
        <p class="text-secondary">
            Selamat datang, {{ $user->username }}.
            Kelola data akademik melalui menu aplikasi.
        </p>
    </div>

    <div class="row g-3">
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
    </div>

</x-layout>
