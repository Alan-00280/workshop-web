<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanans';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function KategoriLayanan() {
        return $this->belongsTo(KategoriLayanan::class, 'id_kategori');
    }

    public function Antrian()
    {
        return $this->hasMany(Antrian::class, 'id_layanan');
    }
}
