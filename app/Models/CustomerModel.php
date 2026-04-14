<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $casts = [
        'kelurahan_id' => 'string',
    ];
    public $timestamps = false;

    public function kelurahan()
    {
        return $this->belongsTo(KelurahanModel::class, 'kelurahan_id', 'id');
    }
}
