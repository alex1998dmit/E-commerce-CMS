<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public $fillable = ['product_id', 'path'];
    //
    public function product()
    {
        $this->belongsTo('App\Product');
    }
}
