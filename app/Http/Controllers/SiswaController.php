<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
     public function index()
    {
        $students = Student::with(['user', 'schoolClass'])->get();
        return view('students.index', compact('students'));
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
            'user_id' => 'required|exists:users,id',
            'school_class_id' => 'nullable|exists:school_classes,id',
            'nis' => 'required|unique:students',
            'qr_code' => 'nullable|string',
        ]);
        Student::create($request->only([
            'user_id', 'school_class_id', 'nis', 'qr_code'
        ]));
        return redirect()->route('students.index')->with('success', 'Siswa berhasil ditambahkan.');
    }


     public function edit(Student $student)
    {
        $users = User::where('role', 'siswa')->get();
        $classes = SchoolClass::all();
        return view('students.edit', compact('student', 'users', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'school_class_id' => 'nullable|exists:school_classes,id',
            'nis' => 'required|unique:students,nis,' . $student->id,
            'qr_code' => 'nullable|string',
        ]);
        $student->update($request->only([
            'user_id', 'school_class_id', 'nis', 'qr_code'
        ]));
        return redirect()->route('students.index')->with('success', 'Siswa berhasil diupdate.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
