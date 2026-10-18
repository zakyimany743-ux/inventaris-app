<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Berikut adalah semua route untuk aplikasi manajemen inventaris.
| Halaman inventaris (dashboard, categories, items) dilindungi
| middleware 'auth' sehingga hanya bisa diakses oleh pengguna
| yang sudah login.
|
*/

// ============ RUTE PUBLIK (tanpa login) ============
// Halaman utama mengarah ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Halaman login & proses login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

// ============ RUTE YANG DILINDUNGI MIDDLEWARE AUTH ============
// Semua route di dalam grup ini hanya bisa diakses setelah login.
// Jika belum login, akan otomatis redirect ke halaman login.
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Kategori
    Route::resource('categories', CategoryController::class)->except(['show']);

    // CRUD Barang
    Route::resource('items', ItemController::class)->except(['show']);
});
