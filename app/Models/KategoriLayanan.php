<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriLayanan extends Model
{
    protected $table = 'kategori_layanans';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function Kategori() {
        return $this->hasMany(Layanan::class, 'id_kategori');
    }
}
