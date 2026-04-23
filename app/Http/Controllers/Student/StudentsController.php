<?php

namespace App\Http\Controllers\Student;

use App\Models\Absence;
use App\Models\SchoolClass;
use App\Models\User;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentsController
{
    public function myGrades()
    {
        $student = Auth::user();

        // Fetch grades with their associated activity and teacher info
        $grades = Grade::where('student_id', $student->id)
            ->with([
                'activity' => function ($query) {
                    $query->select('id', 'title', 'type', 'max_score', 'teacher_id');
                }
            ])
            ->orderBy('date', 'desc')
            ->get();

        $average = $grades->avg('score');

        return view('student.grade.index', compact('grades', 'average'));
    }
    public function myAbsences()
    {
        $student = Auth::user();

        $absences = Absence::where('student_id', $student->id)
            ->with(['class_', 'teacher'])
            ->orderBy('date', 'desc')
            ->get();

        $totalAbsences = $absences->count();
        $unexcusedCount = $absences->where('status', 'unexcused')->count();

        return view('student.absence.index', compact('absences', 'totalAbsences', 'unexcusedCount'));
    }
}
