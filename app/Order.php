<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'product_id', 'user_id', 'amount', 'sum'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
