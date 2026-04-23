<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class ParentController
{
    public function index()
    {
        $parents = User::where('role', 'parent')->with('childrenAsParent')->get();

        $students = User::where('role', 'student')
            ->whereDoesntHave('parentOfChild')
            ->get();

        return view('admin.parent', compact('parents', 'students'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'student_id' => 'required|array',
            'phone' => 'nullable|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'parent',
            'phone' => $request->phone,
        ]);


        foreach ($request->student_id as $id) {
            DB::table('parent_student')->insert([
                'student_id' => $id,
                'parent_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Parent and children linked successfully');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|min:4',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone' => 'nullable|string'
        ]);

        $user = User::findOrFail($request->id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Parent updated successfully');
    }

    public function destroy($id)
    {
        $parent = User::findOrFail($id);

        DB::table('parent_student')->where('parent_id', $id)->delete();

        $parent->delete();

        return redirect()->back()->with('success', 'Parent record removed successfully.');
    }
}
