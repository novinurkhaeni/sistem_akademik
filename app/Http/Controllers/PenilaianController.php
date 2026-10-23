<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\DataMengajar;
use App\Models\JenisPenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    private function authorizePenilaian(Penilaian $penilaian): void
    {
        $user = Auth::user();

        if ($user->role?->nama_role === 'guru') {
            abort_unless(
                $user->guru_id &&
                $penilaian->dataMengajar?->guru_id === $user->guru_id,
                403
            );
        } elseif ($user->role?->nama_role !== 'superadmin') {
            abort(403);
        }
    }

    public function index()
    {
        $user = Auth::user();

        $query = Penilaian::with([
            'dataMengajar.guru',
            'dataMengajar.mapel',
            'dataMengajar.kelas',
            'jenisPenilaian',
        ]);

        if ($user->role?->nama_role === 'guru') {
            abort_if(! $user->guru_id, 403, 'Akun belum terhubung dengan profil guru.');

            $query->whereHas('dataMengajar', function ($q) use ($user) {
                $q->where('guru_id', $user->guru_id);
            });
        }

        $penilaian = $query->latest()->paginate(10);

        return view('penilaian.index', compact('penilaian'));
    }

    public function create()
    {
        $user = Auth::user();

        $query = DataMengajar::with(['mapel', 'kelas', 'tahunAjaran']);

        if ($user->role?->nama_role === 'guru') {
            abort_if(! $user->guru_id, 403);

            $query->where('guru_id', $user->guru_id);
        } else {
            abort_unless($user->role?->nama_role === 'superadmin', 403);
        }

        $dataMengajar = $query->get();
        $jenisPenilaian = JenisPenilaian::orderBy('nama')->get();

        return view('penilaian.create', compact('dataMengajar', 'jenisPenilaian'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'data_mengajar_id' => ['required', 'exists:data_mengajar,id'],
            'jenis_penilaian_id' => ['required', 'exists:jenis_penilaian,id'],
            'nama_penilaian' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'in:ganjil,genap'],
            'materi' => ['nullable', 'string', 'max:255'],
            'tanggal' => ['nullable', 'date'],
            'bobot' => ['required', 'numeric', 'min:0', 'max:100'],
            'is_published' => ['required', 'boolean'],
        ]);

        $this->authorizeDataMengajar($data['data_mengajar_id']);

        Penilaian::create($data);

        return $this->redirectIndex()
            ->with('success', 'Penilaian berhasil dibuat.');
    }

    public function show(Penilaian $penilaian)
    {
        $this->authorizePenilaian($penilaian);

        $penilaian->load(['dataMengajar', 'jenisPenilaian', 'nilai.siswa']);

        return view('penilaian.show', compact('penilaian'));
    }

    public function edit(Penilaian $penilaian)
    {
        $this->authorizePenilaian($penilaian);

        $user = Auth::user();
        $query = DataMengajar::with(['mapel', 'kelas', 'tahunAjaran']);

        if ($user->role?->nama_role === 'guru') {
            $query->where('guru_id', $user->guru_id);
        }

        $dataMengajar = $query->get();
        $jenisPenilaian = JenisPenilaian::orderBy('nama')->get();

        return view('penilaian.edit', compact(
            'penilaian', 'dataMengajar', 'jenisPenilaian'
        ));
    }

    public function update(Request $request, Penilaian $penilaian)
    {
        $this->authorizePenilaian($penilaian);

        $data = $request->validate([
            'data_mengajar_id' => ['required', 'exists:data_mengajar,id'],
            'jenis_penilaian_id' => ['required', 'exists:jenis_penilaian,id'],
            'nama_penilaian' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'in:ganjil,genap'],
            'materi' => ['nullable', 'string', 'max:255'],
            'tanggal' => ['nullable', 'date'],
            'bobot' => ['required', 'numeric', 'min:0', 'max:100'],
            'is_published' => ['required', 'boolean'],
        ]);

        $this->authorizeDataMengajar($data['data_mengajar_id']);
        $penilaian->update($data);

        return $this->redirectIndex()
            ->with('success', 'Penilaian berhasil diperbarui.');
    }

    public function destroy(Penilaian $penilaian)
    {
        $this->authorizePenilaian($penilaian);

        try {
            $penilaian->delete();

            return $this->redirectIndex()
                ->with('success', 'Penilaian berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->redirectIndex()
                ->with('error', 'Penilaian masih memiliki data nilai.');
        }
    }

    private function authorizeDataMengajar(int $id): void
    {
        $user = Auth::user();
        $dataMengajar = DataMengajar::findOrFail($id);

        if ($user->role?->nama_role === 'guru') {
            abort_unless(
                $user->guru_id && $dataMengajar->guru_id === $user->guru_id,
                403
            );
        } else {
            abort_unless($user->role?->nama_role === 'superadmin', 403);
        }
    }

    private function redirectIndex()
    {
        return redirect()->route(
            Auth::user()->role?->nama_role === 'guru'
                ? 'guru.penilaian.index'
                : 'superadmin.penilaian.index'
        );
    }
}
