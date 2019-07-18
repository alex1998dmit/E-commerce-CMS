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
            $photos = $product->getPhotosAttribute();
        }
        return $products;
    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {

    }

    public function trash($id)
    {

    }

    public function update(Request $request, Category $category)
    {

    }
}
