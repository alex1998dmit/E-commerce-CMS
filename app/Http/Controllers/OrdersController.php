<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Product;
use App\Order;
use App\Http\Resources\OrdersCollection;
use App\Http\Resources\OrderResource;
use App\Events\NewOrder;
use Illuminate\Http\Request;


class OrdersController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'you need to login'], 403);
        }
        $orders = $user->order;
        return new OrdersCollection($orders);
    }

    public function store(Request $request)
    {
        $rules = [
            'product_id' => 'required|integer',
            'amount' => 'required|integer|min:1'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['data'] = $validator->messages();
            return $response;
        }
        // TODO обдумать систему скидок, как реализовать на сервере
        $price = Product::find($request->product_id)->price;
        $order = Order::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'sum' => $price * $request->amount,
        ]);
        event(new NewOrder($order));
        return response()->json($order, 201);
    }

    public function show(Order $order)
    {
        if (Auth::id() !== $order->user_id) {
            return response()->json(['message' => 'not you order'], 403);
        }
        return new OrderResource($order);
    }

    public function permanentDelete($id)
    {
        $order = Order::destroy($id);
        if ($order) {
            return redirect()->back();
        } else {
            abort(500);
        }
    }

    public function delete($id)
    {
        $order = Order::destroy($id);
        if ($order) {
            return redirect()->back();
        } else {
            abort(500);
        }
    }
}
