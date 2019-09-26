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
        $orders->map(function ($order) {
            $order->user;
            $items = $order->orderItems;
            $items->map(function ($item) {
                $item->product;
                $item->product->photo;
                $item->product->category;
                return $item;
            });
        });
        return $orders;
    }

    public function single($id)
    {
        $order = Order::find($id);
        $order->user;
        $items = $order->orderItems;
        $items->map(function ($item) {
            $item->product;
            $item->product->photo;
            $item->product->category;
            return $item;
        });
        return $order;
    }

    public function orderCheck($id)
    {
        $order = Order::find($id);
        $order->is_checked = true;
        $order->save();
        return $this->single($id);
    }

    public function checkAllOrders()
    {
        $orders = Order::where('is_checked', '=', False)->get();
        return $orders->map(function ($order) {
            $order->is_checked = true;
            $order->save();
            return $order;
        });
    }
}
