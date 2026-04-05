<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesananModel extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'iddetail_pesanan';
    protected $guarded = ['iddetail_pesanan'];
    public $timestamps = false;

    public function Menu()
    {
        return $this->belongsTo(MenuModel::class, 'idmenu');
    }

    public function Pesanan()
    {
        return $this->belongsTo(PesananModel::class, 'idpesanan');
    }
}