<?php

namespace App\Http\Controllers\API\V1;

use Auth;
use App\Order;
use App\Category;
use App\Product;
use App\User;
use App\Events\NewOrder;
use App\OrderStatusesChangings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function calculateSum($products, $user)
    {
        $sum = 0;
        $user_discount = $user->discount->discount;
        foreach ($products as $product) {
            $price = Product::find($product["id"])->price;
            $sum = $sum + $price * $product["amount"];
        }
        $order_discount = $user_discount * $sum;
        return $sum - $order_discount;
    }

    public function index()
    {
        $orders = Order::paginate(10);
        foreach($orders as $order) {
            $order->user;
            $order->orderItems;
            foreach ($order->orderItems as $item) {
                $item->product->category;
                $item->product->photo;
            }
            $order->status;
        }
        return $orders;
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
        $order->history = $order->orderHistory;
        return $order;
    }

    public function withStatus($statusId)
    {
        $orders = Order::where('status_id', '=', $statusId)->get();
        return $orders;
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->user_id = $request->user_id ?? $order->user_id;
        $order->sum = $request->sum ?? $order->sum;
        $order->status_id = $request->status_id ?? $order->status_id;
        $order->is_checked = $request->is_checked ?? $order->is_checked;
        $order->save();
        return $this->single($order->id);
    }

    public function store(Request $request)
    {
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
        // event(new NewOrder($this->single($order->id)));
        return $this->single($order->id);
    }

    public function search(Request $request)
    {
        $search_param = $request->search_param;
        $categoriesWithParam = Category::where('name', 'LIKE', '%' . $search_param . '%')->get();
        $usersWithParam = User::where('email', 'LIKE', '%' . $search_param . '%')->get();
        $productNames = Product::where('name', 'LIKE', '%' . $search_param . '%')->get();

        // dd($categoriesWithParam);
        $products_id = [];

        $ordersByCategoryName = [];
        $ordersByUserID = [];
        $ordersByProductName = [];

        // By categoryName
        foreach ($categoriesWithParam as $category) {
            foreach ($category->product as $product) {
                $products_id[] = $product->id;
            }
        }
        foreach ($products_id as $id) {
            $ordersByCategoryName[] = Order::where('product_id', '=', $id)->get();
        }
        // By User email
        foreach ($usersWithParam as $user) {
            $ordersByUserID[] = Order::where('user_id', '=', $user->id)->get();
            // dd(ordersByUserID);
        }
        // By product_name
        foreach ($productNames as $product) {
            $ordersByProductName[] = Order::where('product_id', '=', $product->id)->get();
        }

        return [
            'search_param' => $search_param,
            'byCategoryName' => $ordersByCategoryName,
            'byUserEmail' => $ordersByUserID,
            'byProductName' => $ordersByProductName,
        ];
    }

    public function trash($trash_id)
    {
        $order = Order::findOrFail($trash_id);
        $order->delete();
        return response()->json(['message' => 'successfully trashed'], 201);
    }
}
