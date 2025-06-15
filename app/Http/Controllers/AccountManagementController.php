<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Parents;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class AccountManagementController extends Controller
{
    public function index()
    {
        $gurus = Guru::whereNull('user_id')->get();
        $students = Student::whereNull('user_id')->get();
        $parents = Parents::whereNull('user_id')->get();
        return view('accounts.index', compact('gurus', 'students', 'parents'));
    }

    public function createGuru(Guru $guru)
    {
        $user = User::create([
            'name' => $guru->nama,
            'email' => $guru->email,
            'password' => bcrypt('password_default'), // ganti dengan random/password aman
            'role' => 'guru',
        ]);
        $guru->update(['user_id' => $user->id]);
        return back()->with('success', 'Akun guru berhasil dibuat!');
    }

    //  public function createSiswa(Student $student)
    // {
    //     $user = User::create([
    //         'name' => $student->nama,
    //         'email' => $student->email,
    //         'password' => bcrypt('password_default'),
    //         'role' => 'siswa',
    //     ]);
    //     $student->update(['user_id' => $user->id]);
    //     return back()->with('success', 'Akun siswa berhasil dibuat!');
    // }
    public function createParent(Parents $parent)
    {
        $user = User::create([
            'name' => $parent->nama,
            'email' => $parent->email,
            'password' => bcrypt('password_default'),
            'role' => 'orang_tua',
        ]);
        $parent->update(['user_id' => $user->id]);
        return back()->with('success', 'Akun orang tua berhasil dibuat!');
    }
}
