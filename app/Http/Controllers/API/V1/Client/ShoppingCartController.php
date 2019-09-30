<?php

namespace App\Http\Controllers\API\V1\Client;

use Auth;
use Validator;
use App\ShoppingCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShoppingCartController extends Controller
{
    //
    public function getAllInfo($item)
    {
        $item->product;
        $item->product->category;
        $item->product->photo;
        return $item;
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'you need to login'], 403);
        }
        $productsFromCart = $user->shoppingCart;
        foreach ($productsFromCart as $item) {
            $this->getAllInfo($item);
        }
        return $productsFromCart;
    }

    public function store(Request $request)
    {
        $rules = [
            'product_id' => 'required|integer|min:1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['data'] = $validator->messages();
            return $response;
        }

        // TODO remove to construct user_id ?
        $user_id = Auth::id();
        $productFromCart = ShoppingCart::where('product_id', $request->product_id)->where('user_id', '=', $user_id)->first();
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
        return $this->getAllInfo($productFromCart);
    }

    public function delete($shoppingCartId)
    {
        $user_id = Auth::id();
        $shoppingCart = ShoppingCart::find($shoppingCartId);
        if ($shoppingCart->user_id === $user_id && $user_id) {
            $shoppingCart->delete();
            return response()->json(null, 204);
        }
        return response()->json(['message' => 'Not from your shoppingCart'], 403);
    }

    public function update(Request $request, $shoppingCartId)
    {
        $shoppingCart = ShoppingCart::find($shoppingCartId);
        $user_id = Auth::id();
        if (!$shoppingCart) {
            return response()->json(['message' => 'invalid id'], 400);
        }
        if ($shoppingCart->user_id != $user_id) {
            return response()->json(['message' => 'Not from your shoppingCart'], 403);
        }
        $shoppingCart->update($request->all());
        return $this->getAllInfo($shoppingCart);
    }
}
