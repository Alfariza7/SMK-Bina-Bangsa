<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
        }

        $user = Auth::user();

        // Cek status aktif
        if ($user->status !== 'aktif') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->withErrors(['error' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.']);
        }

        // Cek apakah role user ada dalam daftar role yang diperbolehkan
        if (!in_array($user->role, $roles)) {
            // Arahkan ke dashboard masing-masing jika salah masuk jalur
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.'),
                'kepala_sekolah' => redirect()->route('kepsek.dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.'),
                'teller' => redirect()->route('teller.dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.'),
                'siswa' => redirect()->route('siswa.dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.'),
                default => abort(403, 'Akses ditolak.'),
            };
        }

        return $next($request);
    }
}
