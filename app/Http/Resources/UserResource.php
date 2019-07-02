<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $is_confirm = ($this->email_verified_at) ? true : false;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'confirm' => $is_confirm
        ];
    }

    public function with($request)
    {
        return [
            'valid_as_of' => date('D, d M Y'),
        ];
    }
}
