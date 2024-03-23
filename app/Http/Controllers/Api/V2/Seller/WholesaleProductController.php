<?php

namespace App\Http\Controllers\Api\V2\Seller;

use Illuminate\Http\Request;
use CoreComponentRepository;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Services\WholesaleService;
use App\Services\ProductTaxService;
use App\Services\ProductFlashDealService;
use App\Http\Requests\WholesaleProductRequest;
use App\Http\Resources\V2\Seller\ProductCollection;
use App\Http\Resources\V2\Seller\WholesaleProductDetailsCollection;
use Auth;

class WholesaleProductController extends Controller
{
    public function __construct()
    {
    }


    // Wholesale Products list in Seller panel 
    public function wholesale_products()
    {

        $products = Product::where('wholesale_product', 1)->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc');

        $products = $products->paginate(15);

        return new ProductCollection($products);
    }

    public function product_store(WholesaleProductRequest $request)
    {
        if (addon_is_activated('seller_subscription')) {
            if (
                (auth()->user()->shop->seller_package == null) ||
                (auth()->user()->shop->seller_package->product_upload_limit <= auth()->user()->products()->count())
            ) {
                return $this->failed(translate('Upload limit has been reached. Please upgrade your package.'));
            }
        }

        $request->added_by = "seller";

        $product = (new WholesaleService)->store($request->except([
            '_token', 'tax_id', 'tax', 'tax_type', 'flash_deal_id', 'flash_discount', 'flash_discount_type'
        ]));
        $request->merge(['product_id' => $product->id]);

        //Product categories
        $product->categories()->sync($request->category_ids);

        //VAT & Tax
        if ($request->tax_id) {
            (new productTaxService)->store($request->only([
                'tax_id', 'tax', 'tax_type', 'product_id'
            ]));
        }

        // Product Translations
        $request->merge(['lang' => env('DEFAULT_LANGUAGE')]);
        ProductTranslation::create($request->only([
            'lang', 'name', 'unit', 'description', 'product_id'
        ]));

        return $this->success("Product successfully created.");
    }


    public function product_edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->lang =  $request->lang == null ? env("DEFAULT_LANGUAGE") : $request->lang;
        return new WholesaleProductDetailsCollection($product);
    }




    public function product_update(WholesaleProductRequest $request, $id)
    {
        (new WholesaleService)->update($request, $id);

        return $this->success(translate('Product has been updated successfully'));
    }



    public function product_destroy($id)
    {
        (new WholesaleService)->destroy($id);
        return $this->success("Product successfully deleted.");
    }
}
