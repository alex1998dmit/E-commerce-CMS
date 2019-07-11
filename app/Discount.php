<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    //
    protected $fillable = [
        'product_id', 'user_id', 'amount', 'sum',
    ];

    public function user()
    {
        return $this->hasMany('App\User');
    }
}
