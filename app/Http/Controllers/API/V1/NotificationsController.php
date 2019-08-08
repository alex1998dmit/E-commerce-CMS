<?php

namespace App\Http\Controllers\API\V1;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    //
    public function orders()
    {
        $orders = Order::where('isChecked', '=', False)->get();
        foreach($orders as $order) {
            $order->user;
            $order->product;
            $order->product->photo;
        }
        return $orders;
    }

    public function orderCheck($id)
    {
        $order = Order::find($id);
        $order->isChecked = true;
        $order->save();
        return $order;
    }

    public function checkAllOrders()
    {
        $orders = Order::where('isChecked', '=', False)->get();
        foreach ($orders as $order) {
            $order->isChecked = true;
            $order->save();
        }
        return $orders;
    }
}
