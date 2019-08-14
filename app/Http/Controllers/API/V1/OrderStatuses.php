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
        $statuses = OrderStatus::all();
        foreach ($statuses as $status) {
            $status->order;
        }
        return $statuses;
    }

    public function single($id)
    {
        return OrderStatus::findOrFail($id);
    }
}
