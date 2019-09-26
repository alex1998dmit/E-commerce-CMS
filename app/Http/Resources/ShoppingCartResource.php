<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShoppingCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'username' => $this->user->name,
            'email' => $this->user->email,
            'product' => $this->product->name,
            'category' => $this->product->category->name,
            'amount' => $this->amount,
            'product_price' => $this->product->price,
            'created_at' => $this->created_at,
        ];
    }
}
