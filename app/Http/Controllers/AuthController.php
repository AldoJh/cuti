<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        'password' => 'required|string'
    ]);


    $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nip';

    if (Auth::attempt([$loginField => $request->login, 'password' => $request->password])) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'login' => 'Email/NIP atau password salah!',
    ]);
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
