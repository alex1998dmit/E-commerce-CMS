<?php

namespace App\Http\Controllers;

use Validator;
use App\Product;
use App\Photo;
use App\Category;
use Illuminate\Http\Request;
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

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|min:3',
            'category_id' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'required|min:3|max:1000',
            'photos' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        foreach($request->file('photos') as $key => $photo) {
            $name = $key . time() .  '.' . $photo->getClientOriginalName();
            $photo->move(public_path().'/upload/products/', $name);
            $product_photos[] = Photo::create([
                'product_id' => $product->id,
                'path' => $name,
            ]);
        }
        
        return redirect()->route('products');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        return view('admin.products.edit',compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {

        $validator = $request->validate([
            'name' => 'required|min:3',
            'category_id' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'required|min:3|max:1000',
        ]);

        $product = Product::find($id);
        $product_photos = $product->photo;

        $product->name = $product->name;
        $product->category_id = $product->category_id;
        $product->price = $product->price;
        $product->description = $product->description;
        $product->save();

        foreach($product_photos as $photo) {
            if (!in_array($photo->id, $request->uploaded_images)) {
                $photo->delete();
            }
        }

        if ($request->file('photos')) {
            foreach($request->file('photos') as $key => $photo) {
                $name = $key . time() .  '.' . $photo->getClientOriginalName();
                $photo->move(public_path().'/upload/products/', $name);
                $product_photos[] = Photo::create([
                    'product_id' => $product->id,
                    'path' => $name,
                ]);
            }
        }
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
