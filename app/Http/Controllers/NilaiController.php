<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Penilaian;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role?->nama_role;

        $query = Nilai::with([
            'siswa',
            'penilaian.dataMengajar.mapel',
            'penilaian.dataMengajar.kelas',
            'penilaian.jenisPenilaian',
        ]);

        if ($role === 'siswa') {
            abort_if(! $user->siswa_id, 403, 'Akun belum terhubung dengan profil siswa.');

            $query->where('siswa_id', $user->siswa_id)
                ->whereHas('penilaian', function ($q) {
                    $q->where('is_published', true);
                });
        } elseif ($role === 'guru') {
            abort_if(! $user->guru_id, 403, 'Akun belum terhubung dengan profil guru.');

            $query->whereHas('penilaian.dataMengajar', function ($q) use ($user) {
                $q->where('guru_id', $user->guru_id);
            });
        } elseif ($role !== 'superadmin') {
            abort(403);
        }

        $nilai = $query->latest()->paginate(15);

        return view('nilai.index', compact('nilai'));
    }

    public function create()
    {
        $this->authorizeGuruOrSuperadmin();

        $penilaianQuery = Penilaian::with([
            'dataMengajar.mapel',
            'dataMengajar.kelas',
        ]);

        if (Auth::user()->role?->nama_role === 'guru') {
            $penilaianQuery->whereHas('dataMengajar', function ($q) {
                $q->where('guru_id', Auth::user()->guru_id);
            });
        }

        $penilaian = $penilaianQuery->get();

        $siswa = Siswa::orderBy('nama')->get();

        return view('nilai.create', compact('penilaian', 'siswa'));
    }

    public function store(Request $request)
    {
        $this->authorizeGuruOrSuperadmin();

        $data = $request->validate([
            'penilaian_id' => ['required', 'exists:penilaian,id'],
            'siswa_id' => ['required', 'exists:siswa,id'],
            'nilai' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $penilaian = Penilaian::with('dataMengajar')->findOrFail($data['penilaian_id']);

        $this->authorizePenilaian($penilaian);

        $siswa = Siswa::findOrFail($data['siswa_id']);

        if ($siswa->kelas_id !== $penilaian->dataMengajar->kelas_id) {
            return back()->withInput()->withErrors([
                'siswa_id' => 'Siswa tidak terdaftar pada kelas penilaian ini.',
            ]);
        }

        $alreadyExists = Nilai::where('penilaian_id', $data['penilaian_id'])
            ->where('siswa_id', $data['siswa_id'])
            ->exists();

        if ($alreadyExists) {
            return back()->withInput()->withErrors([
                'siswa_id' => 'Nilai siswa untuk penilaian ini sudah ada. Gunakan fitur edit.',
            ]);
        }

        Nilai::create($data);

        return $this->redirectIndex()
            ->with('success', 'Nilai berhasil disimpan.');
    }

    public function show(Nilai $nilai)
    {
        $this->authorizeNilai($nilai);

        $nilai->load(['siswa', 'penilaian.dataMengajar', 'penilaian.jenisPenilaian']);

        return view('nilai.show', compact('nilai'));
    }

    public function edit(Nilai $nilai)
    {
        $this->authorizeGuruOrSuperadmin();
        $this->authorizeNilai($nilai);

        return view('nilai.edit', compact('nilai'));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $this->authorizeGuruOrSuperadmin();
        $this->authorizeNilai($nilai);

        $data = $request->validate([
            'nilai' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $nilai->update($data);

        return $this->redirectIndex()
            ->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai)
    {
        $this->authorizeGuruOrSuperadmin();
        $this->authorizeNilai($nilai);

        $nilai->delete();

        return $this->redirectIndex()
            ->with('success', 'Nilai berhasil dihapus.');
    }

    private function authorizeGuruOrSuperadmin(): void
    {
        abort_unless(
            in_array(Auth::user()->role?->nama_role, ['guru', 'superadmin'], true),
            403
        );
    }

    private function authorizePenilaian(Penilaian $penilaian): void
    {
        $user = Auth::user();

        if ($user->role?->nama_role === 'guru') {
            abort_unless(
                $user->guru_id &&
                $penilaian->dataMengajar?->guru_id === $user->guru_id,
                403
            );
        } else {
            abort_unless($user->role?->nama_role === 'superadmin', 403);
        }
    }

    private function authorizeNilai(Nilai $nilai): void
    {
        $user = Auth::user();
        $role = $user->role?->nama_role;

        if ($role === 'siswa') {
            abort_unless(
                $user->siswa_id === $nilai->siswa_id &&
                $nilai->penilaian?->is_published,
                403
            );
        } elseif ($role === 'guru') {
            abort_unless(
                $user->guru_id &&
                $nilai->penilaian?->dataMengajar?->guru_id === $user->guru_id,
                403
            );
        } elseif ($role !== 'superadmin') {
            abort(403);
        }
    }

    private function redirectIndex()
    {
        $route = match (Auth::user()->role?->nama_role) {
            'guru' => 'guru.nilai.index',
            'siswa' => 'siswa.nilai.index',
            default => 'superadmin.nilai.index',
        };

        return redirect()->route($route);
    }
}
