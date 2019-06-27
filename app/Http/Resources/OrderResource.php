<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id' => $this->id,
            'customer' => $this->user->name,
            'product_name' => $this->product->name,
            'category' => $this->product->category->name,
            'created_at' => $this->created_at,
            'amount' => $this->amount,
            'sum' => $this->sum,
        ];
    }
}
