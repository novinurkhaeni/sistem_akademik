
<div class="row g-3">
    <div class="col-md-6">
        <label for="nis" class="form-label">NIS *</label>
        <input type="text" name="nis" id="nis" required
               class="form-control @error('nis') is-invalid @enderror"
               value="{{ old('nis', $siswa->nis ?? '') }}">
        @error('nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="nisn" class="form-label">NISN</label>
        <input type="text" name="nisn" id="nisn"
               class="form-control @error('nisn') is-invalid @enderror"
               value="{{ old('nisn', $siswa->nisn ?? '') }}">
        @error('nisn') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="nama" class="form-label">Nama Lengkap *</label>
        <input type="text" name="nama" id="nama" required
               class="form-control @error('nama') is-invalid @enderror"
               value="{{ old('nama', $siswa->nama ?? '') }}">
        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
            <option value="">-- Pilih --</option>
            <option value="L" @selected(old('jenis_kelamin', $siswa->jenis_kelamin ?? '') === 'L')>Laki-laki</option>
            <option value="P" @selected(old('jenis_kelamin', $siswa->jenis_kelamin ?? '') === 'P')>Perempuan</option>
        </select>
    </div>

    <div class="col-md-6">
        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
               class="form-control"
               value="{{ old('tanggal_lahir', isset($siswa) && $siswa->tanggal_lahir ? \Illuminate\Support\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '') }}">
    </div>

    <div class="col-md-6">
        <label for="kelas_id" class="form-label">Kelas</label>
        <select name="kelas_id" id="kelas_id" class="form-select">
            <option value="">-- Pilih Kelas --</option>
            @foreach ($kelas as $item)
                <option value="{{ $item->id }}"
                    @selected(old('kelas_id', $siswa->kelas_id ?? '') == $item->id)>
                    {{ $item->nama_kelas }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-12">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea name="alamat" id="alamat" rows="3"
                  class="form-control">{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label for="photo" class="form-label">Foto</label>
        @if (isset($siswa) && $siswa->photo)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $siswa->photo) }}"
                     alt="Foto {{ $siswa->nama }}"
                     width="90" class="rounded">
            </div>
        @endif
        <input type="file" name="photo" id="photo"
               class="form-control" accept=".jpg,.jpeg,.png,.webp">
        <div class="form-text">Kosongkan jika tidak ingin mengganti foto.</div>
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label">Status *</label>
        <select name="status" id="status" class="form-select" required>
            <option value="aktif" @selected(old('status', $siswa->status ?? 'aktif') === 'aktif')>Aktif</option>
            <option value="nonaktif" @selected(old('status', $siswa->status ?? '') === 'nonaktif')>Nonaktif</option>
        </select>
    </div>
</div>
