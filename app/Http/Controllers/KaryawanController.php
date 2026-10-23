<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    private function indexRoute(): string
    {
        return Auth::user()->role?->nama_role === 'admin_tu'
            ? 'admin-tu.karyawan.index'
            : 'superadmin.karyawan.index';
    }

    public function index()
    {
        $karyawan = Karyawan::latest()->paginate(10);

        return view('karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nip' => ['nullable', 'string', 'max:50', 'unique:karyawan,nip'],
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('karyawan', 'public');
        }

        Karyawan::create($data);

        return redirect()->route($this->indexRoute())
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function show(Karyawan $karyawan)
    {
        return view('karyawan.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $data = $request->validate([
            'nip' => [
                'nullable', 'string', 'max:50',
                Rule::unique('karyawan', 'nip')->ignore($karyawan->id),
            ],
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        if ($request->hasFile('photo')) {
            if ($karyawan->photo) {
                Storage::disk('public')->delete($karyawan->photo);
            }

            $data['photo'] = $request->file('photo')->store('karyawan', 'public');
        }

        $karyawan->update($data);

        return redirect()->route($this->indexRoute())
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        try {
            $photo = $karyawan->photo;
            $karyawan->delete();

            if ($photo) {
                Storage::disk('public')->delete($photo);
            }

            return redirect()->route($this->indexRoute())
                ->with('success', 'Data karyawan berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route($this->indexRoute())
                ->with('error', 'Karyawan masih terhubung dengan akun pengguna.');
        }
    }
}
