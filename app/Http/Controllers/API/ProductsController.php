<?php

namespace App\Http\Controllers\API;

use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductsCollection;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        foreach($products as $product) {
            $product->addPhotosAttribute($product->photo);
        }
        return new ProductsCollection($products);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(["message" => "Product doesn't exits"], 400);
        }
        return new ProductResource($product);
    }

    // ------------- NOT available for using now
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return response()->json($product, 200);
    }

    public function store(Request $request)
    {
        // TODO Добавить валидацию для файлов
        $rules = [
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|min:1',
            'price' => 'required|numeric|min:1',
            'description' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['data'] = $validator->messages();
            return $response;
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
                'path' => url('/upload/products/' . $fileName),
            ]);
        }
        return new ProductResource($product);
    }
}
