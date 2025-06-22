<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LeaveRequestController extends Controller
{
    // Tampilkan form pengajuan izin untuk orang tua
    public function create()
    {
        $parent = Auth::user()->parent;
        $student = $parent->student;

        return view('dashboard.orangtua.leave-request.create', compact('student'));
    }

    // Simpan pengajuan izin
    public function store(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'type' => 'required|in:sakit,izin',
            'reason' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $parent = Auth::user()->parent;
        $student = $parent->student;

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('leave-attachments', 'public');
        }

        LeaveRequest::create([
            'student_id' => $student->id,
            'parent_id' => $parent->id,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'type' => $request->type,
            'reason' => $request->reason,
            'attachment_path' => $attachmentPath,
            'status' => 'pending'
        ]);

        return redirect()->route('dashboard.orangtua.leave-request.index')
            ->with('success', 'Pengajuan izin berhasil dikirim');
    }

    // Daftar pengajuan izin untuk orang tua
    public function index()
    {
        $parent = Auth::user()->parent;
        $leaveRequests = LeaveRequest::where('parent_id', $parent->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.orangtua.leave-request.index', compact('leaveRequests'));
    }

    // Daftar pengajuan izin untuk guru
    public function indexForTeacher()
    {
        $guru = Auth::user()->guru;
        $kelas = $guru->kelas;

        $leaveRequests = LeaveRequest::whereHas('student', function ($q) use ($kelas) {
            $q->where('school_class_id', $kelas->id);
        })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.guru.leave-request.index', compact('leaveRequests'));
    }

    // Approve/Reject izin oleh guru
    public function approve(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string',
        ]);

        $leaveRequest->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        if ($request->status === 'approved') {
            $fromDate = $leaveRequest->from_date;
            $toDate = $leaveRequest->to_date;
            $currentDate = clone $fromDate;

            while ($currentDate <= $toDate) {
                if ($currentDate->dayOfWeek !== 0 && $currentDate->dayOfWeek !== 6) {
                    $existingAttendance = Attendance::where('student_id', $leaveRequest->student_id)
                        ->where('tanggal', $currentDate->format('Y-m-d'))
                        ->first();

                    if (!$existingAttendance) {
                        Attendance::create([
                            'student_id' => $leaveRequest->student_id,
                            'user_id' => Auth::id(),
                            'school_class_id' => $leaveRequest->student->school_class_id,
                            'tanggal' => $currentDate->format('Y-m-d'),
                            'status' => $leaveRequest->type,
                            'keterangan' => $leaveRequest->reason,
                        ]);
                    }
                }

                $currentDate->addDay();
            }
        }

        return redirect()->route('dashboard.guru.leave-request.index')
            ->with('success', 'Pengajuan izin berhasil diperbarui');
    }

    public function indexForPetugas()
    {
        // Petugas bisa melihat semua permintaan izin
        $leaveRequests = LeaveRequest::with(['student', 'student.kelas'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.petugas.leave-request.index', compact('leaveRequests'));
    }

    public function processByPetugas(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string',
        ]);

        $leaveRequest->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        if ($request->status === 'approved') {
            $fromDate = $leaveRequest->from_date;
            $toDate = $leaveRequest->to_date;
            $currentDate = clone $fromDate;

            while ($currentDate <= $toDate) {
                if ($currentDate->dayOfWeek !== 0 && $currentDate->dayOfWeek !== 6) {
                    $existingAttendance = Attendance::where('student_id', $leaveRequest->student_id)
                        ->where('tanggal', $currentDate->format('Y-m-d'))
                        ->first();

                    if (!$existingAttendance) {
                        Attendance::create([
                            'student_id' => $leaveRequest->student_id,
                            'user_id' => Auth::id(),
                            'school_class_id' => $leaveRequest->student->school_class_id,
                            'tanggal' => $currentDate->format('Y-m-d'),
                            'status' => $leaveRequest->type,
                            'keterangan' => $leaveRequest->reason,
                        ]);
                    }
                }

                $currentDate->addDay();
            }
        }

        return redirect()->route('dashboard.petugas.leave-request.index')
            ->with('success', 'Pengajuan izin berhasil diperbarui');
    }

    private function sendNotificationToParent(LeaveRequest $leaveRequest, bool $isApproved)
{
    $parent = $leaveRequest->student->parent;
    
    if ($parent && $parent->no_hp) {
        $statusText = $isApproved ? 'DISETUJUI' : 'DITOLAK';
        $pesan = "Pengajuan " . ucfirst($leaveRequest->type) . " untuk " . $leaveRequest->student->nama . 
                " pada tanggal " . $leaveRequest->from_date->format('d M Y');
        
        if ($leaveRequest->to_date->ne($leaveRequest->from_date)) {
            $pesan .= " - " . $leaveRequest->to_date->format('d M Y');
        }
        
        $pesan .= " telah " . $statusText;
        
        if (!empty($leaveRequest->notes)) {
            $pesan .= ". Catatan: " . $leaveRequest->notes;
        }
        
        try {
            \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => env('FONNTE_API_KEY')
            ])->asForm()->post('https://api.fonnte.com/send', [
                'target' => $parent->no_hp,
                'message' => $pesan,
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal kirim notifikasi: ' . $e->getMessage());
        }
    }
}
}
