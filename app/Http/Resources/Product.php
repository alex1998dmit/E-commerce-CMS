<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'name' => $this->name,
            'category' => [
                'category_id' => $this->category->id,
                'category_name' => $this->category->name,
            ],
            'price' => $this->price,
            'desc' => $this->description,
        ];
    }

    public function with($request)
    {
        return [
            'valid_as_of' => date('D, d M Y'),
        ];
    }
}
