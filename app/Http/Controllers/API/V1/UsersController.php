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

    public function update()
    {

    }

    public function delete()
    {

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
