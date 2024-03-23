<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductWholesaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            // 'id' => $this->id,
            // 'product_stock_id' => $this->product_stock_id,
            'min_qty' => (int)$this->min_qty,
            'max_qty' => (int) $this->max_qty,
            'price' => single_price($this->price)
        ];
    }
}
