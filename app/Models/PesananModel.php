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

    public const METODE_ID = [
        1 => 'credit_card',
        2 => 'gopay',
        3 => 'shopeepay',
        4 => 'bank_transfer',
        5 => 'qris',
    ];

    public function DetailPesanan()
    {
        return $this->hasMany(DetailPesananModel::class, 'idpesanan');
    }
}