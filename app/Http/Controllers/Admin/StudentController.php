<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class StudentController
{
    public function index () {
        $students = User::where('role' , 'student')->with('classesAsStudent')->get();
        $classes = SchoolClass::all();
        return view('admin/student' , compact('classes' , 'students'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:20', 'min:4'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:' . User::class],
            'password' => ['required', 'string', 'min:8', Password::default()],
            'classe_id' => ['required ', 'exists:classes,id'],
        ],[
            'classe_id'=> 'Create a classe first to add student',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        DB::table('class_student')->insert([
             'student_id' => $user->id,
             'class_id'=> $request->classe_id,
             'created_at' => now(),
             'updated_at'=> now(),
        ]);

        return redirect()->back()->with('success', 'Student Created successfully');
    }
    public function edit(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:20', 'min:4'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:users,email,' . $request->id],
            'class_id' => ['required', 'exists:classes,id'],
        ]);

        $user = User::findOrFail($request->id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        DB::table('class_student')
            ->where('student_id', $user->id)
            ->update([
                'class_id' => $request->class_id,
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Student updated successfully');
    }
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Student deleted successfully');
    }
}
