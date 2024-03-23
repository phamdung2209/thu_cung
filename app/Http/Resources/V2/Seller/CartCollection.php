<?php

namespace App\Http\Resources\V2\Seller;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CartCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                $stock = $data->product->stocks->where('variant', $data['variation'])->first();
                return [
                    'id' => $data->id,
                    'stock_id' => $stock->id,
                    'product_name' => $data->product->getTranslation('name'),
                    'variation' => $data->variation,
                    'price' =>  cart_product_price($data, $data->product, true, false),
                    'tax' => cart_product_tax($data,  $data->product, true),
                    'cart_quantity' => (int) $data->quantity,
                    'min_purchase_qty' => $data->product->min_qty,
                    'stock_qty' => $stock->qty
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
