<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    //
    protected $fillable = [
        'name',
    ];

    public function order()
    {
        return $this->hasMany('App\Order', 'status_id', 'id');
    }
}
