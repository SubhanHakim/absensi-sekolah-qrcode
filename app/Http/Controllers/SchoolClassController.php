<?php

namespace App\Http\Controllers;

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
        return view('school_classes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required|unique:school_classes,class_name',
            'homeroom_teacher' => 'nullable|string',
        ]);
        SchoolClass::create($request->all());
        return redirect()->route('school_classes.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(SchoolClass $school_class)
    {
        return view('school_classes.edit', compact('school_class'));
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
