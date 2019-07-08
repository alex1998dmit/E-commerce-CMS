<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Product;
use App\Photo;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductsCollection;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index',compact('products'));
    }

    public function trashed()
    {
        $products = Product::onlyTrashed()->get();
        return view('admin.categories.trashed',compact('products'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'category_id' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'required|min:3|max:1000',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Новый продукт добавлен');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return view('admin.products.edit',compact('product'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,  [
            'name' => 'required|min:3',
            'category_id' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'required|min:3|max:1000',
         ]);

         $product = Product::find($id);

         $product->name = $product->name;
         $product->category_id = $product->category_id;
         $product->price = $product->price;
         $product->description = $product->description;
         $product->save();
         return redirect()->route('products');
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
