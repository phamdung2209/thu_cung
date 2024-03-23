<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductTax;
use App\Models\ProductTranslation;
use Artisan;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuctionService
{
    public function store(Request $request){
        $product                  = new Product;
        $product->name            = $request->name;
        $product->added_by        = $request->added_by;

        if(Auth::user()->user_type == 'seller'){
            $product->user_id = Auth::user()->id;
            if(get_setting('product_approve_by_admin') == 1) {
                $product->approved = 0;
            }
        }
        else{
            $product->user_id = \App\Models\User::where('user_type', 'admin')->first()->id;
        }

        $product->auction_product = 1;
        $product->category_id     = $request->category_id;
        $product->brand_id        = $request->brand_id;
        $product->barcode         = $request->barcode;
        $product->starting_bid    = $request->starting_bid;

        if (addon_is_activated('refund_request')) {
            if ($request->refundable != null) {
                $product->refundable = 1;
            }
            else {
                $product->refundable = 0;
            }
        }
        $product->photos = $request->photos;
        $product->thumbnail_img = $request->thumbnail_img;
        // $product->min_qty = 1;
        // $product->stock_visibility_state = '';


        $tags = array();
        if($request->tags[0] != null){
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $product->tags = implode(',', $tags);

        $product->description = $request->description;
        $product->video_provider = $request->video_provider;
        $product->video_link = $request->video_link;

        if ($request->auction_date_range != null) {
            $date_var               = explode(" to ", $request->auction_date_range);
            $product->auction_start_date = strtotime($date_var[0]);
            $product->auction_end_date   = strtotime($date_var[1]);
        }

        $product->shipping_type = $request->shipping_type;
        $product->est_shipping_days  = $request->est_shipping_days;

        if (addon_is_activated('club_point')) {
            if($request->earn_point) {
                $product->earn_point = $request->earn_point;
            }
        }

        if ($request->has('shipping_type')) {
            if($request->shipping_type == 'free'){
                $product->shipping_cost = 0;
            }
            elseif ($request->shipping_type == 'flat_rate') {
                $product->shipping_cost = $request->flat_shipping_cost;
            }
            elseif ($request->shipping_type == 'product_wise') {
                $product->shipping_cost = json_encode($request->shipping_cost);
            }
        }
        if ($request->has('is_quantity_multiplied')) {
            $product->is_quantity_multiplied = 1;
        }

        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;

        if($request->has('meta_img')){
            $product->meta_img = $request->meta_img;
        } else {
            $product->meta_img = $product->thumbnail_img;
        }

        if($product->meta_title == null) {
            $product->meta_title = $product->name;
        }

        if($product->meta_description == null) {
            $product->meta_description = strip_tags($product->description);
        }

        if($product->meta_img == null) {
            $product->meta_img = $product->thumbnail_img;
        }

        if($request->hasFile('pdf')){
            $product->pdf = $request->pdf->store('uploads/products/pdf');
        }

        $product->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);


        $product->colors = json_encode(array());
        $product->attributes = json_encode(array());
        $product->choice_options = json_encode(array(), JSON_UNESCAPED_UNICODE);

        if ($request->has('cash_on_delivery')) {
            $product->cash_on_delivery = 1;
        }
        if ($request->has('todays_deal')) {
            $product->todays_deal = 1;
        }
        $product->cash_on_delivery = 0;
        if ($request->cash_on_delivery) {
            $product->cash_on_delivery = 1;
        }

        $product->save();

        //VAT & Tax
        if($request->tax_id) {
            foreach ($request->tax_id as $key => $val) {
                $product_tax = new ProductTax;
                $product_tax->tax_id = $val;
                $product_tax->product_id = $product->id;
                $product_tax->tax = $request->tax[$key];
                $product_tax->tax_type = $request->tax_type[$key];
                $product_tax->save();
            }
        }

        //Generates the combinations of customer choice options
        $product_stock              = new ProductStock;
        $product_stock->product_id  = $product->id;
        $product_stock->variant     = '';
        $product_stock->price       = 0;
        $product_stock->sku         = $request->sku;
        $product_stock->qty         = 1;
        $product_stock->save();

        //combinations end

	       $product->save();

        // Product Translations
        $product_translation = ProductTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'product_id' => $product->id]);
        $product_translation->name = $request->name;
        $product_translation->unit = $request->unit;
        $product_translation->description = $request->description;
        $product_translation->save();

        flash(translate('Product has been inserted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
    }

    public function update(Request $request , $id){
        $product                    = Product::findOrFail($id);
        $product->category_id       = $request->category_id;
        $product->brand_id          = $request->brand_id;
        $product->barcode           = $request->barcode;
        $product->cash_on_delivery = 0;
        $product->is_quantity_multiplied = 0;


        if (addon_is_activated('refund_request')) {
            if ($request->refundable != null) {
                $product->refundable = 1;
            }
            else {
                $product->refundable = 0;
            }
        }

        if($request->lang == env("DEFAULT_LANGUAGE")){
            $product->name          = $request->name;
            $product->unit          = $request->unit;
            $product->description   = $request->description;
            $product->slug          = strtolower($request->slug);
        }

        $product->photos                 = $request->photos;
        $product->thumbnail_img          = $request->thumbnail_img;

        $tags = array();
        if($request->tags[0] != null){
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $product->tags           = implode(',', $tags);

        $product->video_provider = $request->video_provider;
        $product->video_link     = $request->video_link;
        $product->starting_bid   = $request->starting_bid;

        if ($request->auction_date_range != null) {
            $date_var               = explode(" to ", $request->auction_date_range);
            $product->auction_start_date = strtotime($date_var[0]);
            $product->auction_end_date   = strtotime( $date_var[1]);
        }

        $product->shipping_type  = $request->shipping_type;
        $product->est_shipping_days  = $request->est_shipping_days;

        if (addon_is_activated('club_point')) {
            if($request->earn_point) {
                $product->earn_point = $request->earn_point;
            }
        }

        if ($request->has('shipping_type')) {
            if($request->shipping_type == 'free'){
                $product->shipping_cost = 0;
            }
            elseif ($request->shipping_type == 'flat_rate') {
                $product->shipping_cost = $request->flat_shipping_cost;
            }
            elseif ($request->shipping_type == 'product_wise') {
                $product->shipping_cost = json_encode($request->shipping_cost);
            }
        }

        if ($request->has('is_quantity_multiplied')) {
            $product->is_quantity_multiplied = 1;
        }
        if ($request->has('cash_on_delivery')) {
            $product->cash_on_delivery = 1;
        }

        $product->meta_title        = $request->meta_title;
        $product->meta_description  = $request->meta_description;
        $product->meta_img          = $request->meta_img;

        if($product->meta_title == null) {
            $product->meta_title = $product->name;
        }

        if($product->meta_description == null) {
            $product->meta_description = strip_tags($product->description);
        }

        if($product->meta_img == null) {
            $product->meta_img = $product->thumbnail_img;
        }

        $product->pdf = $request->pdf;
        $product->colors = json_encode(array());
        $product->attributes = json_encode(array());
        $product->choice_options = json_encode(array(), JSON_UNESCAPED_UNICODE);

        $product->save();

        //VAT & Tax
        if($request->tax_id) {
            ProductTax::where('product_id', $product->id)->delete();
            foreach ($request->tax_id as $key => $val) {
                $product_tax = new ProductTax;
                $product_tax->tax_id = $val;
                $product_tax->product_id = $product->id;
                $product_tax->tax = $request->tax[$key];
                $product_tax->tax_type = $request->tax_type[$key];
                $product_tax->save();
            }
        }

        // Product Translations
        $product_translation                = ProductTranslation::firstOrNew(['lang' => $request->lang, 'product_id' => $product->id]);
        $product_translation->name          = $request->name;
        $product_translation->unit          = $request->unit;
        $product_translation->description   = $request->description;
        $product_translation->save();

        flash(translate('Product has been updated successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
    }

    public function destroy($id){
        $product = Product::findOrFail($id);
        foreach ($product->product_translations as $key => $product_translations) {
            $product_translations->delete();
        }

        foreach ($product->bids as $key => $bid) {
            $bid->delete();
        }

        if(Product::destroy($id)){
            Cart::where('product_id', $id)->delete();

            flash(translate('Product has been deleted successfully'))->success();

            Artisan::call('view:clear');
            Artisan::call('cache:clear');
        }
        else{
            flash(translate('Something went wrong'))->error();
        }
    }
}
