<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Http\Requests;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(5);
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        // TODO поискать как это сделать используя отношения
        $orders = Order::where('user_id', $id)->paginate(10);
        return view('admin.users.show')->with('user', $user)
                                       ->with('orders', $orders);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit')->with('user', $user);
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function trash($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users');
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->get();
        return view('admin.users.trashed')->with('users', $users);
    }

    public function search(Request $request)
    {
        $param = $request->param;
        $users = User::where('name', 'LIKE', '%'.$param.'%')->orWhere('email','LIKE','%'.$param.'%')->get();
        return view('admin.users.search', compact('param', 'users'));
    }
}
