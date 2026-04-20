<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absence;
use App\Models\Justification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentsController extends Controller
{
    public function index()
    {
        // Get children linked via the parent_student table
        $children = Auth::user()->childrenAsParent()->get();
        return view('parent.children.index', compact('children'));
    }

    public function showChild(User $child)
    {
        // Security check: Ensure this child belongs to the parent
        if (!Auth::user()->childrenAsParent->contains($child->id)) {
            abort(403);
        }

        $child->load(['gradesAsStudent.activity', 'absencesAsStudent.class_', 'absencesAsStudent.justification']);

        return view('parent.children.show', compact('child'));
    }

    public function storeJustification(Request $request, Absence $absence)
    {
        // 1. Block if a justification already exists (prevents SQL error)
        if (Justification::where('absence_id', $absence->id)->exists()) {
            return redirect()->back()->with('error', 'Déjà justifié.');
        }

        // 2. Validate
        $request->validate([
            'reason' => 'required|string|max:500',
            'document' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // 3. Save file and create record
        $path = $request->file('document')->store('justifications', 'public');

        Justification::create([
            'absence_id' => $absence->id,
            'submitted_by' => auth()->id(),
            'reason' => $request->reason,
            'document_path' => $path, // Ensure this matches your DB column name
            'status' => 'pending'
        ]);
        
        $absence->status = 'pending';
        $absence->save();

        return redirect()->back()->with('success', 'Justificatif envoyé.');
    }
}
