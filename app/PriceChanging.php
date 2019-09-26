<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceChanging extends Model
{
    //
    protected $fillable = [
        'product_id', 'old_price', 'new_price'
    ];

    public function products()
    {
        return $this->belongsTo('App\Product');
    }
}
