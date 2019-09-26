<?php

namespace App\Http\Controllers\API\V1;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Discount;

class DiscountsController extends Controller
{
    public function getAllInfo($discounts)
    {
        return $discounts->map(function ($discount) {
            $discount->users;
            return $discount;
        });
    }

    public function single($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->users;
        return $discount;
    }

    public function index()
    {
        $dicounts = Discount::orderBy('created_at', 'desc')->get();
        return $this->getAllInfo($dicounts);
    }

    public function store(Request $request)
    {
        $validation =  Validator::make($request->all(), [
            'name' => 'required|string|min:0|max:64',
            'discount' => 'required|numeric|min:0|max:90',
            'description' => 'max:1000'
        ]);
        if ($validation->fails()) {
            return response()->json([
                'messages' => $validation->errors()
            ], 401);
        }

        $discount = Discount::create([
            'name' => $request->name,
            'discount' => $request->discount,
            'description' => $request->description
        ]);
        return $discount;
    }

    public function show(Discount $discount)
    {
        $users = $discount->users;
        return $discount;
    }

    public function update(Request $request, $id)
    {
        $validation =  Validator::make($request->all(), [
            'name' => 'string|min:0|max:64',
            'discount' => 'numeric|min:0|max:90',
            'description' => 'max:1000'
        ]);
        if ($validation->fails()) {
            return response()->json([
                'messages' => $validation->errors()
            ], 401);
        }

        $discount = Discount::findOrFail($id);
        $discount->update($request->all());
        $discount->save();
        return $discount;
    }

    public function trash($id, Request $request)
    {
        $newDiscountId = $request->new_discount_id ?? 1;
        $discount = Discount::findOrFail($id);
        $users = $discount->users;
        foreach ($users as $user) {
            $user->discount_id = $newDiscountId;
            $user->save();
        }
        $discount->delete();
        return response()->json(['mesasage' => 'succesfully deleted'], 200);
    }

}
