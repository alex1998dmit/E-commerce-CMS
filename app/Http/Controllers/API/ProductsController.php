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
}
