<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('tahunAjaran')->latest()->paginate(10);

        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $tahunAjaran = TahunAjaran::orderByDesc('tanggal_mulai')->get();

        return view('kelas.create', compact('tahunAjaran'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kelas' => [
                'required', 'string', 'max:100',
                Rule::unique('kelas', 'nama_kelas')
                    ->where(fn ($q) => $q->where('tahun_ajaran_id', $request->tahun_ajaran_id)),
            ],
            'tingkat' => ['required', 'string', 'max:20'],
            'jurusan' => ['nullable', 'string', 'max:100'],
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajaran,id'],
        ]);

        Kelas::create($data);

        return redirect()->route('superadmin.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show(Kelas $kelas)
    {
        $kelas->load(['tahunAjaran', 'siswa']);

        return view('kelas.show', compact('kelas'));
    }

    public function edit(Kelas $kelas)
    {
        $tahunAjaran = TahunAjaran::orderByDesc('tanggal_mulai')->get();

        return view('kelas.edit', compact('kelas', 'tahunAjaran'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $data = $request->validate([
            'nama_kelas' => [
                'required', 'string', 'max:100',
                Rule::unique('kelas', 'nama_kelas')
                    ->where(fn ($q) => $q->where('tahun_ajaran_id', $request->tahun_ajaran_id))
                    ->ignore($kelas->id),
            ],
            'tingkat' => ['required', 'string', 'max:20'],
            'jurusan' => ['nullable', 'string', 'max:100'],
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajaran,id'],
        ]);

        $kelas->update($data);

        return redirect()->route('superadmin.kelas.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        try {
            $kelas->delete();

            return redirect()->route('superadmin.kelas.index')
                ->with('success', 'Kelas berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('superadmin.kelas.index')
                ->with('error', 'Kelas masih memiliki siswa atau data mengajar.');
        }
    }
}
