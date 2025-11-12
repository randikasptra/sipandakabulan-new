<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Desa\DesaController;
use App\Http\Controllers\Desa\PenilaianController;
use App\Http\Controllers\Desa\PengumumanController;
use App\Http\Controllers\Desa\TutorialController;
use App\Http\Controllers\Desa\SettingsController;
use App\Http\Controllers\Kecamatan\KecamatanDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDesaController;
use App\Http\Controllers\Admin\AdminPenilaianController;
use App\Http\Controllers\Admin\AdminPengumumanController;
use App\Http\Controllers\Admin\AdminTutorialController;
use App\Http\Controllers\Admin\AdminLaporanController;

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

        // Route Penilaian
        Route::get('/penilaian', [AdminPenilaianController::class, 'index'])->name('penilaian');
        Route::get('/penilaian/desa/{desa}', [AdminPenilaianController::class, 'showDesa'])->name('penilaian.desa'); // ← UBAH INI
        Route::get('/penilaian/desa/{desa}/klaster/{klaster}', [AdminPenilaianController::class, 'showKlaster'])->name('penilaian.klaster'); // ← TAMBAH INI
        Route::patch('/penilaian/{penilaian}/approve', [AdminPenilaianController::class, 'approve'])->name('penilaian.approve');
        Route::patch('/penilaian/{penilaian}/reject', [AdminPenilaianController::class, 'reject'])->name('penilaian.reject');

        // Route lainnya
        Route::get('/desa', [AdminDesaController::class, 'index'])->name('desa');
        Route::get('/pengumuman', [AdminPengumumanController::class, 'index'])->name('pengumuman');
        Route::get('/tutorial', [AdminTutorialController::class, 'index'])->name('tutorial');
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [AdminLaporanController::class, 'index'])->name('index');
            Route::get('/{desa}', [AdminLaporanController::class, 'showDesa'])->name('desa');
            Route::get('/export/excel', [AdminLaporanController::class, 'exportExcel'])->name('exportExcel');
            Route::get('/export/pdf', [AdminLaporanController::class, 'exportPdf'])->name('exportPdf');
        });


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
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

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
