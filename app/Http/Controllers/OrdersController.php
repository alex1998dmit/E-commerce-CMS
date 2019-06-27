<?php

namespace App\Http\Controllers;

use Auth;
use App\Product;
use App\Order;
use App\Http\Resources\OrdersCollection;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'you need to login'], 403);
        }
        $orders = $user->order;
        // $user_orders = $user->order->pluck('product_id')->toArray();
        // $products = Product::whereIn('id', $user_orders)->paginate(5);
        return new OrdersCollection($orders);
    }

    public function store(Request $request)
    {
        // TODO обдумать систему скидок, как реализовать на сервере
        $price = Product::find($request->product_id)->first()->price;
        $order = Order::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'sum' => $price * $request->amount,
        ]);
        return response()->json($order, 201);
    }
}
