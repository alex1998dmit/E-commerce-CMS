<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
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
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }
}
