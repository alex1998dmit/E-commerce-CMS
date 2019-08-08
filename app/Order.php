<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id', 'user_id', 'amount', 'sum', 'isChecked'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function status()
    {
        return $this->belongsTo('App\OrderStatus', 'status_id');
    }

    public function orderHistory()
    {
        return $this->hasMany('App\OrderStatusesChangings');
    }

    public function changeStatus($status)
    {
        $status_id = OrderStatus::where('name', '=', $status)->first()->id;
        $this->status_id = $status_id;
    }
}
