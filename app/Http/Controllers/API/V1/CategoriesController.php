<?php

namespace App\Http\Controllers\API\V1;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryWithProducts;

class CategoriesController extends Controller
{
    public function getAllInfo($categories)
    {
        return $categories->map(function ($category) {
            $category->childs;
            $products = $category->product;
            $products->map(function ($product) {
                $product->order;
                return $product;
            });
            return $category;
        });
    }

    public function single($id)
    {
        $category = Category::findOrFail($id);
        $category->childs;
        return $category;
    }

    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return $this->getAllInfo($categories);
    }

    public function finalCategories()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        $final_categories = $categories->filter(function($category) {
            if (count($category->childs) === 0) {
                return $category;
            }
        });
        return $final_categories;
    }

    public function trashed()
    {
        $categories = Category::onlyTrashed()->get();
        return $categories;
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->find($id);
        if (!is_null($category)) {
            $category->restore();
            return $category;
        } else {
            return response()->json(['message' => 'Nothing to restore'], 500);
        }
    }

    public function store(Request $request)
    {
        $validation =  Validator::make($request->all(), [
            'name' => 'required|string|min:0|max:64',
            'parent_id' => 'required|numeric|min:0'
        ]);
        if ($validation->fails()) {
            return response()->json([
                'messages' => $validation->errors()
            ], 401);
        }
        $category = Category::create($request->all());

        if (!$category) {
            return response()->json("Creating category error ", 400);
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
            return response()->json(['message' => 'Success Delete'], 200);
        } else {
            abort(500);
        }
    }

    public function delete($id)
    {
        // Cascade delete childs
        $category = Category::withTrashed()->where('id', $id)->first();
        if ($category) {
            $category->forceDelete();
            return response()->json(['message' => 'Success Delete'], 200);
        }
        return response()->json(['message' => 'Not found'], 500);
    }

    public function update(Request $request, Category $category)
    {
        $validation =  Validator::make($request->all(), [
            'name' => 'string|min:0|max:64',
            'parent_id' => 'numeric|min:0'
        ]);
        if ($validation->fails()) {
            return response()->json([
                'messages' => $validation->errors()
            ], 401);
        }
        $category->update($request->all());
        return $this->single($category->id);
    }
}
