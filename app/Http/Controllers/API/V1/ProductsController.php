<?php

namespace App\Http\Controllers\API\V1;

use DB;
use App\PriceChanging;
use App\Photo;
use App\Category;
use App\Product;
use App\Requisite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function getAllInfoOfProducts($products)
    {
        $products->each(function ($product) {
            $product->category;
            $product->requisites;
            $product->photo;
            $product->wishList;
            $product->orderItems;
        });
        return $products;
    }

    public function findByProductName(Request $request)
    {
        $search_param = $request->search_param;
        $products = Product::where('name', 'LIKE', '%' . $search_param . '%')->get();
        return $this->getAllInfoOfProducts($products);
    }

    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return $this->getAllInfoOfProducts($products);
    }

    public function store(Request $request)
    {
        $validation =  Validator::make($request->all(), [
            'name' => 'required|string|min:1|max:64',
            'category_id' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
            'description' => 'required|string|min:1|max:1000',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'messages' => $validation->errors()
            ], 401);
        }

        $photos= $request->file('photo');

        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        foreach($photos as $key => $photo){
            $fileName =  $key . time() .  '.' . $photo->getClientOriginalExtension();
            $path = $photo->move(public_path('/upload/products'), $fileName);

            $photo = Photo::create([
                'product_id' => $product->id,
                'path' => $fileName,
            ]);
        }
        return $this->single($product->id);
    }

    public function single($id)
    {
        $product = Product::findOrFail($id);
        $product->category;
        $product->wishList;
        $product->orderItems;
        $product->requisites;
        $product->photo;
        $product->priceChangings;
        return $product;
    }

    public function trash($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'deleted success'], 201);
    }

    public function update(Request $request, $product_id)
    {
        $validation =  Validator::make($request->all(), [
            'name' => 'string|min:1|max:64',
            'category_id' => 'numeric|min:1',
            'price' => 'numeric|min:1',
            'description' => 'string|min:1|max:1000',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'messages' => $validation->errors()
            ], 401);
        }

        $product = Product::findOrFail($product_id);
        $old_price = $product->price;
        $new_price = $request->price;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if ($old_price !== $new_price) {
            $priceChanging = PriceChanging::create([
                'product_id' => $product_id,
                'old_price' => $old_price,
                'new_price' => $new_price
            ]);
            $product->priceChangings()->save($priceChanging);
        }

        if ($request->file('photo')) {
            foreach($request->file('photo') as $key => $photo) {
                $name = $key . time() .  '.' . $photo->getClientOriginalName();
                $photo->move(public_path().'/upload/products/', $name);
                $product_photos[] = Photo::create([
                    'product_id' => $product->id,
                    'path' => $name,
                ]);
            }
        }

        return $this->single($product_id);
    }

    public function removeImage(Request $request) {
        $image_id = $request->image_id;
        $product_id = $request->product_id;

        $product = Product::findOrFail($product_id);
        $product_images = $product->photo;
        foreach($product_images as $photo) {
            if ($image_id == $photo->id) {
                $photo->delete();
                return response()->json(['data' => $this->single($product_id)], 202);
            }
        }
        return response()->json('nothing to delete', 400);
    }

    public function search(Request $request)
    {
        $products = Product::where('name', 'LIKE', '%' . $request->param . '%')->orWhere(function ($query) use ($request) {
            $query->whereHas('category', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->param . '%');
            });
        })->get();
        return $this->getAllInfoOfProducts($products);
    }

}
