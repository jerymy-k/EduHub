<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model // Note: 'Class' is reserved, using Class_
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'year',
    ];

    protected $casts = [
        'year' => 'integer',
    ];

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'class_teacher', 'class_id', 'teacher_id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'class_student', 'class_id', 'student_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }
}

