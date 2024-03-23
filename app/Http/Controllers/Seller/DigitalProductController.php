<?php

namespace App\Http\Controllers\Seller;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductTax;
use App\Models\ProductTranslation;
use App\Models\Upload;
use App\Models\User;
use App\Notifications\ShopProductNotification;
use App\Services\ProductService;
use App\Services\ProductStockService;
use App\Services\ProductTaxService;
use Artisan;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class DigitalProductController  extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::where('user_id', Auth::user()->id)->where('digital', 1)->orderBy('created_at', 'desc')->paginate(10);
        return view('seller.product.digitalproducts.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (addon_is_activated('seller_subscription')) {
            if (!seller_package_validity_check()) {
                flash(translate('Please upgrade your package.'))->warning();
                return back();
            }
        }
        $categories = Category::where('parent_id', 0)
            ->where('digital', 1)
            ->with('childrenCategories')
            ->get();
        return view('seller.product.digitalproducts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if (addon_is_activated('seller_subscription')) {
            if (!seller_package_validity_check()) {
                flash(translate('Please upgrade your package.'))->warning();
                return redirect()->route('seller.digitalproducts');
            }
        }

        // Product Store
        $product = (new ProductService)->store($request->except([
            '_token', 'tax_id', 'tax', 'tax_type'
        ]));

        $request->merge(['product_id' => $product->id, 'current_stock' => 0]);

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

        //Product categories
        $product->categories()->attach($request->category_ids);

        // Product Translations
        $product_translation                = ProductTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'product_id' => $product->id]);
        $product_translation->name          = $request->name;
        $product_translation->description   = $request->description;
        $product_translation->save();

        if (get_setting('product_approve_by_admin') == 1) {
            $users = User::findMany([auth()->user()->id, User::where('user_type', 'admin')->first()->id]);
            Notification::send($users, new ShopProductNotification('digital', $product));
        }

        flash(translate('Digital Product has been inserted successfully'))->success();
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        return redirect()->route('seller.digitalproducts');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $categories = Category::where('digital', 1)->get();
        $lang = $request->lang;
        $product = Product::find($id);
        return view('seller.product.digitalproducts.edit', compact('categories', 'product', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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

        flash(translate('Product has been updated successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        (new ProductService)->destroy($id);

        flash(translate('Product has been deleted successfully'))->success();
        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return back();
    }


    public function download(Request $request)
    {
        $product = Product::findOrFail(decrypt($request->id));
        if (Auth::user()->id == $product->user_id) {
            $upload = Upload::findOrFail($product->file_name);
            if (env('FILESYSTEM_DRIVER') == "s3") {
                return \Storage::disk('s3')->download($upload->file_name, $upload->file_original_name . "." . $upload->extension);
            } else {
                if (file_exists(base_path('public/' . $upload->file_name))) {
                    return response()->download(base_path('public/' . $upload->file_name));
                }
            }
        } else {
            abort(404);
        }
    }
}
