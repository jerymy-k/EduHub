<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Absence;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenceController
{

    public function index()
    {
        $teacher = Auth::user();

        $classe = SchoolClass::whereHas('teachers', function ($query) use ($teacher) {
            $query->where('users.id', $teacher->id);
        })->with('students')->first();

        if (!$classe) {
            return redirect()->back()->with('error', 'You are not assigned to any class.');
        }

        $todayAbsences = Absence::where('class_id', $classe->id)
            ->whereDate('date', now())
            ->pluck('student_id')
            ->toArray();

        return view('teacher.absence', compact('classe', 'todayAbsences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'absent_students' => 'nullable|array',
            'absent_students.*' => 'exists:users,id',
        ]);

        $teacherId = Auth::id();
        $classId = $request->class_id;
        $date = now()->format('Y-m-d');

        $allStudentIds = SchoolClass::find($classId)->students()->pluck('users.id')->toArray();

        $newAbsentList = $request->absent_students ?? [];

        foreach ($allStudentIds as $studentId) {
            if (in_array($studentId, $newAbsentList)) {
                Absence::firstOrCreate([
                    'student_id' => $studentId,
                    'class_id' => $classId,
                    'teacher_id' => $teacherId,
                    'date' => $date,
                ], [
                    'status' => 'unexcused'
                ]);
            } else {
                Absence::where('student_id', $studentId)
                    ->where('class_id', $classId)
                    ->whereDate('date', $date)
                    ->where('status', 'unexcused')
                    ->delete();
            }
        }

        return redirect()->back()->with('success', 'Attendance for today has been saved.');
    }
}
