<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Photo;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductsCollection;

class ProductsController extends Controller
{
    public function index()
    {
        return new ProductsCollection(Product::paginate(10));
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return response()->json($product, 200);
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
            $photoUrl = url('/upload/products/' . $fileName);

            $photo = Photo::create([
                'product_id' => $product->id,
                'path' => $photoUrl,
            ]);
        }
        return new ProductResource($product);
    }
}
