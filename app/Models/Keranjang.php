<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'idkeranjang';
    protected $guarded = ['idkeranjang'];
    public $timestamps = false;

    public function Menu()
    {
        return $this->belongsTo(MenuModel::class, 'idmenu');
    }
}