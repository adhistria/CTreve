<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = [
        'user_id', 'id', 'product_id'
    ];

    public function detailProduct(){
        return $this->belongsTo('App\Product');
    }
}
