<?php

namespace App\Http\Controllers;

use App\Mail\VerificationCodeMail;
use App\Models\User;
use App\Services\TelegramNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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

        $fullName = $request->input('full_name');
        $phone = $request->input('phone');
        $birthDate = $request->input('birth_date');
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        $password2 = $request->input('password2');

        if (!$fullName || !$phone || !$birthDate || !$username || !$email || !$password) {
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
            'full_name' => $fullName,
            'phone' => $phone,
            'birth_date' => $birthDate,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'user',
        ]);

        Auth::login($user);
        $this->issueVerificationCode($user);

        return redirect('/verify-email')->with('success', "Xoş gəlmisiniz, {$user->username}! E-poçtunuza göndərilən kodu daxil edin.");
    }

    public function showVerify()
    {
        $user = Auth::user();
        if ($user->email_verified_at) {
            return redirect('/');
        }
        return view('auth.verify-email', ['title' => 'E-poçtu təsdiqlə']);
    }

    public function verify(Request $request)
    {
        $user = Auth::user();
        if ($user->email_verified_at) {
            return redirect('/');
        }

        $code = trim((string) $request->input('code'));

        if (!$user->verification_code || !$user->verification_code_expires_at || now()->greaterThan($user->verification_code_expires_at)) {
            return redirect('/verify-email')->with('error', 'Kodun vaxtı bitib. Yenisini tələb edin.');
        }

        if (!Hash::check($code, $user->verification_code)) {
            return redirect('/verify-email')->with('error', 'Kod yanlışdır.');
        }

        $user->email_verified_at = now();
        $user->verification_code = null;
        $user->verification_code_expires_at = null;
        $user->save();

        TelegramNotifier::send(
            "🎉 <b>Yeni istifadəçi qeydiyyatdan keçdi!</b>\n" .
            "━━━━━━━━━━━━━━━\n" .
            "👤 <b>Ad:</b> {$user->full_name}\n" .
            "🔖 <b>İstifadəçi adı:</b> @{$user->username}\n" .
            "📱 <b>Nömrə:</b> {$user->phone}\n" .
            "📧 <b>E-poçt:</b> {$user->email}\n" .
            "🕒 <b>Tarix:</b> " . now()->format('d.m.Y H:i')
        );

        return redirect('/')->with('success', 'E-poçtunuz təsdiqləndi!');
    }

    public function resendVerification()
    {
        $user = Auth::user();
        if ($user->email_verified_at) {
            return redirect('/');
        }

        if ($user->verification_code_expires_at && now()->lessThan($user->verification_code_expires_at->copy()->subMinutes(14))) {
            return redirect('/verify-email')->with('error', 'Zəhmət olmasa bir az gözləyin və yenidən cəhd edin.');
        }

        $this->issueVerificationCode($user);
        return redirect('/verify-email')->with('success', 'Yeni kod göndərildi.');
    }

    private function issueVerificationCode(User $user): void
    {
        $code = (string) random_int(100000, 999999);

        $user->verification_code = Hash::make($code);
        $user->verification_code_expires_at = now()->addMinutes(15);
        $user->save();

        Mail::to($user->email)->send(new VerificationCodeMail($user, $code));
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
