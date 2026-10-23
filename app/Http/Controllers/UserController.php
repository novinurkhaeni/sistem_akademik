<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private function adminPrefix(): string
    {
        return Auth::user()->role?->nama_role === 'admin_tu'
            ? 'admin-tu'
            : 'superadmin';
    }

    private function authorizeAccountManagement(): void
    {
        abort_unless(
            in_array(Auth::user()->role?->nama_role, ['superadmin', 'admin_tu'], true),
            403
        );
    }

    private function availableRoles()
    {
        $query = Role::query();

        if (Auth::user()->role?->nama_role === 'admin_tu') {
            $query->whereIn('nama_role', ['guru', 'siswa', 'admin_tu']);
        }

        return $query->orderBy('nama_role')->get();
    }

    public function index()
    {
        $this->authorizeAccountManagement();

        $users = User::with(['role', 'guru', 'siswa', 'karyawan'])
            ->latest()
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->authorizeAccountManagement();

        $roles = $this->availableRoles();

        $guru = Guru::orderBy('nama')->get();
        $siswa = Siswa::orderBy('nama')->get();
        $karyawan = Karyawan::orderBy('nama')->get();

        return view('users.create', compact('roles', 'guru', 'siswa', 'karyawan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'guru_id' => ['nullable', 'exists:guru,id', 'unique:users,guru_id'],
            'siswa_id' => ['nullable', 'exists:siswa,id', 'unique:users,siswa_id'],
            'karyawan_id' => ['nullable', 'exists:karyawan,id', 'unique:users,karyawan_id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $role = Role::findOrFail($validated['role_id']);

        // Menentukan field profil yang sesuai dengan role
        $profileFields = [
            'guru' => 'guru_id',
            'siswa' => 'siswa_id',
            'admin_tu' => 'karyawan_id',
        ];

        $expectedField = match ($role->nama_role) {
            'guru' => 'guru_id',
            'siswa' => 'siswa_id',
            'admin_tu' => 'karyawan_id',
            default => null,
        };

        // Memastikan hanya profil yang sesuai dengan role yang diisi
        foreach ($profileFields as $field) {
            if ($field !== $expectedField && !empty($validated[$field])) {
                return back()
                    ->withInput($request->except('password'))
                    ->withErrors([
                        $field => 'Profil yang dipilih tidak sesuai dengan role pengguna.',
                    ]);
            }
        }

        // Role selain superadmin wajib memiliki profil yang sesuai
        if ($expectedField !== null && empty($validated[$expectedField])) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors([
                    $expectedField => 'Profil wajib dipilih sesuai dengan role pengguna.',
                ]);
        }

        // Menyiapkan data user
        $data = [
            'role_id' => $role->id,
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'guru_id' => $validated['guru_id'] ?? null,
            'siswa_id' => $validated['siswa_id'] ?? null,
            'karyawan_id' => $validated['karyawan_id'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ];

        User::create($data);

        return redirect()
            ->route('superadmin.users.index')
            ->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $this->authorizeAccountManagement();

        $user->load(['role', 'guru', 'siswa', 'karyawan']);

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorizeAccountManagement();

        $roles = $this->availableRoles();
        $guru = Guru::orderBy('nama')->get();
        $siswa = Siswa::orderBy('nama')->get();
        $karyawan = Karyawan::orderBy('nama')->get();

        return view('users.edit', compact('user', 'roles', 'guru', 'siswa', 'karyawan'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8'],
            'guru_id' => [
                'nullable',
                'exists:guru,id',
                Rule::unique('users', 'guru_id')->ignore($user->id),
            ],
            'siswa_id' => [
                'nullable',
                'exists:siswa,id',
                Rule::unique('users', 'siswa_id')->ignore($user->id),
            ],
            'karyawan_id' => [
                'nullable',
                'exists:karyawan,id',
                Rule::unique('users', 'karyawan_id')->ignore($user->id),
            ],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $role = Role::findOrFail($validated['role_id']);

        $profileFields = [
            'guru' => 'guru_id',
            'siswa' => 'siswa_id',
            'admin_tu' => 'karyawan_id',
        ];

        $expectedField = match ($role->nama_role) {
            'guru' => 'guru_id',
            'siswa' => 'siswa_id',
            'admin_tu' => 'karyawan_id',
            default => null,
        };

        // Memastikan tidak ada profil yang bertentangan dengan role
        foreach ($profileFields as $field) {
            if ($field !== $expectedField && !empty($validated[$field])) {
                return back()
                    ->withInput($request->except('password'))
                    ->withErrors([
                        $field => 'Profil yang dipilih tidak sesuai dengan role pengguna.',
                    ]);
            }
        }

        if ($expectedField !== null && empty($validated[$expectedField])) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors([
                    $expectedField => 'Profil wajib dipilih sesuai dengan role pengguna.',
                ]);
        }

        $data = [
            'role_id' => $role->id,
            'username' => $validated['username'],
            'email' => $validated['email'],
            'guru_id' => $validated['guru_id'] ?? null,
            'siswa_id' => $validated['siswa_id'] ?? null,
            'karyawan_id' => $validated['karyawan_id'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ];

        // Password hanya diperbarui jika diisi
        if (!empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $user->update($data);

        return redirect()
            ->route('superadmin.users.index')
            ->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->authorizeAccountManagement();

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        if (
            Auth::user()->role?->nama_role === 'admin_tu' &&
            $user->role?->nama_role === 'superadmin'
        ) {
            abort(403);
        }

        $user->delete();

        return redirect()
            ->route($this->adminPrefix() . '.users.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
}
