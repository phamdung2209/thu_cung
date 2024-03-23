<?php

namespace App\Http\Resources\V2\Seller;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AuctionProductCollection extends ResourceCollection
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
                    'thumbnail_image' => uploaded_asset($data->thumbnail_img),
                    'main_price' => single_price($data->starting_bid),
                    'start_date' => date('Y-m-d H:i:s', $data->auction_start_date),
                    'end_date' => date('Y-m-d H:i:s', $data->auction_end_date),
                    'total_bids' => (int) $data->bids->count(),
                    'can_edit' => $data->auction_start_date > strtotime("now"),

                    'links' => [
                        'details' => route('products.show', $data->id),
                    ]
                ];
            })
        ];
    }
}
