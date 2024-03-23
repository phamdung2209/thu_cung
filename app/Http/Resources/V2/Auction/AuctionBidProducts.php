<?php

namespace App\Http\Resources\V2\Auction;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Resources\Json\JsonResource;

class AuctionBidProducts extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $order = null;
        $isBuyable = false;
        $my_bided_product = $this->bids->where('user_id', auth()->id())->first();
        $highest_bid = $this->bids->max('amount');
        $order_detail = OrderDetail::where('product_id', $this->id)->first();
        if ($order_detail != null) {
            $order = Order::where('id', $order_detail->order_id)->where('user_id', auth()->id())->first();
        }

        if ($my_bided_product->product->auction_end_date < strtotime("now") && $my_bided_product->amount == $highest_bid && $order == null) {
            $action = 'Buy';
            $isBuyable = true;
        } elseif ($order != null) {
            $action = 'Purchased';
        } else {
            $action = 'N/A';
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'thumbnail_image' => uploaded_asset($this->thumbnail_img),
            'my_bid' => single_price($my_bided_product->amount),
            'highest_bid' => single_price($highest_bid),
            'auction_end_date' => $this->auction_end_date < strtotime("now") ? translate('Ended') : date('d.m.Y H:i:s', $this->auction_end_date),
            'action' =>  $action,
            'isBuyable' =>  $isBuyable,
        ];
    }
}
