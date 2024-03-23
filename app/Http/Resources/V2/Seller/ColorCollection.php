<?php

namespace App\Http\Resources\V2\Seller;

use Illuminate\Http\Resources\Json\JsonResource;

class ColorCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                =>(int) $this->id,
            'name'              =>$this->name,
            'code'              => $this->code
        ];
    }
}