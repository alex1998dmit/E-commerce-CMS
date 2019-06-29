<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShoppingCart;
use App\Category;
use App\Order;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function fromCarts()
    {
        $carts =ShoppingCart::all();
        return view('admin.usersCart.index')->with('carts', $carts);
    }

    public function categories()
    {
        $categories = Category::where('parent_id', '=', 0)->get();
        $allCategories = Category::all();
        return view('admin.categories.index',compact('categories','allCategories'));
    }

    public function orders()
    {
        $orders = Order::all();
        return view('admin.orders.index')->with('orders', $orders);
    }

    public function trashedOrders()
    {
        $orders = Order::onlyTrashed()->get();
        return view('admin.orders.trashed')->with('orders', $orders);
    }
}
