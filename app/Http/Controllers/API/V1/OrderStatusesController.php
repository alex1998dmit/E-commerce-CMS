<?php

namespace App\Http\Controllers\API\V1;

use Validator;
use App\Order;
use App\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderStatusesController extends Controller
{
    //
    public function index()
    {
        $statuses = OrderStatus::all();
        $statuses->each(function ($status) {
            $status->order;
            return $status;
        });
        return $statuses;
    }

    public function single($status_id)
    {
        $orders = Order::where('status_id', '=', $status_id)->paginate(10);
        $orderStatus = OrderStatus::find($status_id);
        $orders->each(function ($order) {
            $order->user;
            $items = $order->orderItems;
            $items->map(function ($item) {
                $item->product;
                $item->product->category;
            });
            return $order;
        });
        return ['status' => $orderStatus, 'orders' => $orders];
    }
}
