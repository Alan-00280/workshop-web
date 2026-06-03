<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'user_campus_id',
        'no_induk', // Diisi otomatis via DB trigger jika null
        'program',
    ];
    public function userCampus(): BelongsTo
    {
        return $this->belongsTo(UserCampus::class, 'user_campus_id');
    }

    /**
    Relasi ke pendaftaran kelas (pembungkus relasi Many-to-Many ke Classes)
    */
    public function enrollments(): HasMany
    {
        return $this->hasMany(ClassEnrollment::class, 'student_id');
    }
    
    /**
    Riwayat kehadiran siswa
    */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }
}
