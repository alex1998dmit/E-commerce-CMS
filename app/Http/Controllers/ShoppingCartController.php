<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\ShoppingCart;
use App\Http\Resources\ShoppingCartCollection;
use App\Events\AddProductToShoppingCart;

class ShoppingCartController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        if (!$user_id) {
            return response()->json(['message' => 'you need to login'], 403);
        }
        $productsFromCart = ShoppingCart::where('user_id', $user_id)->get();
        return new ShoppingCartCollection($productsFromCart);
    }

    public function store(Request $request)
    {
        // TODO remove to construct user_id ?
        $user_id = Auth::id();
        $productFromCart = ShoppingCart::where('product_id', $request->product_id)->first();
        if ($productFromCart) {
            $productFromCart->amount++;
            $productFromCart->save();
        } else {
            $productFromCart = ShoppingCart::create([
                'user_id' => $user_id,
                'product_id' => $request->product_id,
                'amount' => 1,
            ]);
        }
        event(new AddProductToShoppingCart($productFromCart));
        return response()->json($productFromCart, 200);
    }

    public function delete(ShoppingCart $shoppingCart)
    {
        $user_id = Auth::id();
        if ($shoppingCart->user_id === $user_id && $user_id) {
            $shoppingCart->delete();
            return response()->json(null, 204);
        }
        return response()->json(['message' => 'Not from your shoppingCart'], 403);
    }

    public function update(Request $request, ShoppingCart $shoppingCart)
    {
        $user_id = Auth::id();
        if (!$shoppingCart) {
            return response()->json(['message' => 'invalid id'], 400);
        }
        if ($shoppingCart->user_id != $user_id) {
            return response()->json(['message' => 'Not from your shoppingCart'], 403);
        }
        $shoppingCart->update($request->all());
        return response()->json($shoppingCart, 200);
    }
}
