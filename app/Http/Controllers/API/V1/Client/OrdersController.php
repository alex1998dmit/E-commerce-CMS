<?php

namespace App\Http\Controllers\API\V1\Client;

use Auth;
use App\Order;
use App\OrderItem;
use App\OrderStatus;
use App\OrderStatusesChangings;
use App\Product;
use App\Events\NewOrder;
use App\Events\UpdateOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function update($orderId, Request $request)
    {
        $user = Auth::user();
        $permittedStatusesIds = [2, 7];
        $statusId = $request->status_id;
        if (in_array($statusId, $permittedStatusesIds)) {
            $order = Order::find($orderId);
            if ($order->user->id === $user->id) {
                $order->status_id = $statusId;
                $order->is_checked = false;

                if ($request->status_id) {
                    $orderHistory = OrderStatusesChangings::create([
                        'order_id' => $orderId,
                        'prev_status_id' => $order->status_id,
                        'new_status_id' => $request->status_id
                    ]);
                }

                $order->save();
                event(new UpdateOrder($this->single($order->id)));
                return $this->single($orderId);
            } else {
                return response()->json(['message' => 'wrong user'], 401);
            }
        } else {
            return response()->json(['message' => 'Unpermitted status id'], 403);
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $order = Order::create([
            'user_id' => $user->id,
            'sum' => $this->calculateSum($request->products, $user),
        ]);

        // dd($request->products);
        foreach ($request->products as $product) {
            $order_items = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product["id"],
                'amount' => $product["amount"],
            ]);
        }
        event(new NewOrder($this->single($order->id)));
        return $this->single($order->id);
    }

    public function single($id)
    {
        $order = Order::findOrFail($id);
        $order->user;
        $order->orderItems;
        foreach ($order->orderItems as $item) {
            $item->product->category;
            $item->product->photo;
        }
        $order->status;
        $historyItems = $order->orderHistory;
        foreach ($historyItems as $item) {
            $preveStatusName = OrderStatus::find($item->prev_status_id)->name;
            $newStatusName = OrderStatus::find($item->new_status_id)->name;
            $item->prevStatusName = $preveStatusName;
            $item->newStatusName = $newStatusName;
        }
        return $order;
    }

    public function calculateSum($products, $user)
    {
        $sum = 0;
        $user_discount = $user->discount->discount;
        foreach ($products as $product) {
            $price = Product::findOrFail($product["id"])->price;
            $sum = $sum + $price * $product["amount"];
        }
        $order_discount = $user_discount * $sum;
        return $sum - $order_discount;
    }

    public function index()
    {
        $user = Auth::user();
        $orders = $user->order;
        foreach ($orders as $order) {
            $items = $order->orderItems;
            $order->status;
            foreach ($items as $item) {
                $item->product;
                $item->product->category;
            }
        }
        return $orders;
    }
}
