<?php

namespace App\Http\Controllers\API\V1\Client;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    //
    public function index()
    {
        return Product::paginate(10);
    }

    // Определенное число продуктов
    public function productsWithCustomPaginate($num)
    {
        return Product::paginate($num);
    }

    public function single($id)
    {
        $product = Product::findOrFail($id);
        $product->photo;
        $product->category;
        return $product;
    }

    public function similar($id)
    {
        $category_id = Product::find($id)->category_id;
        $products = Product::where('category_id', '=', $category_id)->where('id', '!=', $id)->take(3)->get();
        foreach($products as $product) {
            $product->photo;
            $product->category;
        }
        return $products;
    }

    public function search(Request $request)
    {
        $search_param = $request->search_param;
        $products = Product::where('name', 'LIKE', '%' . $search_param . '%')->paginate(3);
        foreach($products as $product) {
            $product->photo;
            $product->category;
        }
        return $products;
    }
}
