<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatusesChangings extends Model
{
    protected $fillable = [
        'order_id', 'prev_status_id', 'new_status_id',
    ];
    //
    public function order()
    {
       return $this->belongsTo('App\Order');
    }
}
