<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorModel extends Model
{
    protected $table = 'vendor';
    protected $primaryKey = 'idvendor';
    protected $guarded = ['idvendor'];
    public $timestamps = false;

    public function Menu()
    {
        return $this->hasMany(MenuModel::class, 'idvendor');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'iduser');
    }
}