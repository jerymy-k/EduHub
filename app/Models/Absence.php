<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'student_id',
        'teacher_id',
        'date',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function class_(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function justification(): HasOne
    {
        return $this->hasOne(Justification::class);
    }
}

