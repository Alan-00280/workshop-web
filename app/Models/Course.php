<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'course_code',
        'name',
        'description',
        'dosen_id',
    ];
    /**
    Mata kuliah diampu oleh seorang Dosen/Teacher
    */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'dosen_id');
    }

    /**
    Satu Mata Kuliah bisa memiliki banyak implementasi Kelas Sesi/Grup
    */
    public function classes(): HasMany
    {
        return $this->hasMany(Classes::class, 'course_id');
    }
}
