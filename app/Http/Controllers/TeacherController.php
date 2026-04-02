<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class TeacherController extends Controller
{
    public function index()
    {
        $year = now()->year;
        $teachers = User::where('role', 'teacher')->with('classesAsTeacher')->get();
        $classes = SchoolClass::where('year', $year)->get();
        // dd($teachers);
        return view('admin/teacher', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:20', 'min:4'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:' . User::class],
            'password' => ['required', 'string', 'min:8', Password::default()],
            'phone' => ['required', 'string', 'size:10'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Teacher Created successfully');
    }

    public function edit(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:20', 'min:4'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:' . User::class],
            'phone' => ['required', 'string', 'size:10'],
        ]);
        User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        return redirect()->back()->with('success', 'Teacher Updated successfully');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Teacher deleted successfully');
    }
}
