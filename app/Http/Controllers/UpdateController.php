<?php

namespace App\Http\Controllers;

use DB;
use Str;
use Schema;
use Artisan;
use Session;
use ZipArchive;
use App\Models\Tax;
use App\Models\Shop;
use App\Models\User;
use App\Models\Seller;
use App\Models\Upload;
use App\Models\Product;
use App\Models\ProductTax;
use Illuminate\Http\Request;
use App\Models\SellerPackage;
use App\Models\BusinessSetting;
use App\Models\ProductCategory;
use App\Models\SellerWithdrawRequest;

class UpdateController extends Controller
{
    public function step0(Request $request)
    {
        if (env('DEMO_MODE') == 'On') {
            flash(translate('This action is disabled in demo mode'))->error();
            return back();
        }
        if ($request->has('update_zip')) {
            if (class_exists('ZipArchive')) {
                // Create update directory.
                $dir = 'updates';
                if (!is_dir($dir))
                    mkdir($dir, 0777, true);

                $path = Upload::findOrFail($request->update_zip)->file_name;

                //Unzip uploaded update file and remove zip file.
                $zip = new ZipArchive;
                $res = $zip->open(base_path('public/' . $path));

                if ($res === true) {
                    $res = $zip->extractTo(base_path());
                    $zip->close();
                } else {
                    flash(translate('Could not open the updates zip file.'))->error();
                    return back();
                }
                if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
                    return redirect()->route('update.step2');
                }
                return redirect()->route('update.step1');
            } else {
                flash(translate('Please enable ZipArchive extension.'))->error();
            }
        } else {
            return view('update.step0');
        }
    }

    public function step1()
    {
        return view('update.step1');
    }

    public function purchase_code(Request $request)
    {
        if (\App\Utility\CategoryUtility::create_initial_category($request->purchase_code) == false) {
            flash("Sorry! The purchase code you have provided is not valid.")->error();
            return back();
        }
        if ($request->system_key == null) {
            flash("Sorry! The System Key required")->error();
            return back();
        }

        $businessSetting = BusinessSetting::where('type', 'purchase_code')->first();
        if ($businessSetting) {
            $businessSetting->value = $request->purchase_code;
            $businessSetting->save();
        } else {
            $business_settings = new BusinessSetting;
            $business_settings->type = 'purchase_code';
            $business_settings->value = $request->purchase_code;
            $business_settings->save();
        }

        $this->writeEnvironmentFile('SYSTEM_KEY', $request->system_key);

        return redirect()->route('update.step2');
    }

    public function step2()
    {
        if (get_setting('current_version') == '8.2') {
            $sql_path = base_path('sqlupdates/v830.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step3');
        } else if (get_setting('current_version') == '8.1') {
            $sql_path = base_path('sqlupdates/v820.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v830.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step3');
        }else if (get_setting('current_version') == '8') {
            $sql_path = base_path('sqlupdates/v810.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v820.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v830.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step3');
        } else if (get_setting('current_version') == '7.9.3') {
            $sql_path = base_path('sqlupdates/v800.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v810.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v820.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v830.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step3');
        } else if (get_setting('current_version') == '7.9.2') {
            $sql_path = base_path('sqlupdates/v793.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v800.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v810.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v820.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v830.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step3');
        } else if (get_setting('current_version') == '7.9.1') {
            $sql_path = base_path('sqlupdates/v792.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v793.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v800.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v810.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v820.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v830.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step3');
        } else if (get_setting('current_version') == '7.9.0') {
            $sql_path = base_path('sqlupdates/v790.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v791.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v792.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v793.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v800.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v810.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v820.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v830.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step3');
        } else if (get_setting('current_version') == '7.8.0') {
            $sql_path = base_path('sqlupdates/v790.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v791.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v792.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v793.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v800.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v810.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v820.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v830.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step3');
        } else if (get_setting('current_version') == '7.7.0') {
            $sql_path = base_path('sqlupdates/v780.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v790.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v791.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v792.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v793.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v800.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v810.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v820.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v830.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step3');
        } elseif (get_setting('current_version') == '7.6.0') {
            $sql_path = base_path('sqlupdates/v770.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v780.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v790.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v791.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v792.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v793.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v800.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v810.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v820.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v830.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step3');
        } elseif (get_setting('current_version') == '7.5.0') {
            $sql_path = base_path('sqlupdates/v760.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v770.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v780.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v790.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v791.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v792.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v793.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v800.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v810.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v820.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v830.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step3');
        } elseif (get_setting('current_version') == '7.4.0') {
            $sql_path = base_path('sqlupdates/v750.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v760.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v770.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v780.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v790.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v791.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v792.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v793.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v800.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v810.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v820.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v830.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step3');
        } elseif (get_setting('current_version') == '7.3.0') {
            $sql_path = base_path('sqlupdates/v740.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v750.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v760.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v770.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v780.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v790.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v791.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v792.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v793.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v800.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v810.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v820.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v830.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step3');
        } elseif (get_setting('current_version') == '7.2.0') {
            $sql_path = base_path('sqlupdates/v730.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v740.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v750.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v760.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v770.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v780.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v790.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v791.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v792.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v793.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v800.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v810.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v820.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v830.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step3');
        } elseif (get_setting('current_version') == '7.1.0') {
            $sql_path = base_path('sqlupdates/v720.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v730.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v740.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v750.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v760.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v770.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v780.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v790.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v791.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v792.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v793.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v800.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v810.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v820.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v830.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step3');
        } elseif (get_setting('current_version') == '7.0.0') {
            $sql_path = base_path('sqlupdates/v710.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v720.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v730.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v740.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v750.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v760.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v770.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v780.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v790.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v791.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v792.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v793.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v800.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v810.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v820.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v830.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step3');
        } else {
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
            $newRouteServiceProvier      = base_path('app/Providers/RouteServiceProvider.txt');
            copy($newRouteServiceProvier, $previousRouteServiceProvier);

            return view('update.done');
        }
    }

    public function step3()
    {
        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        $this->setCategoryToProductCategory();
        // $this->setAdmnRole();
        // $this->convertSellerIntoShop();
        // $this->convertSellerIntoUser();
        // $this->convertSellerPackageIntoShop();
        // $this->convertTrasnalations();
        // $this->convertColorsName();

        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier      = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);

        return view('update.done');
    }

    public function setCategoryToProductCategory()
    {
        $product_categories = ProductCategory::all();
        if ($product_categories->isEmpty()) {
            $products = Product::all();
            $new_product_array = [];
            foreach ($products as $product) {
                $new_product_array[] = [
                    "product_id" => $product->id,
                    "category_id" => $product->category_id
                ];
            }
            $collection = collect($new_product_array);
            $chunks = $collection->chunk(500);

            foreach ($chunks as $chunk) {
                ProductCategory::insert($chunk->toArray());
            }
        }
    }

    public function setAdmnRole()
    {
        $admin_user = User::where('user_type', 'admin')->first();
        $roles = $admin_user->getRoleNames();
        if ($roles->empty()) {
            $admin_user->assignRole(['Super Admin']);
        }
    }

    public function convertSellerIntoShop()
    {
        $sellers = Seller::all();

        foreach ($sellers as $seller) {
            $shop = Shop::where('user_id', $seller->user_id)->first();
            if ($shop) {
                if (!$shop->rating) {
                    $shop->rating = $seller->rating;
                    $shop->num_of_reviews = $seller->num_of_reviews;
                }
                if (!$shop->num_of_sale) {
                    $shop->num_of_sale = $seller->num_of_sale;
                }
                if (!$shop->seller_package_id) {
                    $shop->seller_package_id = $seller->seller_package_id;
                    $shop->product_upload_limit = $seller->product_upload_limit;
                    $shop->package_invalid_at = $seller->invalid_at;
                }
                if ($shop->admin_to_pay == 0) {
                    $shop->admin_to_pay = $seller->admin_to_pay;
                }
                if (!$shop->verification_status) {
                    $shop->verification_status = $seller->verification_status;
                }
                if (!$shop->verification_info) {
                    $shop->verification_info = $seller->verification_info;
                }
                if (!$shop->cash_on_delivery_status) {
                    $shop->cash_on_delivery_status = $seller->cash_on_delivery_status;
                }

                if (!$shop->bank_name) {
                    $shop->bank_name = $seller->bank_name;
                    $shop->bank_acc_name = $seller->bank_acc_name;
                    $shop->bank_acc_no = $seller->bank_acc_no;
                    $shop->bank_routing_no = $seller->bank_routing_no;
                    $shop->bank_payment_status = $seller->bank_payment_status;
                }

                $shop->save();
            }
        }
    }

    public function convertSellerIntoUser()
    {
        $seller_withdraw_requests = SellerWithdrawRequest::all();

        foreach ($seller_withdraw_requests as $seller_withdraw_request) {
            $seller = Seller::where('id', $seller_withdraw_request->user_id)->first();
            if ($seller) {
                $seller_withdraw_request->user_id = $seller->user_id;

                $seller_withdraw_request->save();
            }
        }
    }

    public function convertSellerPackageIntoShop()
    {
        if (Schema::hasTable('seller_packages')) {
            $shops = Shop::all();
            foreach ($shops as $shop) {
                $seller_package = SellerPackage::where('id', $shop->seller_package_id)->first();
                if ($seller_package) {
                    $shop->product_upload_limit = $seller_package->product_upload_limit;

                    $shop->save();
                }
            }
        }
    }

    public function convertTaxes()
    {
        $tax = Tax::first();

        foreach (Product::all() as $product) {
            $product_tax = new ProductTax;
            $product_tax->product_id = $product->id;
            $product_tax->tax_id = $tax->id;
            $product_tax->tax = $product->tax;
            $product_tax->tax_type = $product->tax_type;
            $product_tax->save();
        }
    }

    public function convertTrasnalations()
    {
        foreach (\App\Models\Translation::all() as $translation) {
            $lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($translation->lang_key)));
            $translation->lang_key = $lang_key;
            $translation->save();
        }
    }

    public function convertColorsName()
    {
        foreach (\App\Models\Color::all() as $color) {
            $color->name = Str::replace(' ', '', $color->name);
            $color->save();
        }
    }

    public function convertRatingAndSales()
    {
        foreach (\App\Models\Seller::all() as $seller) {
            $total = 0;
            $rating = 0;
            $num_of_sale = 0;
            try {
                foreach ($seller->user->products as $seller_product) {
                    $total += $seller_product->reviews->count();
                    $rating += $seller_product->reviews->sum('rating');
                    $num_of_sale += $seller_product->num_of_sale;
                }
                if ($total > 0) {
                    $seller->rating = $rating / $total;
                    $seller->num_of_reviews = $total;
                }
                $seller->num_of_sale = $num_of_sale;
                $seller->save();
            } catch (\Exception $e) {
            }
        }
    }

    public function writeEnvironmentFile($type, $val) {
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"'.trim($val).'"';
            if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0){
                file_put_contents($path, str_replace(
                    $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                ));
            }
            else{
                file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
            }
        }
    }
}
