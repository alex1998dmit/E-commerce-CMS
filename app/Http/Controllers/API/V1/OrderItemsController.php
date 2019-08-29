<?php

namespace App\Http\Controllers\API\V1;

use App\Order;
use App\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderItemsController extends Controller
{
    //
    public function update($item_id, Request $request)
    {
        $orderItem = OrderItem::findOrFail($item_id);
        $orderItem->product_id = $request->product_id;
        $orderItem->amount = $request->amount;
        $orderItem->save();
        $orderItem->product;
        $orderItem->product->category;
        $order = Order::findOrFail($orderItem->order_id);
        $order->sum = $order->calculateSum();
        $order->save();
        return $orderItem;
    }

    public function delete($item_id)
    {
        $orderItem = OrderItem::findOrFail($item_id);
        $order = Order::find($orderItem->order_id);
        $orderItem->delete();
        $order->sum = $order->calculateSum();
        $order->save();
        return response()->json(['message' => 'success delete'], 201);
    }

    public function store(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $orderItem = OrderItem::create([
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'amount' => $request->amount
        ]);
        $orderItem->product;
        $orderItem->product->category;

        $order->sum = $order->calculateSum();
        $order->save();
        return $orderItem;
    }
}
