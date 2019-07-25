<?php

namespace App\Http\Controllers\API\V1;

use App\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderStatuses extends Controller
{
    //
    public function index()
    {
        return OrderStatus::all();
    }
}
