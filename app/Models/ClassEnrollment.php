<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassEnrollment extends Model
{
    protected $table = 'class_enrollments';
    protected $fillable = [
        'class_id',
        'student_id',
        'enrolled_at',
    ];
    protected $casts = [
        'enrolled_at' => 'datetime',
    ];
    
    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
