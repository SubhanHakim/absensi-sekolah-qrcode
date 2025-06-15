<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'schoolClass'])->get();
        return view('students.index', compact('students'));
    }
    public function dashboardSiswa()
    {
        $siswa = Auth::user()->student;
        $kelas = $siswa?->schoolClass;

        return view('dashboard.siswa.index', compact('siswa', 'kelas'));
    }

    public function create()
    {
        $users = User::where('role', 'siswa')->get();
        $schoolClass = SchoolClass::all();
        return view('students.create', compact('users', 'schoolClass'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // Validasi siswa
            'nama_siswa' => 'required',
            'email' => 'required|email|unique:students,email',
            'nis' => 'required|unique:students,nis',
            'school_class_id' => 'required|exists:school_classes,id',
            // Validasi orang tua
            'nama_orangtua' => 'required',
            'email_orangtua' => 'required|email|unique:parents,email',
            'no_hp_orangtua' => 'required',
        ]);

        $qrCodeValue = $request->nis;

        // 1. Simpan siswa
        $student = Student::create([
            'nama' => $request->nama_siswa,
            'email' => $request->email,
            'user_id' => null, // atau isi jika ada
            'school_class_id' => $request->school_class_id,
            'nis' => $request->nis,
            'qr_code' => $qrCodeValue,
        ]);

        // 2. Simpan orang tua, hubungkan ke siswa
        Parents::create([
            'nama' => $request->nama_orangtua,
            'email' => $request->email_orangtua,
            'user_id' => null, // atau isi jika ada
            'no_hp' => $request->no_hp_orangtua,
            'student_id' => $student->id,
        ]);

        return redirect()->route('students.index')->with('success', 'Siswa & Orang Tua berhasil ditambahkan.');
    }


    public function edit(Student $student)
    {
        $parent = $student->parent; // ambil data parent dari relasi
        $schoolClass = SchoolClass::all();  

        return view('students.edit', compact('student', 'parent', 'schoolClass'));
    }

    public function update(Request $request, Student $student)
    {
        // Ambil data orang tua yang terkait dengan siswa ini
        $parent = $student->parent;

        $request->validate([
            // Validasi siswa
            'nama_siswa' => 'required',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'nis' => 'required|unique:students,nis,' . $student->id,
            'school_class_id' => 'required|exists:school_classes,id',
            // Validasi orang tua
            'nama_orangtua' => 'required',
            'email_orangtua' => 'required|email|unique:parents,email,' . ($parent->id ?? 'NULL'),
            'no_hp_orangtua' => 'required',
        ]);

        // Update siswa
        $student->update([
            'nama' => $request->nama_siswa,
            'email' => $request->email,
            'school_class_id' => $request->school_class_id,
            'nis' => $request->nis,
            'qr_code' => $request->nis,
        ]);

        // Update atau buat orang tua
        if ($parent) {
            $parent->update([
                'nama' => $request->nama_orangtua,
                'email' => $request->email_orangtua,
                'no_hp' => $request->no_hp_orangtua,
            ]);
        } else {
            Parents::create([
                'nama' => $request->nama_orangtua,
                'email' => $request->email_orangtua,
                'no_hp' => $request->no_hp_orangtua,
                'student_id' => $student->id,
                'user_id' => null,
            ]);
        }

        return redirect()->route('students.index')->with('success', 'Siswa & Orang Tua berhasil diupdate.');
    }
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
