<?php

namespace App\Http\Resources\V2\Seller;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DigitalProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                return [
                    'id' => $data->id,
                    'name' => $data->getTranslation('name'),
                    'thumbnail_img' => uploaded_asset($data->thumbnail_img),
                    'category' => $data->main_category ? $data->main_category->getTranslation('name') : "",
                    'price	' => $data->unit_price,
                    'status' => $data->published == 0 ? false : true,
                    'featured' => $data->seller_featured == 0 ? false : true
                ];
            })
        ];
    }
}
