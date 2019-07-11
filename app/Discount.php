<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    //
    protected $fillable = [
        'name', 'discount', 
    ];

    public function user()
    {
        return $this->hasMany('App\User');
    }
}
