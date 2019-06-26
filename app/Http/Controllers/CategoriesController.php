<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryWithProducts;

use App\Events\NewMessage;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        event(new NewMessage("Hello"));
        return new CategoryCollection($categories);
    }

    public function store(Request $request)
    {
        $category = Category::create($request->all());
        return response()->json($category, 201);
    }

    public function show(Category $category)
    {
        return new CategoryWithProducts($category);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        return response()->json($category, 200);
    }

    public function delete(Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }

    public function addCategory(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $input = $request->all();
        $parent_id = empty($input['parent_id']) ? 0 : $input['parent_id'];
        $category = Category::create([
            'name' => $request->name,
            'parent_id' => $parent_id
        ]);
        return back()->with('success', 'Новая категория добавлена');
    }
}
