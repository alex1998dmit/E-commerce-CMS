<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requisite extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'account_num', 'description'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }
}
