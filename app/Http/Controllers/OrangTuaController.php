<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrangTuaController extends Controller
{
    public function index()
    {
        $orangtuas = Parents::with('student')->get();
        return view('parents.index', compact('orangtuas'));
    }

    public function dashboardOrtu()
    {
        $parent = Auth::user()->parent;
        $student = $parent ? $parent->student : null;

        return view('dashboard.orangtua.index', compact('student'));
    }

    public function rekapAbsensi(Request $request)
    {
        $parent = Auth::user()->parent;
        $student = $parent ? $parent->student : null;
        $bulan = $request->input('bulan', now()->format('Y-m'));
        $absensi = [];

        if ($student) {
            $absensi = \App\Models\Attendance::where('student_id', $student->id)
                ->where('tanggal', 'like', $bulan . '%')
                ->orderBy('tanggal')
                ->get();
        }

        return view('dashboard.orangtua.rekap-absensi', compact('student', 'absensi', 'bulan'));
    }

    public function riwayatAbsensi(Request $request)
    {
        $parent = Auth::user()->parent;
        $student = $parent ? $parent->student : null;
        $absensi = [];

        if ($student) {
            $absensi = \App\Models\Attendance::where('student_id', $student->id)
                ->orderByDesc('tanggal')
                ->get();
        }

        return view('dashboard.orangtua.riwayat-absensi', compact('student', 'absensi'));
    }

    public function riwayatAbsensiPdf()
    {
        $parent = Auth::user()->parent;
        $student = $parent ? $parent->student : null;
        $absensi = [];

        if ($student) {
            $absensi = \App\Models\Attendance::where('student_id', $student->id)
                ->orderByDesc('tanggal')
                ->get();
        }

        $pdf = Pdf::loadView('dashboard.orangtua.riwayat-absensi-pdf', compact('student', 'absensi'));
        return $pdf->download('riwayat_absensi_' . $student->nama . '.pdf');
    }

    public function create()
    {
        $users = User::where('role', 'orang_tua')->get(); // atau sesuaikan role user orang tua
        $students = Student::with('user')->get();
        return view('parents.create', compact('users', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:orang_tuas',
            'no_hp' => 'nullable',
            'student_id' => 'nullable|exists:students,id',
        ]);
        Parents::create($request->only(['nama', 'email', 'no_hp', 'student_id']));
        return redirect()->route('parents.index')->with('success', 'Orang Tua berhasil ditambahkan.');
    }

    public function edit(Parents $orangtua)
    {
        $students = Student::all();

        return view('parents.edit', compact('orangtua', 'students'));
    }

    public function update(Request $request, Parents $orangtua)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:orang_tuas,email,' . $orangtua->id,
            'no_hp' => 'nullable',
            'student_id' => 'nullable|exists:students,id',
        ]);
        $orangtua->update($request->only(['nama', 'email', 'no_hp', 'student_id']));
        return redirect()->route('parents.index')->with('success', 'Orang Tua berhasil diupdate.');
    }

    public function destroy(Parents $orangtua)
    {
        $orangtua->delete();
        return redirect()->route('parents.index')->with('success', 'Orang Tua berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file, 'r');
        $header = fgetcsv($handle);

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);

            // 1. Cari/buat kelas
            $schoolClass = SchoolClass::firstOrCreate(
                [
                    'class_name' => $data['kelas'],
                    'homeroom_teacher' => $data['homeroom_teacher'],
                ]
            );

            // 2. Cari/buat siswa
            $student = Student::firstOrCreate(
                ['nis' => $data['nis']],
                [
                    'user_id' => null,
                    'school_class_id' => $schoolClass->id,
                    'nis' => $data['nis'],
                    'kelas' => $data['kelas'],
                    'qr_code' => null,
                ]
            );

            // 3. Buat orang tua
            Parents::create([
                'nama' => $data['nama_orang_tua'],
                'no_hp' => $data['no_hp_orang_tua'],
                'student_id' => $student->id,
            ]);
        }
        fclose($handle);

        return redirect()->route('parents.index')->with('success', 'Import data berhasil!');
    }
}
