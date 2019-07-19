<?php

namespace App\Http\Controllers\API\V1;

use App\Category;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();
        foreach ($products as $product) {
            $product->category;
            $atWhishLists = $product->wishList;
            $orders = $product->order;
            $product->addPhotosAttribute($product->photo);
        }
        return $products;
    }

    public function store(Request $request)
    {

    }

    public function single($id)
    {
        $product = Product::findOrFail($id);
        $product->category;
        $product->wishList;
        $product->order;
        $product->addPhotosAttribute($product->photo);
        return $product;
    }

    public function trash($id)
    {

    }

    public function update(Request $request, Category $category)
    {

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
}
