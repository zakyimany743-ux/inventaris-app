<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama.
     * Halaman ini hanya bisa diakses oleh pengguna yang sudah login
     * (dilindungi middleware auth pada route).
     */
    public function index()
    {
        $user = Auth::user();

        return view('dashboard.index', [
            'userName' => $user->name,
            'userEmail' => $user->email,
        ]);
    }
}
