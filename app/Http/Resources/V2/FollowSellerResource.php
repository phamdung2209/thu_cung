<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class FollowSellerResource extends JsonResource
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
            'shop_id'=> $this->shop->id,
            'shop_name'=> $this->shop->name,
            'shop_url'=> $this->shop->slug,
            'shop_rating'=> $this->shop->rating,
            'shop_num_of_reviews'=> $this->shop->num_of_reviews,
            'shop_logo' => uploaded_asset($this->shop->logo),
        ];
    }
}
