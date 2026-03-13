<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvinsiModel extends Model
{
    protected $table = 'reg_provinces';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function Kota() {
        return $this->hasMany(KotaModel::class, 'province_id');
    }
}
