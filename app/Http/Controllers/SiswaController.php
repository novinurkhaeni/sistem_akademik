<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Siswa::with('kelas');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $siswa = $query->latest()->paginate(10)->withQueryString();

        return view('siswa.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('siswa.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:255', 'unique:siswa,nis'],
            'nisn' => ['nullable', 'string', 'max:255', 'unique:siswa,nisn'],
            'nama' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[\pL\s]+$/u',
            ],
            'jenis_kelamin' => ['nullable', Rule::in(['L', 'P'])],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
            'kelas_id' => ['nullable', 'exists:kelas,id'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['required', 'string', 'max:50'],
        ], [
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah digunakan.',
            'nisn.unique' => 'NISN sudah digunakan.',
            'nama.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak ditemukan.',
            'photo.image' => 'File foto harus berupa gambar.',
            'photo.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')
                ->store('siswa', 'public');
        }

        Siswa::create($validated);

        return redirect()
            ->route('superadmin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        //
        $siswa->load('kelas');

        return view('siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        //
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis' => [
                'required',
                'string',
                'max:255',
                Rule::unique('siswa', 'nis')->ignore($siswa->id),
            ],
            'nisn' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('siswa', 'nisn')->ignore($siswa->id),
            ],
            'nama' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[\pL\s]+$/u',
            ],
            'jenis_kelamin' => ['nullable', Rule::in(['L', 'P'])],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
            'kelas_id' => ['nullable', 'exists:kelas,id'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['required', 'string', 'max:50'],
        ], [
            'nis.unique' => 'NIS sudah digunakan siswa lain.',
            'nisn.unique' => 'NISN sudah digunakan siswa lain.',
            'nama.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
        ]);

        if ($request->hasFile('photo')) {
            if ($siswa->photo) {
                Storage::disk('public')->delete($siswa->photo);
            }

            $validated['photo'] = $request->file('photo')
                ->store('siswa', 'public');
        }

        $siswa->update($validated);

        return redirect()
            ->route('superadmin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $nama = $siswa->nama;

        try {
            if ($siswa->photo) {
                Storage::disk('public')->delete($siswa->photo);
            }

            $siswa->delete();

            return redirect()
                ->route('superadmin.siswa.index')
                ->with('success', "Data siswa {$nama} berhasil dihapus.");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()
                ->route('superadmin.siswa.index')
                ->with('error', 'Data siswa tidak dapat dihapus karena masih digunakan oleh data lain.');
        }
    }
}
