<x-layout title="Data Siswa">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Data Siswa</h3>
            <p class="text-secondary mb-0">
                Daftar siswa yang terdaftar dalam sistem.
            </p>
        </div>

        <a href="{{ route('superadmin.siswa.create') }}" class="btn btn-primary">
            + Tambah Siswa
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('superadmin.siswa.index') }}" class="row g-2 mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau NIS..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary" type="submit">
                        Cari
                    </button>
                    <a href="{{ route('superadmin.siswa.index') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Foto</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $item)
                            <tr>
                                <td>
                                    {{ $siswa->firstItem() + $loop->index }}
                                </td>
                                <td>
                                    @if ($item->photo)
                                        <img src="{{ asset('storage/' . $item->photo) }}" alt="Foto {{ $item->nama }}"
                                            width="45" height="45" class="rounded-circle object-fit-cover">
                                    @else
                                        <div class="rounded-circle bg-light border d-flex
                                                    align-items-center justify-content-center"
                                            style="width:45px;height:45px">
                                            <span class="text-secondary">
                                                {{ strtoupper(substr($item->nama, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $item->nis }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->kelas?->nama_kelas ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge {{ $item->status === 'aktif' ? 'text-bg-success' : 'text-bg-secondary' }}">
                                        {{ ucfirst($item->status ?? 'Tidak diketahui') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('superadmin.siswa.show', $item) }}"
                                            class="btn btn-info btn-sm text-white">
                                            Detail
                                        </a>

                                        <a href="{{ route('superadmin.siswa.edit', $item) }}"
                                            class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#hapusSiswa{{ $item->id }}">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="hapusSiswa{{ $item->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah kamu yakin ingin menghapus data
                                            siswa <strong>{{ $item->nama }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Batal
                                            </button>

                                            <form action="{{ route('superadmin.siswa.destroy', $item) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    Ya, Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-secondary">
                                    Belum ada data siswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $siswa->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

</x-layout>
