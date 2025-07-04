<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Attendance;
use App\Models\Guru;
use App\Models\Parents;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = SchoolClass::count();
        $guru = Guru::count();
        $siswa = Student::count();
        $orangtua = Parents::count();

        $recentActivities = ActivityLog::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $totalAbsensi = Attendance::count();
        $hadir = Attendance::where('status', 'hadir')->count();
        $telat = Attendance::where('status', 'telat')->count();
        $izin = Attendance::where('status', 'izin')->count();
        $sakit = Attendance::where('status', 'sakit')->count();
        $alpha = Attendance::where('status', 'tidak hadir')->count();

        $persenHadir = $totalAbsensi ? round($hadir / $totalAbsensi * 100, 1) : 0;
        $persenTelat = $totalAbsensi ? round($telat / $totalAbsensi * 100, 1) : 0;
        $persenIzin = $totalAbsensi ? round($izin / $totalAbsensi * 100, 1) : 0;
        $persenSakit = $totalAbsensi ? round($sakit / $totalAbsensi * 100, 1) : 0;
        $persenAlpha = $totalAbsensi ? round($alpha / $totalAbsensi * 100, 1) : 0;

        return view('dashboard.petugas.index', compact(
            'kelas',
            'guru',
            'siswa',
            'orangtua',
            'recentActivities',
            'persenHadir',
            'persenTelat',
            'persenIzin',
            'persenSakit',
            'persenAlpha'
        ));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
