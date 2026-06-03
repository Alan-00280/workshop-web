<?php

namespace App\Http\Controllers;

use App\Models\ClassEnrollment;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class StudentController extends Controller
{
    public function StoreStudent(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'no_hp' => 'required|string|max:12',
            'tanggal_lahir' => 'required|date',
            'program' => 'required|string|max:255',
            'nfc_uid' => 'required|string|unique:user_campuses,nfc_uid',
        ]);

        DB::beginTransaction();
        try {
            // Create user
            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('11223344'),
                'id_role' => 8, // student
            ]);

            // Create user campus
            $userCampus = \App\Models\UserCampus::create([
                'user_system_id' => $user->id,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_hp' => $request->no_hp,
                'nfc_uid' => $request->nfc_uid,
            ]);

            // Create student (no_induk will be auto filled by DB trigger if null)
            \App\Models\Student::create([
                'user_campus_id' => $userCampus->id,
                'program' => $request->program,
            ]);

            DB::commit();
            return redirect()->route('show-students')->with('success', 'Siswa berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan siswa: ' . $e->getMessage());
        }
    }

    // Enrollments POST Controller
    public function StoreEnrollments(Request $request) { 
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        DB::beginTransaction();
        try {
            $classId = $request->class_id;
            $now = now();

            foreach ($request->student_ids as $studentId) {
                // Avoid duplicate enrollment in the same class
                $exists = ClassEnrollment::where('class_id', $classId)
                    ->where('student_id', $studentId)
                    ->exists();
                
                if (!$exists) {
                    ClassEnrollment::create([
                        'class_id' => $classId,
                        'student_id' => $studentId,
                        'enrolled_at' => $now,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('show-students')->with('success', 'Siswa berhasil didaftarkan ke kelas!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat mendaftarkan siswa: ' . $e->getMessage());
        }
    }
}
