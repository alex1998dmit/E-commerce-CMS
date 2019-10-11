<?php

namespace App\Http\Controllers\API\V1;

use Validator;
use Auth;
use App\Order;
use App\Product;
use App\User;
use App\OrderStatusesChangings;
use App\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function calculateSum($products, $user)
    {
        $sum = 0;
        $user_discount = $user->discount->discount;
        $products->map(function ($product) use ($sum) {
            $price = Product::find($product["id"])->price;
            $sum = $sum + $price * $product["amount"];
        });
        $order_discount = $user_discount * $sum;
        $result = $sum - $order_discount;
        if ($result <= 0) {
            return response()->json(['message' => 'Sum are equal or less than zero'], 500);
        }
        return $result;
    }

    public function getAllInfo($orders)
    {
        $orders->each(function ($order) {
            $order->user;
            $order->status;
            $items = $order->orderItems;
            $items->map(function ($item) {
                $item->product->category;
                $item->product->photo;
                return $item;
            });
            return $order;
        });
        return $orders;
    }

    public function index()
    {
        $orders = Order::orderBy('is_checked', 'asc')->orderBy('created_at', 'desc')->paginate(10);
        return $this->getAllInfo($orders);
    }

    public function single($id)
    {
        $order = Order::findOrFail($id);
        $order->user;
        $order->user->discount;
        $order->status;
        $items = $order->orderItems;
        $items->map(function ($item) {
            $item->product->category;
            $item->product->photo;
            return $item;
        });

        $historyItems = $order->orderHistory;
        $historyItems->map(function ($item) {
            $preveStatusName = OrderStatus::find($item->prev_status_id)->name;
            $newStatusName = OrderStatus::find($item->new_status_id)->name;
            $item->prevStatusName = $preveStatusName;
            $item->newStatusName = $newStatusName;
            return $item;
        });

        return $order;
    }

    public function withStatus($statusId)
    {
        $orders = Order::where('status_id', '=', $statusId)->get();
        return $orders;
    }

    public function update(Request $request, $id)
    {
        $validation =  Validator::make($request->all(), [
            'order_id' => 'numeric|min:1',
            'prev_status_id' => 'numeric|min:1',
            'new_status_id' => 'numeric|min:1',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'messages' => $validation->errors()
            ], 401);
        }

        $order = Order::findOrFail($id);
        $order->user_id = $request->user_id ?? $order->user_id;
        $order->sum = $request->sum ?? $order->sum;
        $order->is_checked = $request->is_checked ?? $order->is_checked;
        if ($request->status_id) {
            $orderHistory = OrderStatusesChangings::create([
                'order_id' => $id,
                'prev_status_id' => $order->status_id,
                'new_status_id' => $request->status_id
            ]);
        }
        $order->status_id = $request->status_id ?? $order->status_id;
        $order->save();
        return $this->single($order->id);
    }

    public function store(Request $request)
    {
        $validation =  Validator::make($request->all(), [
            'order_id' => 'required|numeric|min:1',
            'prev_status_id' => 'required|numeric|min:1',
            'new_status_id' => 'required|numeric|min:1',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'messages' => $validation->errors()
            ], 401);
        }

        $user = Auth::user();
        $order = Order::create([
            'user_id' => $user->id,
            'sum' => $this->calculateSum($request->products, $user),
        ]);

        foreach ($request->products as $product) {
            $order_items = ([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'amount' => $product->amount,
            ]);
        }
        return $this->single($order->id);
    }

    public function trash($trash_id)
    {
        $order = Order::findOrFail($trash_id);
        $order->delete();
        return response()->json(['message' => 'successfully trashed'], 201);
    }

    public function filter(Request $request)
    {
        $validation =  Validator::make($request->all(), [
            'order_id' => 'numeric|min:1',
            'search_param' => 'string|min:1',
            'min_price' => 'numeric|min:1',
            'max_price' => 'numeric|min:1',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'messages' => $validation->errors()
            ], 401);
        }

        if ($request->has('order_id')) {
            return $this->getAllInfo(Order::where('id', '=', $request->order_id)->paginate(1));
        }

        if ($request->has('search_param')) {
            $orders = Order::where(function ($query) use ($request) {
                $query->whereHas('orderItems', function ($query) use ($request) {
                    $query->whereHas('product', function ($query) use ($request) {
                        $query->where('name', 'LIKE', '%' . $request->search_param . '%');
                    });
                })->orWhere(function ($query) use ($request) {
                $query->whereHas('user', function ($query) use ($request) {
                    $query->where('email', 'LIKE', '%' . $request->search_param . '%');
                    });
                });
            });
        } else {
            $orders = new Order;
        }

        if ($request->has('min_price') || $request->has('max_price')) {
            $min_price = $request->min_price ?? 0;
            $max_price = $request->max_price ?? 10000000;
            $orders = $orders->whereBetween('sum', [$min_price, $max_price]);
        }

        return $this->getAllInfo($orders->paginate(10));
    }

    public function filterByPrice($min, $max)
    {
        $orders = Order::where('price', '>', $min)->where('price', '<', $max)->paginate(10);
        return $this->getAllInfo($orders);
    }
}
