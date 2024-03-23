<?php

namespace App\Http\Resources\V2\Seller;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductQueryResource extends JsonResource
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
            "id"         => $this->id,
            "user_name"  => $this->user ? $this->user->name : 'Customer Not found',
            "user_image" => $this->user ? uploaded_asset($this->user->avatar_original) : static_asset('assets/img/placeholder.jpg'),
            "question"   => $this->question,
            "reply"      => $this->reply ?? '',
            "product"    => $this->product ? $this->product->name : 'Product Not found',
            "status"    => $this->reply == null ? translate('Not Replied') : translate('Replied'),
            "created_at" => $this->created_at->diffForHumans()
        ];
    }
}
