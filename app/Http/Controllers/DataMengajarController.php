<?php

namespace App\Http\Controllers;

use App\Models\DataMengajar;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DataMengajarController extends Controller
{
    public function index()
    {
        $dataMengajar = DataMengajar::with([
            'guru', 'mapel', 'kelas', 'tahunAjaran',
        ])->latest()->paginate(10);

        return view('data_mengajar.index', compact('dataMengajar'));
    }

    public function create()
    {
        $guru = Guru::orderBy('nama')->get();
        $mapel = Mapel::where('is_active', true)->orderBy('nama_mapel')->get();
        $kelas = Kelas::with('tahunAjaran')->orderBy('nama_kelas')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tanggal_mulai')->get();

        return view('data_mengajar.create', compact(
            'guru', 'mapel', 'kelas', 'tahunAjaran'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'guru_id' => ['required', 'exists:guru,id'],
            'mapel_id' => ['required', 'exists:mapel,id'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajaran,id'],
            'jumlah_jam' => ['required', 'integer', 'min:1', 'max:60'],
        ]);

        $exists = DataMengajar::where('guru_id', $data['guru_id'])
            ->where('mapel_id', $data['mapel_id'])
            ->where('kelas_id', $data['kelas_id'])
            ->where('tahun_ajaran_id', $data['tahun_ajaran_id'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'mapel_id' => 'Penugasan guru, mapel, kelas, dan tahun ajaran tersebut sudah ada.',
            ]);
        }

        DataMengajar::create($data);

        return redirect()->route('superadmin.data-mengajar.index')
            ->with('success', 'Data mengajar berhasil ditambahkan.');
    }

    public function show(DataMengajar $dataMengajar)
    {
        $dataMengajar->load([
            'guru', 'mapel', 'kelas', 'tahunAjaran', 'jadwal', 'penilaian',
        ]);

        return view('data_mengajar.show', compact('dataMengajar'));
    }

    public function edit(DataMengajar $dataMengajar)
    {
        $guru = Guru::orderBy('nama')->get();
        $mapel = Mapel::orderBy('nama_mapel')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tanggal_mulai')->get();

        return view('data_mengajar.edit', compact(
            'dataMengajar', 'guru', 'mapel', 'kelas', 'tahunAjaran'
        ));
    }

    public function update(Request $request, DataMengajar $dataMengajar)
    {
        $data = $request->validate([
            'guru_id' => ['required', 'exists:guru,id'],
            'mapel_id' => ['required', 'exists:mapel,id'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajaran,id'],
            'jumlah_jam' => ['required', 'integer', 'min:1', 'max:60'],
        ]);

        $exists = DataMengajar::where('guru_id', $data['guru_id'])
            ->where('mapel_id', $data['mapel_id'])
            ->where('kelas_id', $data['kelas_id'])
            ->where('tahun_ajaran_id', $data['tahun_ajaran_id'])
            ->where('id', '!=', $dataMengajar->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'mapel_id' => 'Penugasan tersebut sudah ada.',
            ]);
        }

        $dataMengajar->update($data);

        return redirect()->route('superadmin.data-mengajar.index')
            ->with('success', 'Data mengajar berhasil diperbarui.');
    }

    public function destroy(DataMengajar $dataMengajar)
    {
        try {
            $dataMengajar->delete();

            return redirect()->route('superadmin.data-mengajar.index')
                ->with('success', 'Data mengajar berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('superadmin.data-mengajar.index')
                ->with('error', 'Data mengajar masih memiliki jadwal atau penilaian.');
        }
    }

    // Halaman guru hanya menampilkan penugasan milik guru yang login.
    public function indexGuru(Request $request)
    {
        abort_unless($request->user()->role?->nama_role === 'guru', 403);

        $guruId = $request->user()->guru_id;

        abort_if(! $guruId, 403, 'Akun belum terhubung dengan profil guru.');

        $dataMengajar = DataMengajar::with([
            'mapel', 'kelas', 'tahunAjaran',
        ])->where('guru_id', $guruId)
          ->latest()
          ->paginate(10);

        return view('guru.data_mengajar', compact('dataMengajar'));
    }
}
