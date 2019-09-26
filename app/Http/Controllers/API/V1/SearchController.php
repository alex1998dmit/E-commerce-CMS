<?php

namespace App\Http\Controllers\API\V1;

use App\Order;
use App\User;
use App\Category;
use App\Product;
use App\Requisite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    //
    public function getAllInfoAboutOrders($orders)
    {
        return $orders->map(function ($order){
            $order->user;
            $order->status;
            $items = $order->orderItems;
            $items->map(function ($item) {
                $item->product->category;
                $item->product->photo;
                return $item;
            });
            return $order;
        });
    }

    public function getAllInfoAboutProducts($products)
    {
        return $products->map(function ($product) {
            $product->category;
            $product->requisites;
            $product->photo;
            $product->wishList;
            $product->orderItems;
            return $product;
        });
    }

    public function getAllInfoAboutUsers($users)
    {
        return $users->map(function ($user) {
            $user->role;
            $user->wishList;
            $user->order;
            $user->discount;
            return $user;
        });
    }

    public function getAllInfoAboutCategories($categories)
    {
        $categories = $categories->map(function ($category) {
            $category->childs;
            return $category;
        });
        return $categories;
    }

    public function index(Request $request)
    {
        $search_param = $request->search_param;
        // orders
        $orders = Order::where(function ($query) use ($search_param) {
            $query->whereHas('orderItems', function ($query) use ($search_param) {
                $query->whereHas('product', function ($query) use ($search_param) {
                    $query->where('name', 'LIKE', '%' . $search_param . '%');
                });
            })->orWhere(function ($query) use ($search_param) {
            $query->whereHas('user', function ($query) use ($search_param) {
                $query->where('email', 'LIKE', '%' . $search_param . '%');
                });
            });
        })->get();
        // products
        $products = Product::where(function ($query) use ($search_param) {
            $query->whereHas('category', function ($query) use ($search_param) {
                $query->where('name', 'LIKE', '%' . $search_param . '%');
            });
        })->orWhere('name', 'LIKE', '%' . $search_param . '%')->get();
        // users
        $users = User::where('name', 'LIKE', '%' . $search_param . '%')->orWhere('email', 'LIKE', '%' . $search_param . '%')->get();
        // categories
        $categories = Category::where('name', 'LIKE', '%' . $search_param . '%')->get();
        // requisites
        $requisites = Requisite::where('title', 'LIKE', '%' . $search_param . '%')->orWhere('account_num', 'LIKE', '%' . $search_param . '%')->get();
        return [
            'orders' => $this->getAllInfoAboutOrders($orders),
            'products' => $this->getAllInfoAboutProducts($products),
            'users' => $this->getAllInfoAboutUsers($users),
            'categories' => $this->getAllInfoAboutCategories($categories),
            'requisites' => $requisites
        ];
    }
}
