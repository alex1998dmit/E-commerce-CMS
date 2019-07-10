<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\User;
Use App\Category;
use App\Product;
use App\Order;
use App\OrderStatus;
use App\Http\Resources\OrdersCollection;
use App\Http\Resources\OrderResource;
use App\Events\NewOrder;
use Illuminate\Http\Request;


class OrdersController extends Controller
{

    public $statuses = [
        'waiting for payment',
        'payment sent',
        'payment received',
        'waiting to be sent',
        'order sent',
        'waiting to receive',
        'order received'
    ];

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

    public function search(Request $request)
    {
        $users_id = [];
        $products_id = [];
        $param = $request->param;

        $users = User::where('name', 'LIKE', '%' . $param . '%')->get();
        foreach($users as $user) {
            $users_id[] = $user->id;
        }

        $products = Product::where('name', 'LIKE', '%' . $param . '%')->get();
        foreach($products as $product) {
            $products_id[] = $product->id;
        }

        $order_users = Order::whereIn('user_id', $users_id)->get();
        $order_products = Order::whereIn('product_id', $products_id)->get();
        $orders = (is_int($param)) ? Order::find($param) : [];
        return view('admin.orders.search', compact('orders', 'order_products', 'order_users', 'param'));
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
        return $this->changeStatus($this->statuses[0], $id);
    }

    public function paymentSent($id)
    {
        return $this->changeStatus($this->statuses[1], $id);
    }

    public function paymentReceived($id)
    {
        return $this->changeStatus($this->statuses[2], $id);
    }

    public function waintingToSent($id)
    {
        return $this->changeStatus($this->statuses[3], $id);
    }

    public function orderSent($id)
    {
        return $this->changeStatus($this->statuses[4], $id);
    }

    public function waitReceived($id)
    {
        return $this->changeStatus($this->statuses[5], $id);
    }

    public function orderReceived($id)
    {
        return $this->changeStatus($this->statuses[6], $id);
    }

    public function showWithStatus($status_id)
    {
        $status_name = OrderStatus::find($status_id)->name;
        $orders = Order::where('status_id', '=', $status_id)->get();
        return view('admin.orders.byStatus', compact('orders', 'status_name'));
    }
}
