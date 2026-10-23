<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\DataMengajar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = Jadwal::with([
            'dataMengajar.guru',
            'dataMengajar.mapel',
            'dataMengajar.kelas',
        ])->orderBy('hari')->orderBy('jam_mulai')->paginate(15);

        return view('jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        $dataMengajar = DataMengajar::with(['guru', 'mapel', 'kelas'])
            ->orderBy('id')->get();

        return view('jadwal.create', compact('dataMengajar'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'data_mengajar_id' => ['required', 'exists:data_mengajar,id'],
            'hari' => ['required', Rule::in([
                'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu',
            ])],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'ruang' => ['nullable', 'string', 'max:100'],
        ]);

        $this->checkConflict($data);

        Jadwal::create($data);

        return redirect()->route('superadmin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function show(Jadwal $jadwal)
    {
        $jadwal->load('dataMengajar.guru', 'dataMengajar.mapel', 'dataMengajar.kelas');

        return view('jadwal.show', compact('jadwal'));
    }

    public function edit(Jadwal $jadwal)
    {
        $dataMengajar = DataMengajar::with(['guru', 'mapel', 'kelas'])->get();

        return view('jadwal.edit', compact('jadwal', 'dataMengajar'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $data = $request->validate([
            'data_mengajar_id' => ['required', 'exists:data_mengajar,id'],
            'hari' => ['required', Rule::in([
                'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu',
            ])],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'ruang' => ['nullable', 'string', 'max:100'],
        ]);

        $this->checkConflict($data, $jadwal->id);

        $jadwal->update($data);

        return redirect()->route('superadmin.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    private function checkConflict(array $data, ?int $ignoreId = null): void
    {
        $conflict = Jadwal::where('hari', $data['hari'])
            ->where('id', '!=', $ignoreId ?? 0)
            ->where('jam_mulai', '<', $data['jam_selesai'])
            ->where('jam_selesai', '>', $data['jam_mulai'])
            ->whereHas('dataMengajar', function ($query) use ($data) {
                $query->where('kelas_id', function ($sub) use ($data) {
                    $sub->select('kelas_id')
                        ->from('data_mengajar')
                        ->where('id', $data['data_mengajar_id']);
                });
            })
            ->exists();

        if ($conflict) {
            abort(422, 'Jadwal kelas bertabrakan dengan jadwal lain.');
        }
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('superadmin.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
