<?php

namespace App\Http\Controllers\API\V1;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryWithProducts;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        foreach($categories as $category) {
            $childs = $category->childs;
        }
        return $categories;
    }

    public function finalCategories()
    {
        $categories = Category::all();
        $final_categories = [];
        foreach($categories as $category) {
            if (count($category->childs) === 0) {
                $final_categories[] = $category;
            }
        }
        return $final_categories;
        // return response()->json(['data' => $final_categories],200) ;
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

        if (!$category) {
            return response()->json("message ", 400);
        }

        return response()->json($category, 201);
    }

    // TODO Обработка ошибок с короткой записью
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(["message" => "Category doesn't exits"], 400);
        }
        return new CategoryWithProducts($category);
    }

    public function trash($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        if ($category) {
            foreach($category->childs as $subcategory) {
                $subcategory->delete();
            }
            return Category::all();
        } else {
            abort(500);
        }
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        $category->childs;
        return $category;
    }
}
