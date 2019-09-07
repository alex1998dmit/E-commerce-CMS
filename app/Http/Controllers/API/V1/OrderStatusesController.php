<?php

namespace App\Http\Controllers\API\V1;

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
        foreach ($statuses as $status) {
            $status->order;
        }
        return $statuses;
    }

    public function single($status_id)
    {
        $orders = Order::where('status_id', '=', $status_id)->paginate(5);
        $orderStatus = OrderStatus::find($status_id);
        foreach ($orders as $order) {
            $items = $order->orderItems;
            $order->user;
            foreach ($items as $item) {
                $item->product;
                $item->product->category;
            }
        }
        return ['status' => $orderStatus, 'orders' => $orders];
    }
}
