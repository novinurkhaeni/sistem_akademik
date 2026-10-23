<x-layout title="Tambah Siswa">
    <h3 class="fw-bold mb-4">Edit Data Siswa</h3>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('superadmin.siswa.update', $siswa) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('siswa._form')

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('superadmin.siswa.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-layout>
