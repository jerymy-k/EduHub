<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class ParentController 
{
    /**
     * Display a listing of the parents with their linked children.
     */
    public function index()
    {
        // 1. Get parents and their linked children
        $parents = User::where('role', 'parent')->with('childrenAsParent')->get();

        // 2. Get ONLY students who are NOT yet linked to any parent
        $students = User::where('role', 'student')
            ->whereDoesntHave('parentOfChild') // This checks the relationship
            ->get();

        return view('admin.parent', compact('parents', 'students'));
    }

    /**
     * Store a newly created parent and link them to a student.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'student_id' => 'required|array', // Validate as an array
            'phone' => 'nullable|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'parent',
            'phone' => $request->phone,
        ]);

        // Loop through each selected student and link them to the parent
        foreach ($request->student_id as $id) {
            DB::table('parent_student')->insert([ // Or your parent_student pivot table
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
            'phone' => $request->phone, // Now updates phone number
        ]);

        return redirect()->back()->with('success', 'Parent updated successfully');
    }

    /**
     * Update the specified parent.
     */
    /**
     * Remove the parent from the database.
     */
    public function destroy($id)
    {
        $parent = User::findOrFail($id);

        // The pivot table entries will be deleted automatically if you have
        // ->onDelete('cascade') in your migration, otherwise delete manually:
        DB::table('parent_student')->where('parent_id', $id)->delete();

        $parent->delete();

        return redirect()->back()->with('success', 'Parent record removed successfully.');
    }
}
