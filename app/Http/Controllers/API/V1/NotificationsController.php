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
        $orders = Order::where('is_checked', '=', False)->get();
        foreach($orders as $order) {
            $order->user;
            $items = $order->orderItems;
            foreach ($items as $item) {
                $item->product;
                $item->product->photo;
                $item->product->category;
            }
        }
        return $orders;
    }

    public function orderCheck($id)
    {
        $order = Order::find($id);
        $order->is_checked = true;
        $order->save();
        $order->user;
        $order->status;
        $order->orderHistory;
        $items = $order->orderItems;
        foreach ($items as $item) {
            $item->product;
            $item->product->photo;
            $item->product->category;
        }
        return $order;
    }

    public function checkAllOrders()
    {
        $orders = Order::where('is_checked', '=', False)->get();
        foreach ($orders as $order) {
            $order->is_checked = true;
            $order->save();
        }
        return $orders;
    }
}
