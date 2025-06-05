<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SiswaController;
use GuruController as GlobalGuruController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::middleware(['auth', 'role:guru'])->group(function () {
//     Route::get('/dashboard/guru', [GuruController::class, 'index']);
//     // route lain khusus guru
// });

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard/siswa', [SiswaController::class, 'index']);
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
});

Route::post('dashboard/orangtuas/import', [OrangTuaController::class, 'import'])->name('orangtuas.import');
require __DIR__ . '/auth.php';
