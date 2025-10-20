<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $key = Str::lower($request->input('login')).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'login' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik."
            ]);
        }

        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nip';

        // Ambil user berdasarkan loginField
        $user = User::where($loginField, $request->login)->first();

        // ❌ Jika user tidak ditemukan
        if (!$user) {
            RateLimiter::hit($key, 60);
            return back()->withErrors([
                'login' => 'Email/NIP atau password salah!'
            ])->withInput(['login' => $request->login]);
        }

        // ❌ Jika user nonaktif
        if ((int) $user->status === 0) {
            RateLimiter::hit($key, 60);
            return back()->withErrors([
                'login' => 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.'
            ])->withInput(['login' => $request->login]);
        }

        // ✅ Cek password secara manual
        if (!Hash::check($request->password, $user->password)) {
            RateLimiter::hit($key, 60);
            return back()->withErrors([
                'login' => 'Email/NIP atau password salah!'
            ])->withInput(['login' => $request->login]);
        }

        // ✅ Semua ok, login user
        Auth::login($user, $request->filled('remember'));
        $request->session()->regenerate();
        RateLimiter::clear($key);

        return redirect()->intended('/dashboard');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
