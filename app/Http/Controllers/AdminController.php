<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\ShoppingCart;
use App\Category;
use App\Order;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // TODO сделать миддлвару и засунуть в конструктор
        $request->user()->authorizeRoles(['opertor', 'admin']);
        return view('admin.index');
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
