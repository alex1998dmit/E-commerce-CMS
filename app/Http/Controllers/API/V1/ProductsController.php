<?php

namespace App\Http\Controllers\API\V1;

use DB;
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
        $products = Product::all();
        foreach ($products as $product) {
            $product->category;
            $product->requisites;
            $atWhishLists = $product->wishList;
            $orders = $product->order;
            $product->addPhotosAttribute($product->photo);
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

    public function postProductsRequsites($product_id, Request $request)
    {
        $product = Product::findOrFail($product_id);
        $requisite_id = $request->requisite_id;
        // TODO Поменять на более красивое
        $requisites = DB::table('product_requisite')->where('requisite_id', '=', $requisite_id)->where('product_id', '=', $product_id)->first();

        if ($requisites) {
            return response()->json('already exists', 400);
        }

        $product->requisites()->attach($requisite_id);
        $requisite = Requisite::find($requisite_id);
        $requisite->products;
        return response()->json(['product' => $this->single($product_id), 'requisite' => $requisite], 201);
    }

    public function single($id)
    {
        $product = Product::findOrFail($id);
        $product->category;
        $product->wishList;
        $product->order;
        $product->requisites;
        $product->addPhotosAttribute($product->photo);
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
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

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
}
