<?php

namespace App\Http\Resources\V2\Seller;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AuctionProductBidCollection extends ResourceCollection
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
                    'customer_name' => $data->user->name,
                    'customer_email' => $data->user->email ?? '',
                    'customer_phone' => $data->user->phone ?? '',
                    'bidded_amout' => format_price($data->amount),
                    // 'date' => date("d-m-Y", $this->created_at),
                    'date' => $data->created_at->format('d-m-Y'),
                ];
            })
        ];
    }
    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
