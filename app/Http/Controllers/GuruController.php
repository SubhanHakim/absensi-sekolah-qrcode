<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Guru;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::all();
        return view('gurus.index', compact('gurus'));
    }

    public function dashboardGuru()
    {
        $guru = Auth::user()->guru; // relasi user ke guru
        $kelas = $guru?->kelas; // kelas yang diampu guru
        $students = $kelas ? $kelas->students : collect();

        return view('dashboard.guru.index', compact('students', 'kelas'));
    }

    public function scanAbsen()
    {
        return view('dashboard.guru.scan-absen');
    }

    public function prosesAbsen(Request $request)
    {
        $kode = $request->input('qr_code'); // kode dari QR (misal NIS atau qr_code siswa)
        $student = Student::where('qr_code', $kode)->first();

        if ($student) {
            Attendance::create([
                'student_id' => $student->id,
                'user_id' => Auth::id(),
                'school_class_id' => $student->school_class_id,
                'tanggal' => now()->toDateString(),
                'status' => 'hadir',
                'keterangan' => null,
            ]);
            return back()->with('success', 'Absensi berhasil untuk ' . $student->nama);
        }
        return back()->with('error', 'Siswa tidak ditemukan!');
    }


    public function downloadQrPdf()
    {
        $guru = Auth::user()->guru;
        $kelas = $guru?->kelas;
        $students = $kelas ? $kelas->students : collect();
        $pdf = Pdf::loadView('dashboard.guru.qr-pdf', compact('students', 'kelas'));
        return $pdf->download('qr_code_kelas_' . $kelas->class_name . '.pdf');
    }

    public function downloadQr(Student $student)
    {
        $guru = Auth::user()->guru;
        // Pastikan siswa yang diakses memang dari kelas yang diampu guru
        if ($student->school_class_id !== $guru->school_class_id) {
            abort(403, 'Anda tidak berhak mengakses QR code siswa ini.');
        }

        $pdf = Pdf::loadView('students.qr-pdf', compact('student'));
        return $pdf->download('qr_code_' . $student->nama . '.pdf');
    }

public function rekapAbsensiHariIni()
{
    $guru = Auth::user()->guru;
    $kelas = $guru?->kelas;
    $students = $kelas ? $kelas->students : collect();

    $tanggal = now()->toDateString();
    $absenHariIni = Attendance::where('tanggal', $tanggal)
        ->whereIn('student_id', $students->pluck('id'))
        ->get()
        ->keyBy('student_id');

    return view('dashboard.guru.rekap-absen', compact('students', 'absenHariIni', 'kelas', 'tanggal'));
}





    public function create()
    {
        return view('gurus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required|unique:gurus',
            'email' => 'required|email|unique:gurus',
            'mapel' => 'nullable',
        ]);
        Guru::create($request->all());
        return redirect()->route('gurus.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        return view('gurus.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required|unique:gurus,nip,' . $guru->id,
            'email' => 'required|email|unique:gurus,email,' . $guru->id,
            'mapel' => 'nullable',
        ]);
        $guru->update($request->all());
        return redirect()->route('gurus.index')->with('success', 'Guru berhasil diupdate.');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('gurus.index')->with('success', 'Guru berhasil dihapus.');
    }
}
