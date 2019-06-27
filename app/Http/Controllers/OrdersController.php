<?php

namespace App\Http\Controllers;

use Auth;
use App\Product;
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
        $user_orders = $user->order->pluck('product_id')->toArray();
        $products = Product::whereIn('id', $user_orders)->paginate(5);
        return new OrdersCollection($products);
    }
}
