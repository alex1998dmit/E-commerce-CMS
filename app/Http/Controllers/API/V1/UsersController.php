<?php

namespace App\Http\Controllers\API\V1;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return User::with('role')->get();
        // return $users;
    }

    public function show($id)
    {
        $user = User::find($id);
        $user->role;
        $orders = $user->order;
        foreach ($orders as $order) {
            $product = $order->product;
            $status = $order->status;
            $category = $product->category;
        }
        return $user;
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->get();
        return $users;
    }

    // Soft delete
    public function trash()
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        if ($request->discount_id) {
            $user->discount_id = $request->discount_id;
            $user->save();
        }
        return $user;
    }

    public function replaceDiscountsIds(Request $request, $old_discount_id)
    {
        $new_discount_id = $request->new_discount_id;
        $users = User::where('discount_id', '=', $old_discount_id)->get();
        foreach ($users as $user) {
            $user->discount_id = $new_discount_id;
            $user->save();
        }
        return User::all();
    }

    public function search(Request $request)
    {
        $param = $request->param;
        $results = User::where('id', 'LIKE', '%' . $param . '%')
                        ->orWhere('name', 'LIKE', '%' . $param . '%')
                        ->orWhere('email', 'LIKE', '%' . $param . '%')->get();
        return $results;
    }
}
