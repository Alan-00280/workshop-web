<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'idbuku';
    protected $guarded = ['id'];
    
    public function KategoriBuku() {
        return $this->belongsTo(Kategori::class, 'idkategori');
    }
}
