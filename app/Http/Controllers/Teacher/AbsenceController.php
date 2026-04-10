<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Absence;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenceController
{
    /**
     * Show the attendance sheet for the teacher's class.
     */
    public function index()
    {
        $teacher = Auth::user();

        // 1. Get the class assigned to this teacher
        // Assuming your SchoolClass has a teacher_id or a relationship
        $classe = SchoolClass::whereHas('teachers', function ($query) use ($teacher) {
            $query->where('users.id', $teacher->id);
        })->with('students')->first();

        if (!$classe) {
            return redirect()->back()->with('error', 'You are not assigned to any class.');
        }

        // 2. Get existing absences for today so we can "check" them in the view
        $todayAbsences = Absence::where('class_id', $classe->id)
            ->whereDate('date', now())
            ->pluck('student_id')
            ->toArray();

        return view('teacher.absence', compact('classe', 'todayAbsences'));
    }

    /**
     * Save or Update the attendance for today.
     */
    public function store(Request $request)
    {
        $request->validate([
            'absent_students' => 'nullable|array',
            'absent_students.*' => 'exists:users,id',
        ]);

        $teacherId = Auth::id();
        $classId = $request->class_id;
        $date = now()->format('Y-m-d');

        // Logic:
        // We look at who is currently marked absent in the database for today.
        // If a student is NOT in the new list ($request->absent_students), we delete the absence.
        // If a student IS in the list but not in DB, we create the absence.

        // 1. Get all students in this class
        $allStudentIds = SchoolClass::find($classId)->students()->pluck('users.id')->toArray();

        // 2. Identify the students checked as "Absent" in the form
        $newAbsentList = $request->absent_students ?? [];

        foreach ($allStudentIds as $studentId) {
            if (in_array($studentId, $newAbsentList)) {
                // Should be absent: create record if it doesn't exist
                Absence::firstOrCreate([
                    'student_id' => $studentId,
                    'class_id' => $classId,
                    'teacher_id' => $teacherId,
                    'date' => $date,
                ], [
                    'status' => 'unexcused'
                ]);
            } else {
                // Should be present: delete any unexcused absence record for today
                Absence::where('student_id', $studentId)
                    ->where('class_id', $classId)
                    ->whereDate('date', $date)
                    ->where('status', 'unexcused') // Only delete if not already justified
                    ->delete();
            }
        }

        return redirect()->back()->with('success', 'Attendance for today has been saved.');
    }
}
