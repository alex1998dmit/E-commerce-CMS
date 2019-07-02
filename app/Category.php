<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [
        'name', 'parent_id'
    ];

    public function product()
    {
        return $this->hasMany('App\Product');
    }

    public function childs() {
        return $this->hasMany('App\Category','parent_id','id') ;
    }
}
