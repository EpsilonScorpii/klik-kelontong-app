<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

class ProfileCompletionController extends Controller
{
    /**
     * Menampilkan halaman 'complete profile'.
     */
    public function create()
    {
        return view('auth.complete-profile');
    }

    /**
     * Menyimpan data profil yang baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'], // Anda bisa tambahkan validasi regex phone
            'gender' => ['required', 'string', 'in:male,female,other'],
        ]);

        $user = $request->user();
        
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender,
        ]);

        // Setelah selesai, arahkan ke dashboard
        return redirect()->route('dashboard');
    }
}