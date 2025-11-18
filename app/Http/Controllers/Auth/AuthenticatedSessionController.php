<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. AUTENTIKASI DULU
        // Baris ini akan mencoba login. Jika gagal, ia akan otomatis
        // melempar error dan mengembalikan pengguna ke halaman login.
        $request->authenticate();

        // 2. REGENERASI SESSION
        // Ini penting untuk keamanan setelah login berhasil.
        $request->session()->regenerate();

        // 3. SEKARANG BARU AMBIL PENGGUNA & CEK PERAN
        // Kita gunakan $request->user() untuk mendapatkan pengguna yang BARU SAJA login.
        $user = $request->user();

        // Cek apakah $user ada DAN apakah dia admin
        if ($user && $user->is_admin) {
            // Jika pengguna adalah ADMIN, arahkan ke dashboard admin
            return redirect()->route('admin.dashboard');
        }

        // Jika pengguna BIASA (pelanggan), arahkan ke beranda
        return redirect()->route('home');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
