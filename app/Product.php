<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    protected $fillable = [
        'id', 'nama_barang', 'point'
    ];

    public function detail(){
        return $this->hasOne('App\Transaction');
    }
}
