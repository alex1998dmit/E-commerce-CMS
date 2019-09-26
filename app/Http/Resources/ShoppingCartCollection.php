<?php

namespace App\Http\Resources;

use App\User;
use App\Product;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ShoppingCartCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // TODO Replace foreach
        $products = [];
        foreach($this->collection as $key=>$value) {
            $product = Product::where('id', $value->product_id)->first();
            $products[$value->product_id] = $product;
        }

        return [
            'data' => $this->collection,
            'products' => $products,
        ];
    }
}
