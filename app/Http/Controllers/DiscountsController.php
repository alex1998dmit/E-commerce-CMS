<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discount;

class DiscountsController extends Controller
{
    //
    public function index()
    {
        $discounts = Discount::all();
        return view('admin.discounts.index', compact('discounts'));
    }

    public function create(Request $request)
    {
        return view('admin.discounts.create');
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|min:3',
            'discount' => 'required|numeric',
        ]);

        $discount = Discount::create([
            'name' => $request->name,
            'category_id' => $request->discount,
        ]);
        return redirect()->route('discounts');
    }


    public function show($id)
    {
        $discount = Discount::find($id);
        $users = $discount->user();
        return view('admin.discounts.show', compact('discount', 'users'));
    }

    public function edit($id)
    {
        
    }

    public function delete($id)
    {

    }
}
