<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananModel extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'idpesanan';
    protected $guarded = ['idpesanan'];
    public $timestamps = false;

    public const METODE = [
        'credit_card' => 1,
        'gopay' => 2,
        'shopeepay' => 3,
        'bank_transfer' => 4,
        'qris' => 5,
    ];

    public function DetailPesanan()
    {
        return $this->hasMany(DetailPesananModel::class, 'idpesanan');
    }
}