<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    protected $table = 'penjualan_detail';
    protected $primaryKey = 'idpenjualan_detail';
    protected $guarded = ['idpenjualan_detail'];

    public function PenjualanDetail() {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }

}