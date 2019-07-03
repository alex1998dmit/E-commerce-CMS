<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\ShoppingCart;
use App\Http\Resources\ShoppingCartCollection;
use App\Events\AddProductToShoppingCart;

class ShoppingCartController extends Controller
{
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['opertor', 'admin']);
        $carts =ShoppingCart::all();
        return view('admin.usersCart.index')->with('carts', $carts);
    }
}
