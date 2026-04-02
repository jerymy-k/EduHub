<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function usersShow()
    {
        $currentYear = now()->year;

        $assignedTeacherIds = DB::table('class_teacher')->where('year', $currentYear)->pluck('teacher_id');

        $teachersNotAssigned = User::where('role', 'teacher')->whereNotIn('id', $assignedTeacherIds)->get();

        $studentWithNoParent = DB::table('users')
            ->where('role', 'student')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))->from('parent_student')->whereRaw('parent_student.student_id = users.id');
            })
            ->get();
        $classes = SchoolClass::get();

        $users = User::with(['classesAsTeacher', 'classesAsStudent', 'childrenAsParent'])->get();

        return view('admin.users', compact('users', 'teachersNotAssigned', 'studentWithNoParent', 'classes'));
    }
    public function createUser(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => ['required', 'string', 'max:255' , 'min:4'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:10'],
            'password' => ['required', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
        ]);
        if ($request->role === 'student' && $request->class_id) {
            $user->classesAsStudent()->attach($request->class_id, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        if ($request->role === 'parent' && $request->student_id) {
            $user->childrenAsParent()->attach($request->student_id, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect("admin/{$request->role}")->with('success', "{$user->role} created successfully: " . $user->name);
    }

    public function createClass(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'teacher_id' => ['required', 'exists:users,id', 'in:' . User::where('role', 'teacher')->pluck('id')->implode(',')],
        ]);

        $year = now()->year;

        // FIXED by BLACKBOXAI: Add error handling for class/attach
        try {
            $class = SchoolClass::create([
                'name' => $request->name,
                'year' => $year,
            ]);

            $class->teachers()->attach($request->teacher_id, [
                'year' => $year,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()
                ->back()
                ->with('success', "Class '{$request->name}' created for {$year} with teacher attached.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to create class. ' . $e->getMessage());
        }
    }
    public function associateChild(Request $request)
    {
        $request->validate([
            'parent_id' => ['required', 'exists:users,id', 'in:' . User::where('role', 'parent')->pluck('id')->implode(',')],
            'student_id' => ['required', 'exists:users,id', 'in:' . User::where('role', 'student')->pluck('id')->implode(',')],
        ]);

        try {
            $parent = User::findOrFail($request->parent_id);
            $parent->childrenAsParent()->attach($request->student_id, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Student associated with parent successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to associate student with parent. ' . $e->getMessage());
        }
    }
    public function removeChild(Request $request)
    {
        dd($request);
        try {
            $parent = User::findOrFail($request->parent_id);
            $parent->childrenAsParent()->detach($request->student_id);

            return redirect()->back()->with('success', 'Student removed from parent successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to remove student from parent. ' . $e->getMessage());
        }
    }
}
