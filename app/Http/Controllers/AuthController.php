<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi login
     */
    public function login(Request $request)
    {
        // 1. Validasi input (Poin W: Username & Password wajib diisi)
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // 2. Cek apakah username terdaftar di sistem
        $user = User::where('username', $credentials['username'])->first();
        if (!$user) {
            return back()->withInput($request->only('username'))->withErrors([
                'username' => 'Username tidak terdaftar di sistem.',
            ]);
        }

        // 3. Cek status keaktifan user
        if ($user->status !== 'aktif') {
            return back()->withInput($request->only('username'))->withErrors([
                'username' => 'Akun Anda dinonaktifkan. Silakan hubungi admin sekolah.',
            ]);
        }

        // 4. Verifikasi kecocokan password
        if (!Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            return back()->withInput($request->only('username'))->withErrors([
                'password' => 'Password yang Anda masukkan salah.',
            ]);
        }

        // 5. Regenerate session untuk keamanan
        $request->session()->regenerate();

        // 6. Redirect sesuai peran / role
        return $this->redirectByRole(Auth::user()->role)->with('success', 'Selamat datang, ' . Auth::user()->nama . '!');
    }

    /**
     * Helper redirect berdasarkan role
     */
    private function redirectByRole(string $role)
    {
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'kepala_sekolah' => redirect()->route('kepsek.dashboard'),
            'teller' => redirect()->route('teller.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            default => redirect()->route('login'),
        };
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout dari sistem.');
    }
}
