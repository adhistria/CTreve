<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{

    protected $fillable = [
        'id', 'product_id'
    ];
    public function transaction()
    {
        return $this->belongsTo('App\Transaction');
    }

    public function product()
    {
        return $this->has('App\Product');
    }
}
