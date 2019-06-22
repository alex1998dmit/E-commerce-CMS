<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use App\WishList;
use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\WishListCollection;


class WishListController extends Controller
{
    public function index()
    {
        // TODO работать без лишних моделей, возможно через посредников
        if (!Auth::user()) {
            return response()->json(['message' => 'you need to login'], 403);
        }
        $user = Auth::user();
        $user_wishlist = $user->wishList->pluck('product_id')->toArray();
        $products = Product::whereIn('id', $user_wishlist)->paginate(5);
        return new WishListCollection($products);
    }

    public function store(Request $request)
    {
        $wishList = WishList::where('product_id', $request->product_id)->first();
        if ($wishList) {
            return response()->json(['message' => 'you already have this product at your wishList'], 403);
        } else {
            $wishList = WishList::create([
                'product_id' => $request->product_id,
                'user_id' => Auth::id(),
            ]);
            return response()->json($wishList, 201);
        }
    }

    public function delete(WishList $wishList)
    {
        $user_id = Auth::id();
        if ($wishList->user_id === $user_id && $user_id) {
            $wishList->delete();
            return response()->json(null, 204);
        }
        return response()->json(['message' => 'Not from your wishList'], 403);
    }
}
