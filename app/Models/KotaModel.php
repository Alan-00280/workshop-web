<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KotaModel extends Model
{
    protected $table = 'reg_regencies';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function Kecamatan() {
        return $this->hasMany(KecamatanModel::class, 'regency_id');
    }

    public function Provinsi() {
        return $this->belongsTo(ProvinsiModel::class, 'province_id');
    }
}
