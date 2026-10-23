<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::latest()->paginate(10);

        return view('guru.index', compact('guru'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nip' => ['nullable', 'string', 'max:50', 'unique:guru,nip'],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['nullable', Rule::in(['L', 'P'])],
            'email' => ['nullable', 'email', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('guru', 'public');
        }

        Guru::create($data);

        return redirect()->route('superadmin.guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        return view('guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $data = $request->validate([
            'nip' => [
                'nullable', 'string', 'max:50',
                Rule::unique('guru', 'nip')->ignore($guru->id),
            ],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['nullable', Rule::in(['L', 'P'])],
            'email' => ['nullable', 'email', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        if ($request->hasFile('photo')) {
            if ($guru->photo) {
                Storage::disk('public')->delete($guru->photo);
            }

            $data['photo'] = $request->file('photo')->store('guru', 'public');
        }

        $guru->update($data);

        return redirect()->route('superadmin.guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        try {
            $nama = $guru->nama;

            // Jangan hapus foto sebelum database berhasil menghapus data.
            $photo = $guru->photo;
            $guru->delete();

            if ($photo) {
                Storage::disk('public')->delete($photo);
            }

            return redirect()->route('superadmin.guru.index')
                ->with('success', "Data guru {$nama} berhasil dihapus.");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('superadmin.guru.index')
                ->with('error', 'Data guru masih digunakan oleh data mengajar atau akun pengguna.');
        }
    }
}
