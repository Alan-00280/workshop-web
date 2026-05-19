<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $table = 'antrians';
    public $timestamps = true;
    protected $guarded = ['id'];


    public function Layanan() {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }
}
