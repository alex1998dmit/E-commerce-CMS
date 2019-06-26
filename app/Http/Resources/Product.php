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
        // TODO заменить на пример с использованием моделей а не простой перебор
        $photos = [];
        foreach($this->photo as $photo) {
            $photos[$photo->id] = $photo->path;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => [
                'category_id' => $this->category->id,
                'category_name' => $this->category->name,
            ],
            'price' => $this->price,
            'desc' => $this->description,
            'photos' => $photos,
        ];
    }

    public function with($request)
    {
        return [
            'valid_as_of' => date('D, d M Y'),
        ];
    }
}
