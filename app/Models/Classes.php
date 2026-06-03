<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classes extends Model
{
    // Menggunakan 'classes' karena bawaan plural Laravel untuk Class sering bentrok dengan keyword PHP
    protected $table = 'classes';
    protected $fillable = [
        'course_id',
        'name',
        'schedule_start',
        'schedule_end',
    ];
    protected $casts = [
        'schedule_start' => 'datetime',
        'schedule_end' => 'datetime',
    ];
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
    Daftar siswa yang terdaftar di kelas ini
    */
    public function enrollments(): HasMany
    {
        return $this->hasMany(ClassEnrollment::class, 'class_id');
    }
    
    /**
    Sesi-sesi pertemuan mingguan/harian dari kelas ini
    */
    public function sessions(): HasMany
    {
        return $this->hasMany(ClassSession::class, 'class_id');
    }
}
