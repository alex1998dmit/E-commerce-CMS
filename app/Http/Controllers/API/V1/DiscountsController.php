<?php

namespace App\Http\Controllers\API\V1;

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

    public function index()
    {
        $dicounts = Discount::orderBy('created_at', 'desc')->get();
        return $this->getAllInfo($dicounts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $discount = Discount::create([
            'name' => $request->name,
            'discount' => $request->discount,
            'description' => $request->description
        ]);
        return $discount;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        $users = $discount->users;
        return $discount;
    }

    public function single($id)
    {
        return Discount::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $discount = Discount::findOrFail($id);
        $discount->update($request->all());
        $discount->save();
        return $discount;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
