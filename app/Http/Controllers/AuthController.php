<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogger;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin(Request $request)
    {
        $users = \App\Models\User::orderBy('name')->get();
        return view('auth.login', compact('users'));
    }

    /**
     * Tampilkan halaman pemulihan kata sandi (Lupa Password)
     */
    public function showForgotPassword(Request $request)
    {
        $users = \App\Models\User::orderBy('name')->get();
        return view('auth.forgot-password', compact('users'));
    }

    /**
     * Proses pemulihan kata sandi & memaksa masuk ke akun
     */
    public function forceLogin(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'phone' => ['required'],
            'referral_code' => ['required'],
        ], [
            'email.required' => 'Pilih akun atau isi Email / Username login Anda.',
            'phone.required' => 'Nomor WhatsApp (Validasi 1) wajib diisi.',
            'referral_code.required' => 'Kode Referral (Validasi 2) wajib diisi.',
        ]);

        $inputIdentifier = trim($request->email);
        $inputPhone = trim($request->phone);
        $inputReferral = strtolower(trim($request->referral_code));

        // Cari user berdasarkan email, username, atau nama
        $user = \App\Models\User::where('email', $inputIdentifier)
            ->orWhere('username', $inputIdentifier)
            ->orWhere('name', $inputIdentifier)
            ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Gagal Masuk! Akun pengguna dengan Email / Username tersebut tidak ditemukan.'
            ])->withInput();
        }

        // 1. Verifikasi Ketat Nomor WhatsApp (Phone)
        $cleanInputPhone = preg_replace('/[^0-9]/', '', $inputPhone);
        $cleanUserPhone = preg_replace('/[^0-9]/', '', $user->phone ?? '081234567890');

        if (str_starts_with($cleanInputPhone, '62')) {
            $cleanInputPhone = '0' . substr($cleanInputPhone, 2);
        }
        if (str_starts_with($cleanUserPhone, '62')) {
            $cleanUserPhone = '0' . substr($cleanUserPhone, 2);
        }

        if ($cleanInputPhone !== $cleanUserPhone) {
            return back()->withErrors([
                'phone' => 'Gagal Masuk! Nomor WhatsApp (Validasi 1) tidak sesuai dengan data bawaan akun ini.'
            ])->withInput();
        }

        // 2. Verifikasi Ketat Kode Referral (Referral Code)
        $expectedReferral = strtolower(trim($user->referral_code ?? ($user->role === 'admin' ? 'ADM001' : 'STF888')));

        if ($inputReferral !== $expectedReferral) {
            return back()->withErrors([
                'referral_code' => 'Gagal Masuk! Kode Referral (Validasi 2) "' . strtoupper($request->referral_code) . '" tidak sesuai dengan akun ini.'
            ])->withInput();
        }

        // Jika lolos semua validasi ketat, login otomatis
        Auth::login($user);
        $request->session()->regenerate();

        ActivityLogger::log('LOGIN_RECOVERY', 'Autentikasi', "User memulihkan akun dan berhasil memaksa masuk: {$user->email} ({$user->name})");

        return redirect()->route('dashboard')->with('success', "Pemulihan kata sandi berhasil! Selamat datang kembali, {$user->name}.");
    }

    /**
     * Proses request login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'captcha' => ['required', 'captcha'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'captcha.required' => 'Kode captcha wajib diisi.',
            'captcha.captcha' => 'Kode captcha tidak valid. Silakan coba lagi.',
        ]);

        // Hapus captcha dari credentials sebelum Auth::attempt
        unset($credentials['captcha']);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            ActivityLogger::log('LOGIN', 'Autentikasi', 'User berhasil melakukan login ke dashboard.');
            return redirect()->intended('dashboard');
        }

        ActivityLogger::log('LOGIN_FAILED', 'Autentikasi', 'Percobaan login gagal untuk email: ' . $request->email);

        return back()
            ->withErrors([
                'email' => 'Email atau password yang Anda masukkan tidak valid.',
            ])
            ->onlyInput('email');
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            ActivityLogger::log('LOGOUT', 'Autentikasi', 'User melakukan logout dari sistem.');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
