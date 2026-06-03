<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\UserCampus;
use App\Models\Student;
use App\Models\ClassSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Toggle status kehadiran secara manual (AJAX / POST)
     */
    public function ToggleManualAttendance(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        
        // Toggle status
        $attendance->status = ($attendance->status === 'PRESENT') ? 'ABSENT' : 'PRESENT';
        $attendance->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $attendance->status,
                'message' => 'Status kehadiran berhasil diubah menjadi ' . ($attendance->status === 'PRESENT' ? 'Hadir' : 'Absen')
            ]);
        }

        return back()->with('success', 'Status kehadiran berhasil diperbarui!');
    }

    /**
     * Menangani presensi via scan kartu NFC
     */
    public function ScanNFC(Request $request, $sessionId)
    {
        $request->validate([
            'nfc_uid' => 'required|string',
        ]);

        $nfcUid = $request->nfc_uid;

        // Cari UserCampus berdasarkan NFC UID
        $userCampus = UserCampus::where('nfc_uid', $nfcUid)->first();

        if (!$userCampus) {
            return response()->json([
                'success' => false,
                'message' => 'Kartu NFC tidak dikenali atau belum terikat dengan akun siswa mana pun.'
            ], 404);
        }

        // Dapatkan data Student yang terhubung
        $student = $userCampus->student;

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Kartu terdeteksi sebagai non-siswa (Kemungkinan akun pengajar/admin).'
            ], 400);
        }

        // Cari record Attendance untuk siswa ini di sesi ini
        $attendance = Attendance::where('class_session_id', $sessionId)
            ->where('student_id', $student->id)
            ->first();

        if (!$attendance) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa ' . ($userCampus->userSystem->name ?? '-') . ' tidak terdaftar dalam kelas pertemuan sesi ini.'
            ], 403);
        }

        // Update status menjadi PRESENT jika sebelumnya ABSENT
        if ($attendance->status === 'PRESENT') {
            return response()->json([
                'success' => true,
                'already_present' => true,
                'name' => $userCampus->userSystem->name ?? '-',
                'message' => 'Siswa ' . ($userCampus->userSystem->name ?? '-') . ' sudah tercatat hadir sebelumnya.'
            ]);
        }

        $attendance->status = 'PRESENT';
        $attendance->save();

        return response()->json([
            'success' => true,
            'already_present' => false,
            'name' => $userCampus->userSystem->name ?? '-',
            'nim' => $student->no_induk,
            'program' => $student->program,
            'attendance_id' => $attendance->id,
            'message' => 'Presensi berhasil! ' . ($userCampus->userSystem->name ?? '-') . ' hadir.'
        ]);
    }
}
