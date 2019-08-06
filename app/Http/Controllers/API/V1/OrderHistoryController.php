<?php

namespace App\Http\Controllers\API\V1;

use App\Order;
use App\OrderStatus;
use App\OrderStatusesChangings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderHistoryController extends Controller
{
    //
    public function index($order_id)
    {
        $order = Order::find($order_id);
        $historyRecords = $order->orderHistory;
        foreach ($historyRecords as $record) {
            $record->prev_status = OrderStatus::find($record->prev_status_id);
            $record->cur_status = OrderStatus::find($record->new_status_id);
        }
        return $historyRecords;
    }
}
