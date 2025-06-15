<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Guru;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            // Cek apakah sudah absen hari ini
            $sudahAbsen = Attendance::where('student_id', $student->id)
                ->where('tanggal', now()->toDateString())
                ->exists();

            if ($sudahAbsen) {
                return back()->with('error', 'Siswa sudah absen hari ini.');
            }

            // Simpan absensi
            Attendance::create([
                'student_id' => $student->id,
                'user_id' => Auth::id(),
                'school_class_id' => $student->school_class_id,
                'tanggal' => now()->toDateString(),
                'status' => 'hadir',
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


    public function downloadQrPdf()
    {
        $guru = Auth::user()->guru;
        $kelas = $guru?->kelas;
        $students = $kelas ? $kelas->students : collect();
        $pdf = Pdf::loadView('dashboard.guru.qr-pdf', compact('students', 'kelas'));
        return $pdf->download('qr_code_kelas_' . $kelas->class_name . '.pdf');
    }

    public function rekapAbsensiHariIni(Request $request)
    {
        $guru = Auth::user()->guru;
        $kelas = $guru?->kelas;
        $students = $kelas ? $kelas->students : collect();

        // Ambil filter dari request, default: hari ini & harian
        $tanggal = $request->input('tanggal', now()->toDateString());
        $periode = $request->input('periode', 'harian');

        $query = Attendance::whereIn('student_id', $students->pluck('id'));

        if ($periode == 'mingguan') {
            $start = Carbon::parse($tanggal)->startOfWeek();
            $end = Carbon::parse($tanggal)->endOfWeek();
            $query->whereBetween('tanggal', [$start, $end]);
        } elseif ($periode == 'bulanan') {
            $start = Carbon::parse($tanggal)->startOfMonth();
            $end = Carbon::parse($tanggal)->endOfMonth();
            $query->whereBetween('tanggal', [$start, $end]);
        } else {
            $query->where('tanggal', $tanggal);
        }

        // Group absensi by student_id
        $absensi = $query->get()->groupBy('student_id');

        return view('dashboard.guru.rekap-absen', [
            'students' => $students,
            'absensi' => $absensi,
            'kelas' => $kelas,
            'tanggal' => $tanggal,
            'periode' => $periode,
        ]);
    }

    public function downloadQr($id)
    {
        $student = Student::findOrFail($id);
        $qr = QrCode::format('svg')->size(300)->generate($student->qr_code);

        return Response::make($qr, 200, [
            'Content-Type' => 'image/svg+xml',
            'Content-Disposition' => 'attachment; filename="qr-' . $student->nis . '.svg"',
        ]);
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
