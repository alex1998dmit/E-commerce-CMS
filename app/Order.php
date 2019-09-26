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

    public function orderItems()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function calculateSum()
    {
        $old_sum = $this->sum;
        $sum = 0;
        $user_discount = $this->user->discount->discount;
        $order_items = $this->orderItems;
        foreach ($order_items as $item) {
            $sum = $sum + $item->product->price * $item->amount;
        }
        $order_discount = ($user_discount * $sum)/100;
        $result = $sum - $order_discount;
        if ($result < 0) {
            abort(500, "Result are less than 0");
            return $old_sum;
        }
        return $result;
    }
}
