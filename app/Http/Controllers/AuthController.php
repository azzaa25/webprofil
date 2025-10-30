<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 🔹 Halaman Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // 🔹 Proses Login
    public function login(Request $request)
    {
        // Mendefinisikan aturan validasi
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];

        // Mendefinisikan pesan kustom untuk setiap aturan 'required' dan 'email'
        $messages = [
            'email.required' => 'Alamat Email wajib diisi. Mohon periksa kembali!',
            'email.email' => 'Format Email tidak valid. Pastikan Anda memasukkan email yang benar.',
            'password.required' => 'Kata Sandi wajib diisi. Anda tidak boleh mengosongkannya.',
        ];

        // Memanggil validasi dengan pesan kustom
        $credentials = $request->validate($rules, $messages);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Pesan sukses saat login
            return redirect()->intended('/admin/dashboard')->with('success', 'Selamat datang! Anda berhasil login.');
        }

        // Pesan error jika kredensial salah
        return back()->with('error', 'Gagal Login! Email atau kata sandi yang Anda masukkan tidak sesuai.');
    }

    // 🔹 Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil keluar. Sampai jumpa kembali!');
    }
}