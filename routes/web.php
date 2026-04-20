<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ClasseController;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\Teacher\AbsenceController;
use App\Http\Controllers\Teacher\GradeController;
use App\Http\Controllers\Teacher\TeacherContactController;
use App\Http\Controllers\Student\StudentsController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Teacher;
use App\Http\Middleware\Student;
use App\Http\Middleware\Parents;

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

});

Route::middleware(['auth', Admin::class])->group(function () {

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/teachers', [TeacherController::class, 'index']);
    Route::post('/admin/teacher-add', [TeacherController::class, 'store'])->name('teacher-add');
    Route::post('/admin/teacher-edit', [TeacherController::class, 'edit'])->name('teacher-edit');
    Route::delete('/admin/teacher-delete/{id}', [TeacherController::class, 'destroy'])->name('teacher-delete');

    Route::get('/admin/students', [StudentController::class, 'index']);
    Route::post('/admin/student-add', [StudentController::class, 'store'])->name('student-add');
    Route::post('/admin/student-edit', [StudentController::class, 'edit'])->name('student-edit');
    Route::delete('/admin/student-delete/{id}', [StudentController::class, 'destroy'])->name('student-delete');

    Route::get('/admin/classes', [ClasseController::class, 'index']);
    Route::post('/admin/classe-add', [ClasseController::class, 'store'])->name('classe-add');
    Route::post('/admin/classe-edit', [ClasseController::class, 'edit'])->name('classe-edit');
    Route::delete('/admin/classe-delete/{id}', [ClasseController::class, 'destroy'])->name('classe-delete');

    Route::get('/admin/parents', [ParentController::class, 'index'])->name('parent-index');
    Route::post('/parent-add', [ParentController::class, 'store'])->name('parent-add');
    Route::post('/parent-edit', [ParentController::class, 'update'])->name('parent-edit');
    Route::delete('/parent-delete/{id}', [ParentController::class, 'destroy'])->name('parent-delete');

    Route::get('admin/justifications', [AdminController::class, 'indexJustifications'])->name('admin.justifications.index');
    Route::patch('admin/justifications/{justification}', [AdminController::class, 'updateJustification'])->name('admin.justifications.update');
});

Route::middleware(['auth', Teacher::class])->group(function () {
    Route::get('teacher/absences', [AbsenceController::class, 'index'])->name('absences.index');
    Route::post('teacher/add-absence', [AbsenceController::class, 'store'])->name('absence.add');

    Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');
    Route::post('/activity/store', [GradeController::class, 'storeActivity'])->name('activity.store');
    Route::get('/grades/enter/{activity}', [GradeController::class, 'enterGrades'])->name('grades.enter');
    Route::post('/grades/store/{activity}', [GradeController::class, 'storeGrades'])->name('grades.store');

    Route::get('teacher/messages', [TeacherContactController::class, 'index'])->name('teacher.contact.index');
    Route::post('/contacter-parents', [TeacherContactController::class, 'send'])->name('teacher.contact.send');
});

Route::middleware(['auth', Parents::class])->group(function () {
    Route::get('parent/children', [ParentsController::class, 'index'])->name('parent.children');
    Route::get('/children/{child}', [ParentsController::class, 'showChild'])->name('parent.child.show');
    Route::post('/absence/{absence}/justify', [ParentsController::class, 'storeJustification'])->name('parent.absence.justify');

});

Route::middleware(['auth', Student::class])->group(function () {
    Route::get('/student/grades', [StudentsController::class, 'myGrades'])->name('student.grades');
    Route::get('/student/absences', [StudentsController::class, 'myAbsences'])->name('student.absences');

});

Route::fallback(function () {
    return view('404');
});

require __DIR__ . '/auth.php';


