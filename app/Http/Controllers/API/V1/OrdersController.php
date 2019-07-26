<?php

namespace App\Http\Controllers\API\V1;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        foreach($orders as $order) {
            $order->user;
            $order->product;
            $order->product->category;
            $order->status;
        }
        return $orders;
    }

    public function single($id)
    {
        $order = Order::findOrFail($id);
        $order->user;
        $order->product;
        $order->product->category;
        $order->status;
        return $order;
    }

    public function withStatus($statusId)
    {
        $orders = Order::where('status_id', '=', $statusId)->get();
        return $orders;
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $order->update($request->all());
        return $order;
    }
}
