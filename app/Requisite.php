<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requisite extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'title', 'requisite', 'description'
    ];
}
