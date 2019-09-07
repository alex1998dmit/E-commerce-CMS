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
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        foreach ($products as $product) {
            $product->category;
            $product->requisites;
            $product->photo;
            $product->wishList;
            $product->orderItems;
        }
        return $products;
    }

    public function store(Request $request)
    {
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

    public function addRequisitesToProduct($product_id, Request $request)
    {
        $product = Product::findOrFail($product_id);
        $requisites = $request->requisites;
        foreach ($requisites as $requisite) {
            $hasRequisite = $product->requisites()->where('requisite_id', '=', $requisite["id"])->exists();
            if (!$hasRequisite) {
                $product->requisites()->attach($requisite["id"]);
            }
        }
        return $this->single($product->id);
    }

    public function deleteRequisitesFromProduct($product_id, Request $request)
    {
        $product = Product::findOrFail($product_id);
        foreach ($request->requisites as $requisite) {
            $hasRequisite = $product->requisites()->where('requisite_id', '=', $requisite["id"])->exists();
            if ($hasRequisite) {
                $product->requisites()->detach($requisite["id"]);
            }
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

    public function search(Request $request) {
        $search_param = $request->query('param');
        $products_by_name = Product::where('name', 'LIKE', '%' . $search_param . '%')->get();
        $products_by_category_name = [];
        // $products_by_id = [];

        // $products_by_id = Product::where('id', 'LIKE', '%' . $search_param . '%')->get();
        $category_names = Category::where('name', 'LIKE', '%' . $search_param . '%')->get();
        foreach ($category_names as $category) {
            $products_by_category_name = Product::where('category_id', 'LIKE', '%' . $category->id . '%')->get();
        }

        return [
            'by_name' => $this->getAllInfoOfProducts($products_by_name),
            'by_category_name' => $this->getAllInfoOfProducts($products_by_category_name),
            // 'by_product_id' => $this->getAllInfoOfProducts($products_by_id)
        ];
    }

    public function getAllInfoOfProducts($products)
    {
        foreach ($products as $product) {
            $product->category;
            $product->requisites;
            $product->photo;
            $product->wishList;
            $product->orderItems;
        }
        return $products;
    }

    public function findByProductName(Request $request)
    {
        $search_param = $request->search_param;
        $products = Product::where('name', 'LIKE', '%' . $search_param . '%')->get();
        return $this->getAllInfoOfProducts($products);
    }
}
