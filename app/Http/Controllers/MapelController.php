<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MapelController extends Controller
{
    public function index()
    {
        $mapel = Mapel::latest()->paginate(10);

        return view('mapel.index', compact('mapel'));
    }

    public function create()
    {
        return view('mapel.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_mapel' => ['required', 'string', 'max:50', 'unique:mapel,kode_mapel'],
            'nama_mapel' => ['required', 'string', 'max:255'],
            'kelompok' => ['nullable', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ]);

        Mapel::create($data);

        return redirect()->route('superadmin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function show(Mapel $mapel)
    {
        return view('mapel.show', compact('mapel'));
    }

    public function edit(Mapel $mapel)
    {
        return view('mapel.edit', compact('mapel'));
    }

    public function update(Request $request, Mapel $mapel)
    {
        $data = $request->validate([
            'kode_mapel' => [
                'required', 'string', 'max:50',
                Rule::unique('mapel', 'kode_mapel')->ignore($mapel->id),
            ],
            'nama_mapel' => ['required', 'string', 'max:255'],
            'kelompok' => ['nullable', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ]);

        $mapel->update($data);

        return redirect()->route('superadmin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Mapel $mapel)
    {
        try {
            $mapel->delete();

            return redirect()->route('superadmin.mapel.index')
                ->with('success', 'Mata pelajaran berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('superadmin.mapel.index')
                ->with('error', 'Mata pelajaran masih digunakan pada data mengajar.');
        }
    }
}
