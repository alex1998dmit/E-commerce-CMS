<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Product;
use App\Order;
use App\OrderStatus;
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

    public function restore($id)
    {
        $order = Order::onlyTrashed()->find($id);
        if (!is_null($order)) {
            $order->restore();
            return redirect()->route('orders');
        } else {
            return abort(500, 'Nothing to restore');
        }
    }

    // Change order statuses
    public function changeStatus($status, $order_id)
    {
        $user = Auth::user();
        $order = Order::find($order_id);

        if ($user->id === $order->user->id) {
            $order->status_id = OrderStatus::where('name', '=', $status)->first()->id;
            $order->save();
            // TODO добавить ивент на обновление
            return response()->json(['message' => 'Status changed to ' . $order->status->name], 202);
        }

        return response()->json(['message' => 'Not your order'], 403);
    }

    // TODO сделать через объект Order ... public function paymentWaiting(Order $order)
    public function paymentWaiting($id)
    {
        return $this->changeStatus('waiting for payment', $id);
    }

    public function paymentSent($id)
    {
        return $this->changeStatus('payment sent', $id);
    }

    public function paymentReceived($id)
    {
        return $this->changeStatus('payment received', $id);
    }

    public function waintingToSent($id)
    {
        return $this->changeStatus('waiting to be sent', $id);
    }

    public function orderSent($id)
    {
        return $this->changeStatus('payment sent', $id);
    }

    public function waitReceived($id)
    {
        return $this->changeStatus('waiting to receive', $id);
    }

    public function orderReceived($id)
    {
        return $this->changeStatus('order received', $id);
    }
}
