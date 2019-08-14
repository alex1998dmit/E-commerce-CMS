<?php

namespace App\Http\Controllers\API\V1\Client;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    //
    public function index()
    {
        return Category::all();
    }

    public function single($category_id)
    {
        $category = Category::find($category_id);
        $category->final_sub_categories = $this->final($category_id);
        return $category;
    }

    public function final($category_id)
    {
        $categories = Category::findOrFail($category_id)->childs;
        $final_categories = [];
        function iter($categories) {
            global $final_categories;
            foreach ($categories as $category) {
                if (count($category->childs) === 0) {
                    $final_categories[$category->name]['id'] = $category->id;
                    $final_categories[$category->name]['name'] = $category->name;
                    $final_categories[$category->name]['products'] = $category->product;
                    foreach($category->product as $product) {
                        $product->photo;
                    }
                }
                else {
                    iter($category->childs);
                }
            }
            return $final_categories;
        }
        return iter($categories);
    }

    public function products($category_id)
    {
        // $category = Category::findOrFail($category_id);
        $products = Product::where('category_id', '=', $category_id)->paginate(3);
        // $products = $category->product;
        foreach ($products as $product) {
            $product->photo;
        }
        return $products;
    }
}
