<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassSession extends Model
{
    protected $table = 'class_sessions';
    protected $fillable = [
        'class_id',
        'timestamp',
        'materi',
    ];
    protected $casts = [
        'timestamp' => 'datetime',
    ];
    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
    /**
    Satu sesi kelas menghasilkan banyak baris data tap presensi siswa
    */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'class_session_id');
    }
}
