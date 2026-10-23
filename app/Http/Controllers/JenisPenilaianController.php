<?php

namespace App\Http\Controllers;

use App\Models\JenisPenilaian;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JenisPenilaianController extends Controller
{
    public function index()
    {
        $jenisPenilaian = JenisPenilaian::latest()->paginate(10);

        return view('jenis_penilaian.index', compact('jenisPenilaian'));
    }

    public function create()
    {
        return view('jenis_penilaian.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => ['required', 'string', 'max:50', 'unique:jenis_penilaian,kode'],
            'nama' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'max:100'],
        ]);

        JenisPenilaian::create($data);

        return redirect()->route('superadmin.jenis-penilaian.index')
            ->with('success', 'Jenis penilaian berhasil ditambahkan.');
    }

    public function show(JenisPenilaian $jenisPenilaian)
    {
        return view('jenis_penilaian.show', compact('jenisPenilaian'));
    }

    public function edit(JenisPenilaian $jenisPenilaian)
    {
        return view('jenis_penilaian.edit', compact('jenisPenilaian'));
    }

    public function update(Request $request, JenisPenilaian $jenisPenilaian)
    {
        $data = $request->validate([
            'kode' => [
                'required', 'string', 'max:50',
                Rule::unique('jenis_penilaian', 'kode')->ignore($jenisPenilaian->id),
            ],
            'nama' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'max:100'],
        ]);

        $jenisPenilaian->update($data);

        return redirect()->route('superadmin.jenis-penilaian.index')
            ->with('success', 'Jenis penilaian berhasil diperbarui.');
    }

    public function destroy(JenisPenilaian $jenisPenilaian)
    {
        try {
            $jenisPenilaian->delete();

            return redirect()->route('superadmin.jenis-penilaian.index')
                ->with('success', 'Jenis penilaian berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('superadmin.jenis-penilaian.index')
                ->with('error', 'Jenis penilaian masih digunakan.');
        }
    }
}
