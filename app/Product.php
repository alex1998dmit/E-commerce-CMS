<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'category_id', 'name', 'price', 'description'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function wishList()
    {
        return $this->hasMany('App\WishList', 'product_id', 'id');
    }

    public function shoppingCart()
    {
        return $this->hasMany('App\ShoppingCart');
    }

    public function order()
    {
        return $this->hasMany('App\Order');
    }

    public function photo()
    {
        return $this->hasMany('App\Photo');
    }

}
