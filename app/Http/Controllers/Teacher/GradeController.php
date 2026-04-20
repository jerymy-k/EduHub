<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Activity;
use App\Models\Grade;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController
{
    /**
     * Show the grades management dashboard for the teacher.
     */
    public function index()
    {
        $teacher = Auth::user();

        // Get classes assigned to this teacher
        $classes = $teacher->classesAsTeacher()->get();

        // Get activities created by this teacher with their class info
        $activities = Activity::where('teacher_id', $teacher->id)
            ->with('class_')
            ->latest()
            ->get();

        return view('teacher.grade.index', compact('classes', 'activities'));
    }

    /**
     * Step 1: Create a new Activity (Exam/Quiz).
     */
    public function storeActivity(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'date' => 'required|date',
            'max_score' => 'required|numeric|min:0',
        ]);

        Activity::create([
            'teacher_id' => Auth::id(),
            'class_id' => $request->class_id,
            'title' => $request->title,
            'type' => $request->type,
            'date' => $request->date,
            'max_score' => $request->max_score,
        ]);

        return redirect()->back()->with('success', 'Activity created! You can now enter grades.');
    }

    /**
     * Step 2: Show the entry form for a specific activity's grades.
     */
    public function enterGrades($activityId)
    {
        $activity = Activity::with(['class_.students', 'grades'])->findOrFail($activityId);

        // Ensure this teacher owns the activity
        if ($activity->teacher_id !== Auth::id()) {
            abort(403);
        }

        return view('teacher.grade.enter', compact('activity'));
    }

    /**
     * Save the scores for all students.
     */
    public function storeGrades(Request $request, $activityId)
    {
        $activity = Activity::findOrFail($activityId);

        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'nullable|numeric|min:0|max:' . $activity->max_score,
        ]);

        foreach ($request->grades as $studentId => $score) {
            if ($score !== null) {
                Grade::updateOrCreate(
                    ['student_id' => $studentId, 'activity_id' => $activityId],
                    ['score' => $score, 'date' => now()]
                );
            }
        }

        return redirect()->route('grades.index')->with('success', 'Grades updated successfully!');
    }
}
