<?php

namespace App\Http\Controllers\Admin;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClasseController
{
    public function index()
    {
        $classes = SchoolClass::with(['teachers', 'students'])->where('year' , now()->year)->get();


        $allTeachers = User::where('role', 'teacher')->get();

        $teacherNotAssigned = User::where('role', 'teacher')
            ->whereDoesntHave('classesAsTeacher')
            ->get();

        return view('admin.classe', compact('classes', 'allTeachers', 'teacherNotAssigned'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'class_name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:users,id',
        ]);

        $classe = SchoolClass::create([
            'name' => $request->class_name,
            'year' => now()->year,
        ]);

        $classe->teachers()->attach($request->teacher_id, [
            'year' => now()->year,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        return redirect()->back()->with('success', 'Class added successfully.');
    }

    public function edit(Request $request)
{
    $request->validate([
        'id'         => 'required|exists:classes,id',
        'class_name' => 'required|string|max:255',
        'teacher_id' => 'required|exists:users,id',
    ]);

    $classe = SchoolClass::findOrFail($request->id);

    $classe->update(['name' => $request->class_name]);

    DB::table('class_teacher')
        ->where('teacher_id', $request->teacher_id)
        ->delete();

    $classe->teachers()->sync([$request->teacher_id]);

    return redirect()->back()->with('success', 'Class updated successfully.');
    }

    public function destroy($id)
    {
        $classe = SchoolClass::findOrFail($id);

        $classe->teachers()->detach();
        $classe->students()->detach();
        $classe->delete();

        return redirect()->back()->with('success', 'Class deleted successfully.');
    }
}
