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

    // TODO заменить на что-то более лучшее, по-моему использовать так методы нельзя
    protected $photos = [];

    // TODO Проверить семантическую верность приема
    // protected $appends = ['photos'];

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

    public function addPhotosAttribute($photos)
    {
        foreach ($photos as $photo) {
            $this->photos = $photo;
        }
    }

    public function getPhotosAttribute()
    {
        return $this->photos;
    }
}
