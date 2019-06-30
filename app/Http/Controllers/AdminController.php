<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\ShoppingCart;
use App\Category;
use App\Order;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // TODO сделать миддлвару и засунуть в конструктор
        $request->user()->authorizeRoles(['opertor', 'admin']);
        return view('admin.index');
    }

    public function fromCarts(Request $request)
    {
        $request->user()->authorizeRoles(['opertor', 'admin']);
        $carts =ShoppingCart::all();
        return view('admin.usersCart.index')->with('carts', $carts);
    }

    public function categories(Request $request)
    {
        $request->user()->authorizeRoles(['opertor', 'admin']);
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
