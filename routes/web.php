<?php

use App\Http\Controllers\AccountManagementController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SiswaController;
use GuruController as GlobalGuruController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard/guru', [GuruController::class, 'dashboardGuru'])->name('dashboard.guru.index');
    Route::get('/dashboard/guru/scan-absen', [GuruController::class, 'scanAbsen'])->name('guru.scanAbsen');
    Route::post('/dashboard/guru/proses-absen', [GuruController::class, 'prosesAbsen'])->name('guru.prosesAbsen');
    Route::get('/dashboard/guru/download-qr', [GuruController::class, 'downloadQrPdf'])->name('guru.downloadQrPdf');
    Route::get('/dashboard/siswa/{student}/download-qr', [GuruController::class, 'downloadQr'])->name('guru.downloadQr');
    Route::get('/dashboard/guru/rekap-absen', [GuruController::class, 'rekapAbsensiHariIni'])->name('guru.rekapAbsen');
    
    // route lain khusus guru
});

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard/siswa', [SiswaController::class, 'dashboardSiswa'])->name('dashboard.siswa.index');
    // route lain khusus siswa
});

Route::middleware(['auth', 'role:orang_tua'])->group(function () {
    Route::get('/dashboard/orangtua', [OrangTuaController::class, 'index']);
});

Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/dashboard/petugas', [PetugasController::class, 'index']);
    // route lain khusus petugas
});

Route::middleware(['auth', 'role:petugas'])->prefix('dashboard')->group(function () {
    Route::resource('school_classes', SchoolClassController::class);
    Route::resource('gurus', GuruController::class);
    Route::resource('students', SiswaController::class);
    Route::resource('orangtuas', OrangTuaController::class);

    // Manajemen akun
    Route::get('accounts', [AccountManagementController::class, 'index'])->name('accounts.index');
    Route::post('accounts/guru/{guru}', [AccountManagementController::class, 'createGuru'])->name('accounts.createGuru');
    Route::post('accounts/siswa/{student}', [AccountManagementController::class, 'createSiswa'])->name('accounts.createSiswa');
    Route::post('accounts/orangtua/{parent}', [AccountManagementController::class, 'createParent'])->name('accounts.createParent');
});

Route::post('dashboard/orangtuas/import', [OrangTuaController::class, 'import'])->name('parents.import');
require __DIR__ . '/auth.php';
