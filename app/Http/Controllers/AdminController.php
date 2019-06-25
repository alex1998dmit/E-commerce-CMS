<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShoppingCart;

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
}
