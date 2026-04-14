<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelurahanModel extends Model
{
    protected $table = 'reg_villages';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function Kecamatan() {
        return $this->belongsTo(KecamatanModel::class, 'district_id', 'id');
    }

    public function Customer() {
        return $this->hasMany(CustomerModel::class, 'kelurahan_id');
    }
}
