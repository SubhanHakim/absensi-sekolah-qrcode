<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index()
    {
        $kelases = SchoolClass::all();
        return view('school_classes.index', compact('kelases'));
    }

    public function create()
    {
        $gurus = Guru::all();
        return view('school_classes.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required|unique:school_classes,class_name',
            'homeroom_teacher' => 'required|exists:gurus,id',
        ]);

        // Simpan kelas
        $kelas = SchoolClass::create([
            'class_name' => $request->class_name,
            'homeroom_teacher' => $request->homeroom_teacher,
        ]);

        // Update guru (optional, jika ingin ada school_class_id di guru)
        Guru::where('id', $request->homeroom_teacher)
            ->update(['school_class_id' => $kelas->id]);

        return redirect()->route('school_classes.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(SchoolClass $school_class)
    {
        $gurus = Guru::all();
        return view('school_classes.edit', compact('school_class', 'gurus'));
    }

    public function update(Request $request, SchoolClass $school_class)
    {
        $request->validate([
            'class_name' => 'required|unique:school_classes,class_name,' . $school_class->id,
            'homeroom_teacher' => 'nullable|string',
        ]);
        $school_class->update($request->all());
        return redirect()->route('school_classes.index')->with('success', 'Kelas berhasil diupdate.');
    }

    public function destroy(SchoolClass $school_class)
    {
        $school_class->delete();
        return redirect()->route('school_classes.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
