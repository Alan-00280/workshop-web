<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserCampus extends Model
{
    // Eksplisit mendefinisikan nama tabel karena struktur snake_case/plural khusus
    protected $table = 'user_campuses';
    protected $fillable = [
        'user_system_id',
        'tanggal_lahir',
        'no_hp',
        'nfc_uid',
    ];
    
    /**
    Relasi ke tabel bawaan users milik Laravel
    */
    public function userSystem(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_system_id');
    }

    /**
    Relasi One-to-One ke Student
    */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'user_campus_id');
    }

    /**
    Relasi One-to-One ke Teacher
    */
    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class, 'user_campus_id');
    }
}
