<?php

namespace App\Http\Controllers\API\V1;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class eUsersController extends Controller
{
    public function getAllInfo($users)
    {
        $users->each(function ($user) {
            $user->role;
            $user->wishList;
            $user->order;
            $user->discount;
        });
        return $users;
    }

    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return $this->getAllInfo($users);
    }

    public function single($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->role;
        $user->wishList;
        $user->order;
        $user->discount;
        return $user;
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->get();
        return $users;
    }

    // Soft delete
    public function trash($user_id)
    {
        $user = User::find($user_id);
        $user->delete();
        return response()->json(['message' => 'Succefully deleted'], 201);
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);
        if (!is_null($user)) {
            $user->restore();
            return $this->single($user->id);
        } else {
            return abort(500, 'Nothing to restore');
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        if ($request->discount_id) {
            $user->discount_id = $request->discount_id;
            $user->save();
        }
        return $this->single($user->id);
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
        $param = $request->search_param;
        $users = User::where('id', 'LIKE', '%' . $param . '%')
                        ->orWhere('name', 'LIKE', '%' . $param . '%')
                        ->orWhere('email', 'LIKE', '%' . $param . '%')->get();
        return $this->getAllInfo($users);
    }
}
