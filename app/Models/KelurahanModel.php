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
        return $this->belongsTo(KotaModel::class, 'district_id');
    }
}
