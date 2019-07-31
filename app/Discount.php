<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'discount', 'description'
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
