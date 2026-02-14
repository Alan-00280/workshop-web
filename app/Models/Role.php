<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id_role';
    protected $guarded = ['id_role'];
    public $timestamps = false;

    public function User() {
        return $this->hasMany(User::class, 'id_role');
    }
}
