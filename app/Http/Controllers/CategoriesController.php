<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Category;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryWithProducts;
use App\Events\NewMessage;

class CategoriesController extends Controller
{
    public function update(Request $request, $id)
    {
        $this->validate($request,  [
            'name' => 'required',
            'parent_id' => 'required',
         ]);

         $category = Category::find($id);

         $category->name = $request->name;
         $category->parent_id = $request->parent_id;
         $category->save();
         return redirect()->route('categories');
    }

    public function create(Request $request)
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

    public function trash($id)
    {
        $category = Category::find($id);
        $category->delete();

        if ($category) {
            foreach($category->childs as $subcategory) {
                $subcategory->delete();
            }
            return redirect()->back();
        } else {
            abort(500);
        }
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->find($id);
        if (!is_null($category)) {
            $category->restore();
            return redirect()->route('categories');
        } else {
            return abort(500, 'Nothing to restore');
        }
    }
}
