<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananModel extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'idpesanan';
    protected $guarded = ['idpesanan'];
    public $timestamps = false;

    public function DetailPesanan()
    {
        return $this->hasMany(DetailPesananModel::class, 'idpesanan');
    }
}