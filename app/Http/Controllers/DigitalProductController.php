<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductTax;
use App\Models\ProductTranslation;
use App\Models\Upload;
use App\Services\ProductTaxService;
use Artisan;

use App\Services\ProductService;
use App\Services\ProductStockService;

class DigitalProductController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:show_digital_products'])->only('index');
        $this->middleware(['permission:add_digital_product'])->only('create');
        $this->middleware(['permission:edit_digital_product'])->only('edit');
        $this->middleware(['permission:delete_digital_product'])->only('destroy');
        $this->middleware(['permission:download_digital_product'])->only('download');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search    = null;
        $products       = Product::query();
        $products->where('added_by', 'admin');
        if ($request->has('search')) {
            $sort_search    = $request->search;
            $products       = $products->where('name', 'like', '%' . $sort_search . '%');
        }
        $products = $products->where('digital', 1)->orderBy('created_at', 'desc')->paginate(10);
        $type = 'Admin';
        return view('backend.product.digital_products.index', compact('products', 'sort_search', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id', 0)
            ->where('digital', 1)
            ->with('childrenCategories')
            ->get();
        return view('backend.product.digital_products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        // Product Store
        $product = (new ProductService)->store($request->except([
            '_token', 'tax_id', 'tax', 'tax_type'
        ]));

        $request->merge(['product_id' => $product->id, 'current_stock' => 0]);

        //Product categories
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

        flash(translate('Product has been inserted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        return redirect()->route('digitalproducts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $lang = $request->lang;
        $product = Product::findOrFail($id);
        $categories = Category::where('parent_id', 0)
            ->where('digital', 1)
            ->with('childrenCategories')
            ->get();
        return view('backend.product.digital_products.edit', compact('product', 'lang', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product                    = Product::findOrFail($id);

        //Product Update
        $product = (new ProductService)->update($request->except([
             '_token', 'tax_id', 'tax', 'tax_type'
         ]), $product);

        //Product Stock
        foreach ($product->stocks as $key => $stock) {
            $stock->delete();
        }

        $request->merge(['product_id' => $product->id,'current_stock' => 0]);

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

        $upload = Upload::findOrFail($product->file_name);
        if (env('FILESYSTEM_DRIVER') == "s3") {
            return \Storage::disk('s3')->download($upload->file_name, $upload->file_original_name . "." . $upload->extension);
        } else {
            if (file_exists(base_path('public/' . $upload->file_name))) {
                return response()->download(base_path('public/' . $upload->file_name));
            }
        }
    }
}
