<?php
namespace App\Http\Controllers\Teacher;

use App\Models\User;
use App\Models\EmailLog;
use App\Mail\ParentContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class TeacherContactController
{
    public function index()
    {
        /** @var User $teacher */
        $teacher = Auth::user();

        $students = User::whereHas('classesAsStudent', function ($query) use ($teacher) {
            $query->whereIn('classes.id', $teacher->classesAsTeacher->pluck('id'));
        })
            ->with('parentOfChild') // Using your defined inverse relationship
            ->get();
        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'You are not assigned to any class.');
        }
        return view('teacher.contact.index', compact('students'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $student = User::with('parentOfChild')->findOrFail($request->student_id);

        $parent = $student->parentOfChild->first();

        if (!$parent || !$parent->email) {
            return back()->with('error', "Impossible de trouver un parent ou une adresse email pour cet élève.");
        }

        try {
            Mail::to($parent->email)->send(new ParentContactMail(
                $request->subject,
                $request->message,
                Auth::user()->name
            ));

            EmailLog::create([
                'sender_id' => Auth::id(),
                'recipient_id' => $parent->id,
                'recipient_email' => $parent->email,
                'subject' => $request->subject,
                'body' => $request->message,
                'type' => 'manual',
            ]);

            return back()->with('success', 'Message envoyé avec succès au parent : ' . $parent->name);

        } catch (\Exception $e) {
            return back()->with('error', "Erreur lors de l'envoi de l'email.");
        }
    }
}
