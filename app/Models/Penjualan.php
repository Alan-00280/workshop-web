<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $guarded = ['id_penjualan'];

    public function PenjualanDetail() {
        return $this->hasMany(PenjualanDetail::class, 'id_penjualan');
    }

}