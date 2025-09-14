<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
            return back()->withErrors(['login' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik."]);
        }
    
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nip';
    
        if (Auth::attempt([$loginField => $request->login, 'password' => $request->password])) {
            RateLimiter::clear($key);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
    
        RateLimiter::hit($key, 60);
        return back()->withErrors(['login' => 'Email/NIP atau password salah!']);
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
