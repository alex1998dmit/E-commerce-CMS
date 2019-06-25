<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AddProductToShoppingCart implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $product;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($cart)
    {
        $arr = [
            'username' => $cart->user->name,
            'email' => $cart->user->email,
            'productName' => $cart->product->name,
            'amount' => $cart->amount,
            'category' => $cart->product->category->name,
            'price' => $cart->product->price,
        ];
        $this->product = json_encode($arr);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('home');
    }
}
