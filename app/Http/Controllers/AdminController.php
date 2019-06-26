<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShoppingCart;
use App\Category;

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
}
