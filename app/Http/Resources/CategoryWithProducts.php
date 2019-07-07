<?php

namespace App\Http\Resources;

use App\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductWithoutCategoryCollection;

class CategoryWithProducts extends JsonResource
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
            // TODO Заменить на более правильый вариант, без использования моделей
            'products' => Product::where('category_id', $this->id)->paginate(3),
        ];
    }

    public function with($request)
    {
        return [
            'valid_as_of' => date('D, d M Y'),
        ];
    }
}
