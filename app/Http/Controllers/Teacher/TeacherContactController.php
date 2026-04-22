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

        // 1. Get all students belonging to the classes this teacher teaches
// Using your classesAsTeacher relationship defined in User model
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

        // 2. Access the parent via your parentOfChild() relationship
        $parent = $student->parentOfChild->first();

        if (!$parent || !$parent->email) {
            return back()->with('error', "Impossible de trouver un parent ou une adresse email pour cet élève.");
        }

        try {
            // 3. Send the Email
            Mail::to($parent->email)->send(new ParentContactMail(
                $request->subject,
                $request->message,
                Auth::user()->name
            ));

            // 4. Log the manual email in your email_logs table
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
