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
        $auth = Auth::user();
        $user = User::find($auth->id);
        $children = $user->childrenAsParent()->get();
        return view('parent.children.index', compact('children'));
    }

    public function showChild(User $child)
    {
        if (!Auth::user()->childrenAsParent->contains($child->id)) {
            abort(403);
        }

        $child->load(['gradesAsStudent.activity', 'absencesAsStudent.class_', 'absencesAsStudent.justification']);

        return view('parent.children.show', compact('child'));
    }

    public function storeJustification(Request $request, Absence $absence)
    {
        if (Justification::where('absence_id', $absence->id)->exists()) {
            return redirect()->back()->with('error', 'Déjà justifié.');
        }

        $request->validate([
            'reason' => 'required|string|max:500',
            'document' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $path = $request->file('document')->store('justifications', 'public');

        Justification::create([
            'absence_id' => $absence->id,
            'submitted_by' => auth()->id,
            'reason' => $request->reason,
            'document_path' => $path, 
            'status' => 'pending'
        ]);

        $absence->status = 'pending';
        $absence->save();

        return redirect()->back()->with('success', 'Justificatif envoyé.');
    }
}
