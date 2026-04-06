<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'idmenu';
    protected $guarded = ['idmenu'];
    public $timestamps = false;

    public function Vendor()
    {
        return $this->belongsTo(VendorModel::class, 'idvendor');
    } 

    public function DetailPesanan()
    {
        return $this->hasMany(DetailPesananModel::class, 'idmenu');
    }
}