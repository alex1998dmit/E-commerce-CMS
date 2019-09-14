<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [
        'category_id', 'name', 'price', 'description',
    ];

    public function requisites()
    {
        return $this->belongsToMany('App\Requisite');
    }

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

    public function orderItems()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function priceChangings()
    {
        return $this->hasMany('App\PriceChanging');
    }

    public function photo()
    {
        return $this->hasMany('App\Photo');
    }
}
