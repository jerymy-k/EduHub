<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ParentController;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    Route::get('/admin/teachers' , [TeacherController::class , 'index']);
    Route::post('/admin/teacher-add' , [TeacherController::class , 'store'])->name('teacher-add');
    Route::post('/admin/teacher-edit', [TeacherController::class, 'edit'])->name('teacher-edit');
    Route::delete('/admin/teacher-delete/{id}', [TeacherController::class, 'destroy'])->name('teacher-delete');

    Route::get('admin/students' , [StudentController::class , 'index']);



    Route::get('/admin/classes' , [ClasseController::class , 'index']);
    Route::post('/admin/classe-add' , [ClasseController::class , 'store'])->name('classe-add');
    Route::post('/admin/classe-edit' , [ClasseController::class , 'edit'])->name('classe-edit');
    Route::delete('/admin/classe-delete/{id}' , [ClasseController::class , 'destroy'])->name('classe-delete');



    Route::get('admin/parents' , [ParentController::class , 'index']);

});

require __DIR__ . '/auth.php';
