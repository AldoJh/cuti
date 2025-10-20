<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nip';

        // Ambil user berdasarkan loginField
        $user = User::where($loginField, $request->login)->first();

        // Jika user tidak ditemukan
        if (!$user) {
            return back()->withErrors([
                'login' => 'Email/NIP atau password salah!',
            ])->withInput(['login' => $request->login]);
        }

        // Jika user nonaktif -> stop
        if ((int) $user->status === 0) {
            return back()->withErrors([
                'login' => 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.',
            ])->withInput(['login' => $request->login]);
        }

        // Cek password secara manual
        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login' => 'Email/NIP atau password salah!',
            ])->withInput(['login' => $request->login]);
        }

        // Semua ok -> login user eksplisit
        Auth::login($user, $request->filled('remember')); // optional remember
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
