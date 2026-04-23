<?php
namespace App\Http\Controllers;

use App\Models\Justification;
use App\Models\Absence;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function indexJustifications()
    {
        $justifications = Justification::with(['absence.student', 'absence.class_'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.justification.index', compact('justifications'));
    }

    public function updateJustification(Request $request, Justification $justification)
    {
        $request->validate(['status' => 'required|in:approved,refused']);
        $justification = Justification::find($justification->id);
        $justification->status = $request->status;
        $justification->save();

        $absence = Absence::find($justification->absence_id);
        $absence->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Statut mis à jour avec succès.');
    }
}
