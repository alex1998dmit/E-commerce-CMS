<?php

namespace App\Http\Controllers\API\v1\Client;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WishList;

class WishListController extends Controller
{
    public function getAllInfo($item)
    {
        $item->product;
        $item->product->photo;
        $item->product->category;
        return $item;
    }

    public function index()
    {
        // TODO работать без лишних моделей, возможно через посредников
        if (!Auth::user()) {
            return response()->json(['message' => 'you need to login'], 401);
        }
        $user = Auth::user();
        $wish_list_items = $user->wishList;
        foreach ($wish_list_items as $item) {
            $this->getAllInfo($item);
        }
        return $wish_list_items;
    }

    public function store(Request $request)
    {
        if (!Auth::user()) {
            return response()->json(['message' => 'you need to login'], 401);
        }

        $rules = [
            'product_id' => 'required|integer|min:1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['data'] = $validator->messages();
            return $response;
        }

        $wishList = WishList::where('product_id', $request->product_id)->first();
        if ($wishList) {
            return response()->json(['message' => 'you already have this product at your wishList'], 406);
        } else {
            $wishList = WishList::create([
                'product_id' => $request->product_id,
                'user_id' => Auth::id(),
            ]);
            return $this->getAllInfo($wishList);
        }
    }

    public function remove($id)
    {
        $wishList = WishList::findOrFail($id);
        if (!Auth::user()) {
            return response()->json(['message' => 'you need to login'], 401);
        }
        $user_id = Auth::id();
        if ($wishList->user_id === $user_id && $user_id) {
            $wishList->delete();
            return response()->json(null, 204);
        }
        return response()->json(['message' => 'Not from your wishList'], 403);
    }
}
