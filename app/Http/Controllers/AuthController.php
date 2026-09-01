<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.register', ['title' => 'Qeydiyyat']);
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return redirect('/');
        }

        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        $password2 = $request->input('password2');

        if (!$username || !$email || !$password) {
            return redirect('/register')->with('error', 'Bütün xanaları doldurun.');
        }
        if (strlen($password) < 6) {
            return redirect('/register')->with('error', 'Şifrə ən azı 6 simvol olmalıdır.');
        }
        if ($password !== $password2) {
            return redirect('/register')->with('error', 'Şifrələr uyğun gəlmir.');
        }

        $existing = User::where('email', $email)->orWhere('username', $username)->exists();
        if ($existing) {
            return redirect('/register')->with('error', 'Bu istifadəçi adı və ya e-poçt artıq istifadə olunur.');
        }

        $user = User::create([
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'user',
        ]);

        Auth::login($user);
        return redirect('/')->with('success', "Xoş gəlmisiniz, {$user->username}!");
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.login', ['title' => 'Daxil ol']);
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect('/');
        }

        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return redirect('/login')->with('error', 'E-poçt və ya şifrə yanlışdır.');
        }

        $request->session()->regenerate();
        return redirect()->intended('/')->with('success', 'Xoş gəldiniz, ' . Auth::user()->username . '!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
