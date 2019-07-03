<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryWithProducts;

class OrdersController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return new CategoryCollection($categories);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'parent_id' => 'required|numeric|min:0'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['data'] = $validator->messages();
            return $response;
        }

        $category = Category::create($request->all());
        return response()->json($category, 201);
    }

    public function show(Category $category)
    {
        return new CategoryWithProducts($category);
    }
}
