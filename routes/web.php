<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Desa\DesaDashboardController;
use App\Http\Controllers\Kecamatan\KecamatanDashboardController;

// =======================
// ROOT REDIRECT
// =======================
Route::get('/', function () {
    // Kalau sudah login, langsung arahkan ke dashboard sesuai role
    if (auth()->check()) {
        $role = auth()->user()->role;
        if (in_array($role, ['admin', 'desa', 'kecamatan'])) {
            return redirect()->route($role . '.dashboard');
        }
    }

    // Kalau belum login → arahkan ke halaman login
    return redirect()->route('login');
})->name('home');

// =======================
// ADMIN ROUTES
// =======================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        // Route admin lainnya taruh di sini
    });

// =======================
// DESA ROUTES
// =======================
Route::middleware(['auth', 'role:desa'])
    ->prefix('desa')
    ->name('desa.')
    ->group(function () {
        Route::get('/dashboard', [DesaDashboardController::class, 'index'])->name('dashboard');
        // Route tambahan untuk desa nanti
    });

// =======================
// KECAMATAN ROUTES
// =======================
Route::middleware(['auth', 'role:kecamatan'])
    ->prefix('kecamatan')
    ->name('kecamatan.')
    ->group(function () {
        Route::get('/dashboard', [KecamatanDashboardController::class, 'index'])->name('dashboard');
    });

// =======================
// PROFILE ROUTES (Global)
// =======================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =======================
// AUTH ROUTES (Breeze)
// =======================
require __DIR__ . '/auth.php';
