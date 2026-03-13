<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KecamatanModel extends Model
{
    protected $table = 'reg_districts';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function Kelurahan() {
        return $this->hasMany(KelurahanModel::class, 'district_id');
    }

    public function Kota() {
        return $this->belongsTo(KotaModel::class, 'regency_id');
    }
}
