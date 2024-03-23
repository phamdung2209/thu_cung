<?php

namespace App\Http\Controllers\Api\V2\Seller;

use App\Http\Controllers\Api\V2\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\V2\Seller\DigitalProductCollection;
use App\Http\Resources\V2\Seller\CategoriesCollection;
use App\Http\Resources\V2\Seller\DigitalProductDetailsResource;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductTax;
use App\Models\ProductTranslation;
use App\Models\Upload;
use Auth;


use App\Services\ProductService;
use App\Services\ProductStockService;
use App\Services\ProductTaxService;
use Artisan;

class DigitalProductController extends Controller
{
    public function index()
    {
        $products = Product::where('digital', 1)->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc');
        return new DigitalProductCollection($products->paginate(10));
    }

    public function getCategory()
    {
        $categories = Category::where('parent_id', 0)
            ->where('digital', 1)
            ->with('childrenCategories')
            ->get();
        return CategoriesCollection::collection($categories);
    }

    public function store(ProductRequest $request)
    {
        if (addon_is_activated('seller_subscription')) {
            if (!seller_package_validity_check(auth()->user()->id)) {
                return $this->failed(translate('Please upgrade your package.'));
            }
        }

        if (auth()->user()->user_type != 'seller') {
            return $this->failed(translate('Unauthenticated User.'));
        }

        // Product Store
        $product = (new ProductService)->store($request->except([
            '_token', 'tax_id', 'tax', 'tax_type'
        ]));

        $request->merge(['product_id' => $product->id, 'current_stock' => 0]);

        ///Product categories
        $product->categories()->attach($request->category_ids);

        //Product Stock
        (new ProductStockService)->store($request->only([
            'unit_price', 'current_stock', 'product_id'
        ]), $product);

        //VAT & Tax
        if ($request->tax_id) {
            (new ProductTaxService)->store($request->only([
                'tax_id', 'tax', 'tax_type', 'product_id'
            ]));
        }

        // Product Translations
        $request->merge(['lang' => env('DEFAULT_LANGUAGE')]);
        ProductTranslation::create($request->only([
            'lang', 'name', 'unit', 'description', 'product_id'
        ]));

        return $this->success(translate('Digital Product has been inserted successfully'));
    }

    public function edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->lang =  $request->lang == null ? env("DEFAULT_LANGUAGE") : $request->lang;

        return new DigitalProductDetailsResource($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        //Product Update
        $product = (new ProductService)->update($request->except([
            '_token', 'tax_id', 'tax', 'tax_type'
        ]), $product);

        //Product Stock
        foreach ($product->stocks as $key => $stock) {
            $stock->delete();
        }

        $request->merge(['product_id' => $product->id, 'current_stock' => 0]);

        //Product categories
        $product->categories()->sync($request->category_ids);


        (new ProductStockService)->store($request->only([
            'unit_price', 'current_stock', 'product_id'
        ]), $product);

        //VAT & Tax
        if ($request->tax_id) {
            ProductTax::where('product_id', $product->id)->delete();
            (new ProductTaxService)->store($request->only([
                'tax_id', 'tax', 'tax_type', 'product_id'
            ]));
        }

        // Product Translations
        ProductTranslation::updateOrCreate(
            $request->only(['lang', 'product_id']),
            $request->only(['name', 'description'])
        );

        return $this->success(translate('Digital Product has been Updated successfully'));
    }

    public function destroy($id)
    {
        (new ProductService)->destroy($id);

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        return $this->success(translate('Digital Product deleted successfully'));
    }

    // Digital Product File Download
    public function download($id)
    {
        if (auth()->user()->user_type != 'seller') {
            return $this->failed(translate('Unauthenticated User.'));
        }

        $product = Product::where('id', $id)->where('user_id', auth()->user()->id)->first();
        if (!$product) {
            return $this->failed(translate('This product is not yours'));
        }

        $upload = Upload::findOrFail($product->file_name);
        if (env('FILESYSTEM_DRIVER') == "s3") {
            return \Storage::disk('s3')->download($upload->file_name, $upload->file_original_name . "." . $upload->extension);
        } else {
            if (file_exists(base_path('public/' . $upload->file_name))) {
                $file = public_path() . "/$upload->file_name";
                return response()->download($file, config('app.name') . "_" . $upload->file_original_name . "." . $upload->extension);
            }
        }
    }
}
