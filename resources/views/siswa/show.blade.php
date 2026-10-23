<x-layout title="Detail Siswa">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Detail Siswa</h3>

        <div class="d-flex gap-2">
            <a href="{{ route('superadmin.siswa.edit', $siswa) }}"
               class="btn btn-warning">Edit</a>
            <a href="{{ route('superadmin.siswa.index') }}"
               class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-3 text-center">
                    @if ($siswa->photo)
                        <img src="{{ asset('storage/' . $siswa->photo) }}"
                             alt="Foto {{ $siswa->nama }}"
                             class="img-fluid rounded mb-3"
                             style="max-height:220px">
                    @else
                        <div class="bg-light rounded p-5 text-secondary">
                            Foto belum tersedia
                        </div>
                    @endif
                </div>

                <div class="col-md-9">
                    <h4 class="fw-bold">{{ $siswa->nama }}</h4>
                    <hr>

                    <dl class="row">
                        <dt class="col-sm-4">NIS</dt>
                        <dd class="col-sm-8">{{ $siswa->nis }}</dd>

                        <dt class="col-sm-4">NISN</dt>
                        <dd class="col-sm-8">{{ $siswa->nisn ?? '-' }}</dd>

                        <dt class="col-sm-4">Jenis Kelamin</dt>
                        <dd class="col-sm-8">
                            @switch($siswa->jenis_kelamin)
                                @case('L') Laki-laki @break
                                @case('P') Perempuan @break
                                @default -
                            @endswitch
                        </dd>

                        <dt class="col-sm-4">Tanggal Lahir</dt>
                        <dd class="col-sm-8">
                            {{ $siswa->tanggal_lahir
                                ? \Illuminate\Support\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y')
                                : '-' }}
                        </dd>

                        <dt class="col-sm-4">Kelas</dt>
                        <dd class="col-sm-8">
                            {{ $siswa->kelas?->nama_kelas ?? '-' }}
                        </dd>

                        <dt class="col-sm-4">Alamat</dt>
                        <dd class="col-sm-8">{{ $siswa->alamat ?? '-' }}</dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">{{ ucfirst($siswa->status ?? '-') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-layout>