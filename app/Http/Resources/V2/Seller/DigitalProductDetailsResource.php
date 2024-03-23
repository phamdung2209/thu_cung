<?php

namespace App\Http\Resources\V2\Seller;

use App\Http\Resources\V2\UploadedFileCollection;
use App\Models\Upload;
use Illuminate\Http\Resources\Json\JsonResource;

class DigitalProductDetailsResource extends JsonResource
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
            "category_ids"           => $this->categories()->pluck('category_id')->toArray(),
            "product_file"          => new UploadedFileCollection(Upload::whereIn("id", explode(",", $this->file_name))->get()),
            "tags"                  => $this->tags,
            "photos"                => new UploadedFileCollection(Upload::whereIn("id", explode(",", $this->photos))->get()),
            "thumbnail_img"         => new UploadedFileCollection(Upload::whereIn("id", explode(",", $this->thumbnail_img))->get()),
            "meta_title"            => $this->meta_title,
            "meta_description"      => $this->meta_description,
            "meta_img"              => new UploadedFileCollection(Upload::where("id", $this->meta_img)->get()),
            "slug"                  => $this->slug,
            "unit_price"            => $this->unit_price,
            "purchase_price"        => $this->purchase_price,
            "tax"                   => $this->taxes,
            "discount"              => $this->discount,
            "discount_type"         => $this->discount_type,
            "discount_start_date"   => date("Y-m-d", $this->discount_start_date),
            "discount_end_date"     => date("Y-m-d", $this->discount_end_date),
            "description"           => $this->getTranslation('description', $this->lang),
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
