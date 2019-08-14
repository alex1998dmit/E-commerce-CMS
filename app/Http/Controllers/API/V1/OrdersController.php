<?php

namespace App\Http\Controllers\API\V1;

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
    public function index()
    {
        $orders = Order::paginate(5);
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
        $order->product->photo;
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
        if ($request->status_id) {
            $prev_status_id = $order->status_id;
            $new_status_id = $request->status_id;
            if ($prev_status_id !== $new_status_id) {
                $orderChanging = OrderStatusesChangings::create([
                    'order_id' => $id,
                    'prev_status_id' => $prev_status_id,
                    'new_status_id' => $new_status_id
                ]);
                $order->orderHistory()->save($orderChanging);
            }
            $order->status_id = $request->status_id;
        }
        $order->update($request->all());
        $order->save();
        return $this->single($order->id);
    }

    public function store(Request $request)
    {
        $order = Order::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'amount' => $request->amount,
            'sum' => $request->sum,
        ]);

        event(new NewOrder($this->single($order->id)));
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
}
