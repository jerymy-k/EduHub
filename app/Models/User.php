<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'phone'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
        ];
    }

    public function classesAsTeacher(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'class_teacher', 'teacher_id', 'class_id')->where('classes.year', now()->year);
    }
    public function classesAsStudent(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'class_student', 'student_id', 'class_id')->where('classes.year', now()->year);
    }

    public function childrenAsParent(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'parent_student', 'parent_id', 'student_id');
    }

    public function parentOfChild()
    {
        return $this->belongsToMany(User::class, 'parent_student', 'student_id', 'parent_id');
    }
    
    public function activitiesAsTeacher(): HasMany
    {
        return $this->hasMany(Activity::class, 'teacher_id');
    }

    public function gradesAsStudent(): HasMany
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    public function absencesAsStudent(): HasMany
    {
        return $this->hasMany(Absence::class, 'student_id');
    }

    public function absencesAsTeacher(): HasMany
    {
        return $this->hasMany(Absence::class, 'teacher_id');
    }

    public function justifications(): HasMany
    {
        return $this->hasMany(Justification::class, 'submitted_by');
    }
}
