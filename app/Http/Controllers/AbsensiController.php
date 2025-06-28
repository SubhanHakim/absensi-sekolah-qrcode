<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AbsensiController extends Controller
{
    /**
     * Menampilkan halaman scan absensi
     */
    public function scanAbsen()
    {
        $classes = SchoolClass::all();
        return view('dashboard.petugas.scan-absen', compact('classes'));
    }

    public function processAbsen(Request $request)
    {
        $kode = $request->input('qr_code'); // kode dari QR (misal NIS atau qr_code siswa)
        $student = Student::where('qr_code', $kode)->first();

        if ($student) {
            // Cek apakah sudah absen hari ini
            $sudahAbsen = Attendance::where('student_id', $student->id)
                ->where('tanggal', now()->toDateString())
                ->exists();

            if ($sudahAbsen) {
                return back()->with('error', 'Siswa sudah absen hari ini.');
            }

            $now = now();
            $batasTelat = $now->copy()->setTime(7, 0, 0);
            $status = $now->greaterThan($batasTelat) ? 'telat' : 'hadir';

            // dd(now());

            Attendance::create([
                'student_id' => $student->id,
                'user_id' => Auth::id(),
                'school_class_id' => $student->school_class_id,
                'tanggal' => $now->toDateString(),
                'status' => $status,
                'keterangan' => null,
            ]);

            $parent = $student->parent;
            if ($parent && $parent->no_hp) {
                $no_hp = $parent->no_hp;
                $pesan = "Anak Anda, {$student->nama}, telah melakukan absensi dan statusnya: HADIR pada " . now()->format('d-m-Y') . ".";

                try {
                    $response = \Illuminate\Support\Facades\Http::withHeaders([
                        'Authorization' => env('FONNTE_API_KEY')
                    ])->asForm()->post('https://api.fonnte.com/send', [
                        'target' => $no_hp,
                        'message' => $pesan,
                    ]);
                    // Optional: cek response jika perlu
                    // $result = $response->json();
                } catch (\Exception $e) {
                    // Optional: log error atau tampilkan pesan
                    Log::error('Gagal kirim WA: ' . $e->getMessage());
                }
            }

            return back()->with('success', 'Absensi berhasil untuk ' . $student->nama . '. Notifikasi dikirim ke orang tua.');
        }

        return back()->with('error', 'Siswa tidak ditemukan!');
    }


    /**
     * Proses absensi melalui scan QR Code
     */
    public function scanQrCode(Request $request)
    {
        $request->validate([
            'qr_code' => 'required',
            'class_id' => 'required|exists:school_classes,id',
        ]);

        // Decode QR code (diasumsikan QR berisi student_id)
        $studentId = $request->qr_code;

        // Cek apakah student ada dan terdaftar di kelas yang dipilih
        $student = Student::where('id', $studentId)
            ->where('school_class_id', $request->class_id)
            ->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Siswa tidak ditemukan atau tidak terdaftar di kelas ini');
        }

        $today = Carbon::now()->toDateString();
        $now = Carbon::now();
        // dd(now());

        // Tentukan status hadir/telat
        $batasTelat = $now->copy()->setTime(7, 0, 0);
        $status = $now->greaterThan($batasTelat) ? 'telat' : 'hadir';

        // Cek apakah sudah absen hari ini
        $existingAttendance = Attendance::where('student_id', $studentId)
            ->whereDate('created_at', $today)
            ->first();

        if ($existingAttendance) {
            // Update absensi yang sudah ada
            $existingAttendance->update([
                'status' => $status,
                'time' => $now->format('H:i:s'),
            ]);

            return redirect()->back()->with('success', 'Absensi berhasil diperbarui: ' . $student->nama);
        }

        // Buat absensi baru
        Attendance::create([
            'student_id' => $studentId,
            'status' => $status,
            'date' => $today,
            'time' => $now->format('H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil dicatat: ' . $student->nama);
    }
    public function rekapAbsen(Request $request)
    {
        // Ambil parameter dari request
        $tanggal = $request->input('tanggal', now()->toDateString());
        $periode = $request->input('periode', 'harian');
        $kelasId = $request->input('kelas_id');

        // Dapatkan data kelas
        $classes = SchoolClass::all();
        $selectedClass = $kelasId ? SchoolClass::findOrFail($kelasId) : null;

        // Set objek kelas dengan properti yang digunakan di view
        $kelas = null;
        if ($selectedClass) {
            $kelas = (object) [
                'id' => $selectedClass->id,
                'class_name' => $selectedClass->class_name ?? ('Kelas ' . $selectedClass->id)
            ];
        }

        // Dapatkan siswa berdasarkan kelas yang dipilih atau semua siswa
        $query = Student::query();
        if ($selectedClass) {
            $query->where('school_class_id', $selectedClass->id);
        }
        $rawStudents = $query->get();

        // Transform siswa untuk menyesuaikan dengan properti di view
        $students = $rawStudents->map(function ($student) {
            $classInfo = $student->schoolClass
                ? ($student->schoolClass->class_name ?? ('Kelas ' . $student->schoolClass->id))
                : 'Tidak Ada Kelas';

            return (object) [
                'id' => $student->id,
                'nama' => $student->nama,
                'nis' => $student->nis ?? $student->student_id ?? 'N/A',
                'kelas' => $classInfo
            ];
        });

        // Siapkan data absensi sesuai periode
        $absensi = [];

        // Tentukan range tanggal berdasarkan periode
        $startDate = Carbon::parse($tanggal);
        $endDate = Carbon::parse($tanggal);

        if ($periode === 'mingguan') {
            $startDate = $startDate->startOfWeek();
            $endDate = $endDate->endOfWeek();
        } elseif ($periode === 'bulanan') {
            $startDate = $startDate->startOfMonth();
            $endDate = $endDate->endOfMonth();
        }

        // Ambil data absensi untuk setiap siswa
        foreach ($rawStudents as $student) {
            $attendances = Attendance::where('student_id', $student->id)
                ->whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
                ->get();

            // Transform attendance records untuk menyesuaikan dengan view
            $transformedAttendances = $attendances->map(function ($attendance) {
                return (object) [
                    'id' => $attendance->id,
                    'tanggal' => $attendance->tanggal,
                    'status' => $attendance->status
                ];
            });

            $absensi[$student->id] = $transformedAttendances;
        }

        return view('dashboard.petugas.rekap-absen', compact(
            'classes',
            'kelas',
            'students',
            'tanggal',
            'periode',
            'absensi'
        ));
    }

    /**
     * Detail rekap absensi per kelas
     */
    public function detailRekapAbsen($classId, Request $request)
    {
        $class = SchoolClass::findOrFail($classId);
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $students = Student::where('school_class_id', $classId)->get();

        $attendanceSummary = [];

        foreach ($students as $student) {
            $hadir = Attendance::where('student_id', $student->id)
                ->where('school_class_id', $classId)
                ->whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
                ->where('status', 'hadir')
                ->count();

            $izin = Attendance::where('student_id', $student->id)
                ->where('school_class_id', $classId)
                ->whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
                ->where('status', 'izin')
                ->count();

            $sakit = Attendance::where('student_id', $student->id)
                ->where('school_class_id', $classId)
                ->whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
                ->where('status', 'sakit')
                ->count();

            $alpha = Attendance::where('student_id', $student->id)
                ->where('school_class_id', $classId)
                ->whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
                ->where('status', 'alpha')
                ->count();

            $attendanceSummary[] = [
                'student' => $student,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpha' => $alpha,
            ];
        }

        return view('dashboard.petugas.rekap-absen.detail', compact('class', 'startDate', 'endDate', 'attendanceSummary'));
    }

    /**
     * Export rekap absensi ke PDF
     */
    public function exportPdf($classId, Request $request)
    {
        $class = SchoolClass::findOrFail($classId);
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $students = Student::where('school_class_id', $classId)->get();

        $attendanceSummary = [];

        foreach ($students as $student) {
            $hadir = Attendance::where('student_id', $student->id)
                ->whereBetween('date', [$startDate, $endDate])
                ->where('status', 'hadir')
                ->count();

            $izin = Attendance::where('student_id', $student->id)
                ->whereBetween('date', [$startDate, $endDate])
                ->where('status', 'izin')
                ->count();

            $sakit = Attendance::where('student_id', $student->id)
                ->whereBetween('date', [$startDate, $endDate])
                ->where('status', 'sakit')
                ->count();

            $alpha = Attendance::where('student_id', $student->id)
                ->whereBetween('date', [$startDate, $endDate])
                ->where('status', 'alpha')
                ->count();

            $attendanceSummary[] = [
                'student' => $student,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpha' => $alpha,
            ];
        }

        // Implementasi export PDF (menggunakan DomPDF)
        $pdf = PDF::loadView('dashboard.petugas.rekap-absen.pdf', compact('class', 'startDate', 'endDate', 'attendanceSummary'));
        return $pdf->download('rekap-absensi-' . $class->name . '.pdf');
    }
}
