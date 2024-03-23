<?php

namespace App\Http\Resources\V2\Auction;

use Illuminate\Http\Resources\Json\JsonResource;

class AuctionPurchaseHistory extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $order = \App\Models\Order::find($this->id);
        return  [
            'id' => $order->id,
            'code' => $order->code,
            'date' => date('d-m-Y', $order->date),
            'amount' => single_price($order->grand_total),
            'delivery_status' => translate(ucfirst(str_replace('_', ' ', $order->orderDetails->first()->delivery_status))),
            'payment_status' => $order->payment_status == 'paid' ? translate('Paid') : translate('Unpaid'),
        ];
    }
}
