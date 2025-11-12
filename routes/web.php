<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Desa\DesaController;
use App\Http\Controllers\Desa\PenilaianController;
use App\Http\Controllers\Desa\PengumumanController;
use App\Http\Controllers\Desa\TutorialController;
use App\Http\Controllers\Kecamatan\KecamatanDashboardController;

// =======================
// ROOT REDIRECT
// =======================
Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        if (in_array($role, ['admin', 'desa', 'kecamatan'])) {
            return redirect()->route($role . '.dashboard');
        }
    }
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
        // Route admin lainnya di sini
    });

// =======================
// DESA ROUTES
// =======================
Route::middleware(['auth', 'role:desa'])
    ->prefix('desa')
    ->name('desa.')
    ->group(function () {
        Route::get('/dashboard', [DesaController::class, 'index'])->name('dashboard');
        Route::get('/klaster/{slug}', [DesaController::class, 'showKlaster'])->name('klaster.detail');
        Route::get('/klaster/{klaster}/{indikator}', [DesaController::class, 'showIndikator'])->name('indikator.detail');
        Route::post('/penilaian/store', [PenilaianController::class, 'store'])->name('penilaian.store');
        Route::delete('/penilaian/klaster/{klasterId}/cancel', [PenilaianController::class, 'cancelByKlaster'])
        ->name('penilaian.cancelKlaster');
        Route::get('/template/download/{indikator}', [PenilaianController::class, 'downloadTemplate'])->name('template.download');
        Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman');
        Route::get('/tutorial', [TutorialController::class, 'index'])->name('tutorial');

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
