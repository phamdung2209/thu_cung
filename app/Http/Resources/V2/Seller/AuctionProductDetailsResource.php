<?php

namespace App\Http\Resources\V2\Seller;

use App\Http\Resources\V2\UploadedFileCollection;
use App\Models\Upload;
use Illuminate\Http\Resources\Json\JsonResource;

class AuctionProductDetailsResource extends JsonResource
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
            "id"                    => $this->id,
            'lang'                  => $this->lang,
            'product_name'          => $this->getTranslation('name', $this->lang),
            "category_id"           => $this->category_id,
            "category_ids"          => $this->categories()->pluck('category_id')->toArray(),
            "brand_id"              => $this->brand_id,
            'product_unit'          => $this->getTranslation('unit', $this->lang),
            "weight"                => $this->weight,
            "tags"                  => $this->tags,
            "photos"                => new UploadedFileCollection(Upload::whereIn("id", explode(",", $this->photos))->get()),
            "thumbnail_img"         => new UploadedFileCollection(Upload::whereIn("id", explode(",", $this->thumbnail_img))->get()),
            "video_provider"        => $this->video_provider,
            "video_link"            => $this->video_link,
            "starting_bid"          => $this->starting_bid,
            "auction_start_date"    => date("Y-m-d", $this->auction_start_date),
            "auction_end_date"      => date("Y-m-d", $this->auction_end_date),
            'description'           => $this->getTranslation('description', $this->lang),
            "shipping_type"         => $this->shipping_type,
            "shipping_cost"         => $this->shipping_cost,
            "cash_on_delivery"      => $this->cash_on_delivery,
            "est_shipping_days"     => $this->est_shipping_days,
            "tax"                   => $this->taxes,
            "tax_type"              => $this->tax_type,
            "pdf"                   => new UploadedFileCollection(Upload::whereIn("id", explode(",", $this->pdf))->get()),
            "meta_title"            => $this->meta_title,
            "meta_description"      => $this->meta_description,
            "meta_img"              => new UploadedFileCollection(Upload::where("id", $this->meta_img)->get()),
            "slug"                  => $this->slug,
        ];
    }

    public function with($request)
    {
        return [
            'result' => true,
            'status' => 200
        ];
    }
}
