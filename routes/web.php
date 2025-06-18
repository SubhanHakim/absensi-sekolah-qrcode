<?php

use App\Http\Controllers\AccountManagementController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

// Halaman login (root)
Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('auth.login');
});

// Dashboard umum (jika ada)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===================== GURU =====================
Route::middleware(['auth', 'role:guru'])->prefix('dashboard')->group(function () {
    Route::get('guru', [GuruController::class, 'dashboardGuru'])->name('dashboard.guru.index');
    Route::get('guru/scan-absen', [GuruController::class, 'scanAbsen'])->name('guru.scanAbsen');
    Route::post('guru/proses-absen', [GuruController::class, 'prosesAbsen'])->name('guru.prosesAbsen');
    Route::get('guru/download-qr', [GuruController::class, 'downloadQrPdf'])->name('guru.downloadQrPdf');
    Route::get('guru/{student}/download-qr', [GuruController::class, 'downloadQr'])->name('guru.downloadQr');
    Route::get('guru/rekap-absen', [GuruController::class, 'rekapAbsensiHariIni'])->name('guru.rekapAbsen');

    Route::get('guru/leave-requests', [LeaveRequestController::class, 'indexForTeacher'])
         ->name('dashboard.guru.leave-request.index');
    Route::patch('guru/leave-requests/{leaveRequest}', [LeaveRequestController::class, 'approve'])
         ->name('dashboard.guru.leave-request.approve');
    // route lain khusus guru
});

// ===================== ORANG TUA =====================
Route::middleware(['auth', 'role:orang_tua'])->prefix('dashboard')->group(function () {
    Route::get('orangtua', [OrangTuaController::class, 'dashboardOrtu'])->name('dashboard.orangtua.index');
    Route::get('orangtua/rekap-absensi', [OrangTuaController::class, 'rekapAbsensi'])->name('dashboard.orangtua.rekap-absensi');
    Route::get('orangtua/riwayat-absensi', [OrangTuaController::class, 'riwayatAbsensi'])->name('dashboard.orangtua.riwayat-absensi');
    Route::get('orangtua/riwayat-absensi/pdf', [OrangTuaController::class, 'riwayatAbsensiPdf'])->name('dashboard.orangtua.riwayat-absensi.pdf');

    Route::get('orangtua/leave-requests', [LeaveRequestController::class, 'index'])
        ->name('dashboard.orangtua.leave-request.index');
    Route::get('orangtua/leave-requests/create', [LeaveRequestController::class, 'create'])
        ->name('dashboard.orangtua.leave-request.create');
    Route::post('orangtua/leave-requests', [LeaveRequestController::class, 'store'])
        ->name('dashboard.orangtua.leave-request.store');
});

// ===================== PETUGAS =====================
Route::middleware(['auth', 'role:petugas'])->prefix('dashboard')->group(function () {
    Route::get('petugas', [PetugasController::class, 'index'])->name('dashboard.petugas.index');
    Route::resource('school_classes', SchoolClassController::class);
    Route::resource('gurus', GuruController::class);
    Route::resource('students', SiswaController::class);
    Route::resource('orangtuas', OrangTuaController::class);

    // Manajemen akun
    Route::get('accounts', [AccountManagementController::class, 'index'])->name('accounts.index');
    Route::post('accounts/guru/{guru}', [AccountManagementController::class, 'createGuru'])->name('accounts.createGuru');
    Route::post('accounts/siswa/{student}', [AccountManagementController::class, 'createSiswa'])->name('accounts.createSiswa');
    Route::post('accounts/orangtua/{parent}', [AccountManagementController::class, 'createParent'])->name('accounts.createParent');

    // Import data orang tua (jika hanya petugas yang boleh)
    Route::post('orangtuas/import', [OrangTuaController::class, 'import'])->name('parents.import');
});

require __DIR__ . '/auth.php';
