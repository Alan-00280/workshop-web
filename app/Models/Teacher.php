<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'user_campus_id',
        'no_induk_teacher', // Diisi otomatis via DB trigger jika null
        'gelar',
    ];
    public function userCampus(): BelongsTo
    {
        return $this->belongsTo(UserCampus::class, 'user_campus_id');
    }
    /**
    Seorang pengajar/dosen bisa mengajar banyak Mata Kuliah
    */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'dosen_id');
    }
}
