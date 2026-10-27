<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'max:15'],
        ], [
            'login.required' => 'Username atau email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus terdiri dari 8 karakter.',
            'password.max' => 'Password maksimal harus terdiri dari 15 karakter.',
        ]);

        $user = User::where('username', $credentials['login'])
            ->orWhere('email', $credentials['login'])
            ->first();

        if (! $user || ! $user->is_active) {
            return back()
                ->withErrors([
                    'login' => 'Akun tidak ditemukan atau tidak aktif.',
                ])
                ->onlyInput('login');
        }

        if (! Auth::attempt([
            'username' => $user->username,
            'password' => $credentials['password'],
        ])) {
            return back()
                ->withErrors([
                    'login' => 'Username/email atau password salah.',
                ])
                ->onlyInput('login');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard.index'))
            ->with('success', 'Login berhasil.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('auth.login')
            ->with('success', 'Anda berhasil logout.');
    }
}
