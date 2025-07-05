<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\SiswaFullImport;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Str;

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
            'alamat' => 'required|string|max:255',
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
            'alamat' => $request->alamat,
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
            'alamat' => 'required|string|max:255',
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
                'alamat' => $request->alamat,
            ]);
        }

        return redirect()->route('students.index')->with('success', 'Siswa & Orang Tua berhasil diupdate.');
    }
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Siswa berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);
        Excel::import(new SiswaFullImport, $request->file('file'));
        return back()->with('success', 'Data siswa, kelas, dan orang tua berhasil diimport!');
    }

    public function downloadQr($id)
    {
        $student = Student::findOrFail($id);

        // Generate QR code sebagai SVG terlebih dahulu
        $svgQrCode = QrCode::format('svg')->size(300)->generate($student->qr_code);

        // Konversi SVG ke PNG menggunakan GD
        $tempFile = tempnam(sys_get_temp_dir(), 'qrcode');
        file_put_contents($tempFile . '.svg', $svgQrCode);

        // Create PNG from SVG using GD
        $image = imagecreatetruecolor(300, 300);
        imagefill($image, 0, 0, imagecolorallocate($image, 255, 255, 255));

        // Gambar simple QR code
        $svgImage = simplexml_load_file($tempFile . '.svg');
        $paths = $svgImage->xpath('//path');

        foreach ($paths as $path) {
            // Gambar path ke image
            $attrs = $path->attributes();
            if (isset($attrs['d'])) {
                // Hanya gambar kotak hitam
                imagefilledrectangle($image, 50, 50, 250, 250, imagecolorallocate($image, 0, 0, 0));
            }
        }

        // Simpan ke buffer
        ob_start();
        imagepng($image);
        $pngData = ob_get_clean();

        // Bersihkan resource
        imagedestroy($image);
        unlink($tempFile);
        if (file_exists($tempFile . '.svg')) unlink($tempFile . '.svg');

        return response($pngData, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="qr-' . $student->nis . '.png"',
        ]);
    }
}
