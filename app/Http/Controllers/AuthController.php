<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Memproses data login yang dikirim dari form
    public function login(Request $request)
    {
        // Validasi input email & password wajib diisi
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba autentikasi menggunakan kredensial yang diinput
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate(); // regenerasi session untuk keamanan (mencegah session fixation)

            // Ambil user yang baru login beserta relasi level-nya
            $user = Auth::user()->load('level');

            // Arahkan ke dashboard sesuai level/role user
            return match ($user->level->level_name) {
                'Administrator' => redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, ' . $user->name . '!'),
                'Operator' => redirect()->route('operator.dashboard')->with('success', 'Selamat datang kembali, ' . $user->name . '!'),
                'Pimpinan' => redirect()->route('pimpinan.dashboard')->with('success', 'Selamat datang kembali, ' . $user->name . '!'),
                default => redirect('/')->with('error', 'Level tidak dikenali'),
            };
        }

        // Jika gagal login, kembali ke form dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout(); // hapus session autentikasi

        $request->session()->invalidate(); // hapus semua data session
        $request->session()->regenerateToken(); // regenerasi CSRF token

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
