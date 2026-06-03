<?php

namespace App\Http\Controllers;

use App\Models\ClassSession;
use App\Models\ClassEnrollment;
use App\Models\Attendance;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseClassController extends Controller
{
    public function StoreClassSessions(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'materi' => 'required|string',
            'timestamp' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            // Create ClassSession
            $session = ClassSession::create([
                'class_id' => $request->class_id,
                'materi' => $request->materi,
                'timestamp' => $request->timestamp,
            ]);

            // Get all students enrolled in the class
            $enrollments = ClassEnrollment::where('class_id', $request->class_id)->get();

            // Create attendance record for each student
            foreach ($enrollments as $enrollment) {
                Attendance::create([
                    'class_session_id' => $session->id,
                    'student_id' => $enrollment->student_id,
                    'timestamp' => $request->timestamp, // Use same timestamp as session
                    'status' => 'ABSENT', // Default status is ABSENT
                ]);
            }

            DB::commit();
            return redirect()->route('show-class-sessions')->with('success', 'Sesi kelas baru dan data presensi berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat membuat sesi kelas: ' . $e->getMessage());
        }
    }

    public function StoreClass(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'schedule_start' => 'required|date',
            'schedule_end' => 'required|date|after:schedule_start',
        ]);

        Classes::create([
            'course_id' => $request->course_id,
            'name' => $request->name,
            'schedule_start' => $request->schedule_start,
            'schedule_end' => $request->schedule_end,
        ]);

        return redirect()->route('show-classes')->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function UpdateClass(Request $request, $id)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'schedule_start' => 'required|date',
            'schedule_end' => 'required|date|after:schedule_start',
        ]);

        $class = Classes::findOrFail($id);
        $class->update([
            'course_id' => $request->course_id,
            'name' => $request->name,
            'schedule_start' => $request->schedule_start,
            'schedule_end' => $request->schedule_end,
        ]);

        return redirect()->route('show-classes')->with('success', 'Kelas berhasil diperbarui!');
    }

    public function DeleteClass($id)
    {
        $class = Classes::findOrFail($id);
        $class->delete();

        return redirect()->route('show-classes')->with('success', 'Kelas berhasil dihapus!');
    }
}
