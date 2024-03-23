<?php

use Carbon\Carbon;
use App\Models\Tax;
use App\Models\Cart;
use App\Models\City;
use App\Models\Shop;
use App\Models\User;
use App\Models\Addon;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Seller;
use App\Models\Upload;
use App\Models\Wallet;
use App\Models\Address;
use App\Models\Carrier;
use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Wishlist;
use App\Models\Attribute;
use App\Models\ClubPoint;
use App\Models\FlashDeal;
use App\Models\CouponUsage;
use App\Models\DeliveryBoy;
use App\Models\OrderDetail;
use App\Models\PickupPoint;
use App\Models\Translation;
use App\Models\BlogCategory;
use App\Models\Conversation;
use App\Models\FollowSeller;
use App\Models\ProductStock;
use App\Models\CombinedOrder;
use App\Models\SellerPackage;
use App\Models\AffiliateConfig;
use App\Models\AffiliateOption;
use App\Models\BusinessSetting;
use App\Models\CustomerPackage;
use App\Models\CustomerProduct;
use App\Utility\SendSMSUtility;
use App\Utility\CategoryUtility;
use App\Models\AuctionProductBid;
use App\Models\ManualPaymentMethod;
use App\Models\SellerPackagePayment;
use App\Utility\NotificationUtility;
use App\Http\Resources\V2\CarrierCollection;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\ClubPointController;
use App\Http\Controllers\CommissionController;
use AizPackages\ColorCodeConverter\Services\ColorCodeConverter;
use App\Models\FlashDealProduct;
use App\Models\UserCoupon;
use App\Models\Review;
//sensSMS function for OTP
if (!function_exists('sendSMS')) {
    function sendSMS($to, $from, $text, $template_id)
    {
        return SendSMSUtility::sendSMS($to, $from, $text, $template_id);
    }
}

//highlights the selected navigation on admin panel
if (!function_exists('areActiveRoutes')) {
    function areActiveRoutes(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route && (url()->current() != url('/admin/website/custom-pages/edit/home'))) return $output;
        }
    }
}

//highlights the selected navigation on frontend
if (!function_exists('areActiveRoutesHome')) {
    function areActiveRoutesHome(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }
    }
}

//highlights the selected navigation on frontend
if (!function_exists('default_language')) {
    function default_language()
    {
        return env("DEFAULT_LANGUAGE");
    }
}

/**
 * Save JSON File
 * @return Response
 */
if (!function_exists('convert_to_usd')) {
    function convert_to_usd($amount)
    {
        $currency = Currency::find(get_setting('system_default_currency'));
        return (floatval($amount) / floatval($currency->exchange_rate)) * Currency::where('code', 'USD')->first()->exchange_rate;
    }
}

if (!function_exists('convert_to_kes')) {
    function convert_to_kes($amount)
    {
        $currency = Currency::find(get_setting('system_default_currency'));
        return (floatval($amount) / floatval($currency->exchange_rate)) * Currency::where('code', 'KES')->first()->exchange_rate;
    }
}

// get all active countries
if (!function_exists('get_active_countries')) {
    function get_active_countries()
    {
        $country_query = Country::query();
        return $country_query->isEnabled()->get();
    }
}

//filter products based on vendor activation system
if (!function_exists('filter_products')) {
    function filter_products($products)
    {

        $products = $products->where('published', '1')->where('auction_product', 0)->where('approved', '1');

        if (!addon_is_activated('wholesale')) {
            $products = $products->where('wholesale_product', 0);
        }
        $verified_sellers = verified_sellers_id();
        // $unbanned_sellers_id = unbanned_sellers_id();
        if (get_setting('vendor_system_activation') == 1) {
            // return $products->where(function ($p) use ($verified_sellers, $unbanned_sellers_id) {
            //     $p->where('added_by', 'admin')->orWhere(function ($q) use ($verified_sellers, $unbanned_sellers_id) {
            //         $q->whereIn('user_id', $verified_sellers)->whereIn('user_id', $unbanned_sellers_id);
            //     });
            // });
            return $products->where(function ($p) use ($verified_sellers) {
                $p->where('added_by', 'admin')->orWhere(function ($q) use ($verified_sellers) {
                    $q->whereIn('user_id', $verified_sellers);
                });
            });
        } else {
            return $products->where('added_by', 'admin');
        }
    }
}

//cache products based on category
if (!function_exists('get_cached_products')) {
    function get_cached_products($category_id = null)
    {
        return Cache::remember('products-category-' . $category_id, 86400, function () use ($category_id) {
            return filter_products(Product::where('category_id', $category_id))->latest()->take(5)->get();
        });
    }
}

if (!function_exists('verified_sellers_id')) {
    function verified_sellers_id()
    {
        return Cache::rememberForever('verified_sellers_id', function () {
            return Shop::where('verification_status', 1)->pluck('user_id')->toArray();
        });
    }
}

// if (!function_exists('unbanned_sellers_id')) {
//     function unbanned_sellers_id()
//     {
//         return Cache::rememberForever('unbanned_sellers_id', function () {
//             return App\Models\User::where('user_type', 'seller')->where('banned', 0)->pluck('id')->toArray();
//         });
//     }
// }

if (!function_exists('get_system_default_currency')) {
    function get_system_default_currency()
    {
        return Cache::remember('system_default_currency', 86400, function () {
            return Currency::findOrFail(get_setting('system_default_currency'));
        });
    }
}

//converts currency to home default currency
if (!function_exists('convert_price')) {
    function convert_price($price)
    {
        if (Session::has('currency_code') && (Session::get('currency_code') != get_system_default_currency()->code)) {
            $price = floatval($price) / floatval(get_system_default_currency()->exchange_rate);
            $price = floatval($price) * floatval(Session::get('currency_exchange_rate'));
        }

        if (
            request()->header('Currency-Code') &&
            request()->header('Currency-Code') != get_system_default_currency()->code
        ) {
            $price = floatval($price) / floatval(get_system_default_currency()->exchange_rate);
            $price = floatval($price) * floatval(request()->header('Currency-Exchange-Rate'));
        }
        return $price;
    }
}

//gets currency symbol
if (!function_exists('currency_symbol')) {
    function currency_symbol()
    {
        if (Session::has('currency_symbol')) {
            return Session::get('currency_symbol');
        }
        if (request()->header('Currency-Code')) {
            return request()->header('Currency-Code');
        }
        return get_system_default_currency()->symbol;
    }
}

//formats currency
if (!function_exists('format_price')) {
    function format_price($price, $isMinimize = false)
    {
        if (get_setting('decimal_separator') == 1) {
            $fomated_price = number_format($price, get_setting('no_of_decimals'));
        } else {
            $fomated_price = number_format($price, get_setting('no_of_decimals'), ',', '.');
        }


        // Minimize the price 
        if ($isMinimize) {
            $temp = number_format($price / 1000000000, get_setting('no_of_decimals'), ".", "");

            if ($temp >= 1) {
                $fomated_price = $temp . "B";
            } else {
                $temp = number_format($price / 1000000, get_setting('no_of_decimals'), ".", "");
                if ($temp >= 1) {
                    $fomated_price = $temp . "M";
                }
            }
        }

        if (get_setting('symbol_format') == 1) {
            return currency_symbol() . $fomated_price;
        } else if (get_setting('symbol_format') == 3) {
            return currency_symbol() . ' ' . $fomated_price;
        } else if (get_setting('symbol_format') == 4) {
            return $fomated_price . ' ' . currency_symbol();
        }
         return $fomated_price .' '. currency_symbol();
    }
}

//formats price to home default price with convertion
if (!function_exists('single_price')) {
    function single_price($price)
    {
        return format_price(convert_price($price));
    }
}

if (!function_exists('discount_in_percentage')) {
    function discount_in_percentage($product)
    {
        $base = home_base_price($product, false);
        $reduced = home_discounted_base_price($product, false);
        $discount = $base - $reduced;
        $dp = ($discount * 100) / ($base > 0 ? $base : 1);
        return round($dp);
    }
}

//Shows Price on page based on carts
if (!function_exists('cart_product_price')) {
    function cart_product_price($cart_product, $product, $formatted = true, $tax = true)
    {
        if ($product->auction_product == 0) {
            $str = '';
            if ($cart_product['variation'] != null) {
                $str = $cart_product['variation'];
            }
            $price = 0;
            $product_stock = $product->stocks->where('variant', $str)->first();
            if ($product_stock) {
                $price = $product_stock->price;
            }

            if ($product->wholesale_product) {
                $wholesalePrice = $product_stock->wholesalePrices->where('min_qty', '<=', $cart_product['quantity'])->where('max_qty', '>=', $cart_product['quantity'])->first();
                if ($wholesalePrice) {
                    $price = $wholesalePrice->price;
                }
            }

            //discount calculation
            $discount_applicable = false;

            if ($product->discount_start_date == null) {
                $discount_applicable = true;
            } elseif (
                strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
                strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
            ) {
                $discount_applicable = true;
            }

            if ($discount_applicable) {
                if ($product->discount_type == 'percent') {
                    $price -= ($price * $product->discount) / 100;
                } elseif ($product->discount_type == 'amount') {
                    $price -= $product->discount;
                }
            }
        } else {
            $price = $product->bids->max('amount');
        }

        //calculation of taxes 
        if ($tax) {
            $taxAmount = 0;
            foreach ($product->taxes as $product_tax) {
                if ($product_tax->tax_type == 'percent') {
                    $taxAmount += ($price * $product_tax->tax) / 100;
                } elseif ($product_tax->tax_type == 'amount') {
                    $taxAmount += $product_tax->tax;
                }
            }
            $price += $taxAmount;
        }

        if ($formatted) {
            return format_price(convert_price($price));
        } else {
            return $price;
        }
    }
}

if (!function_exists('cart_product_tax')) {
    function cart_product_tax($cart_product, $product, $formatted = true)
    {
        $str = '';
        if ($cart_product['variation'] != null) {
            $str = $cart_product['variation'];
        }
        $product_stock = $product->stocks->where('variant', $str)->first();
        $price = $product_stock->price;

        //discount calculation
        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        //calculation of taxes 
        $tax = 0;
        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }

        if ($formatted) {
            return format_price(convert_price($tax));
        } else {
            return $tax;
        }
    }
}

if (!function_exists('cart_product_discount')) {
    function cart_product_discount($cart_product, $product, $formatted = false)
    {
        $str = '';
        if ($cart_product['variation'] != null) {
            $str = $cart_product['variation'];
        }
        $product_stock = $product->stocks->where('variant', $str)->first();
        $price = $product_stock->price;

        //discount calculation
        $discount_applicable = false;
        $discount = 0;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $discount = ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $discount = $product->discount;
            }
        }

        if ($formatted) {
            return format_price(convert_price($discount));
        } else {
            return $discount;
        }
    }
}

// all discount
if (!function_exists('carts_product_discount')) {
    function carts_product_discount($cart_products, $formatted = false)
    {
        $discount = 0;
        foreach ($cart_products as $key => $cart_product) {
            $str = '';
            $product = \App\Models\Product::find($cart_product['product_id']);
            if ($cart_product['variation'] != null) {
                $str = $cart_product['variation'];
            }
            $product_stock = $product->stocks->where('variant', $str)->first();
            $price = $product_stock->price;

            //discount calculation
            $discount_applicable = false;

            if ($product->discount_start_date == null) {
                $discount_applicable = true;
            } elseif (
                strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
                strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
            ) {
                $discount_applicable = true;
            }

            if ($discount_applicable) {
                if ($product->discount_type == 'percent') {
                    $discount += ($price * $product->discount) / 100;
                } elseif ($product->discount_type == 'amount') {
                    $discount += $product->discount;
                }
            }
        }

        if ($formatted) {
            return format_price(convert_price($discount));
        } else {
            return $discount;
        }
    }
}

// carts coupon discount
if (!function_exists('carts_coupon_discount')) {
    function carts_coupon_discount($code, $formatted = false)
    {
        $coupon = Coupon::where('code', $code)->first();
        $coupon_discount = 0;
        if ($coupon != null) {
            if (strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date) {
                if (CouponUsage::where('user_id', Auth::user()->id)->where('coupon_id', $coupon->id)->first() == null) {
                    $coupon_details = json_decode($coupon->details);
                    $carts = Cart::where('user_id', Auth::user()->id)
                        ->where('owner_id', $coupon->user_id)
                        ->get();
                    if ($coupon->type == 'cart_base') {
                        $subtotal = 0;
                        $tax = 0;
                        $shipping = 0;
                        foreach ($carts as $key => $cartItem) {
                            $product = Product::find($cartItem['product_id']);
                            $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
                            $tax += cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
                            $shipping += $cartItem['shipping_cost'];
                        }
                        $sum = $subtotal + $tax + $shipping;
                        if ($sum >= $coupon_details->min_buy) {
                            if ($coupon->discount_type == 'percent') {
                                $coupon_discount = ($sum * $coupon->discount) / 100;
                                if ($coupon_discount > $coupon_details->max_discount) {
                                    $coupon_discount = $coupon_details->max_discount;
                                }
                            } elseif ($coupon->discount_type == 'amount') {
                                $coupon_discount = $coupon->discount;
                            }
                        }
                    } elseif ($coupon->type == 'product_base') {
                        foreach ($carts as $key => $cartItem) {
                            $product = Product::find($cartItem['product_id']);
                            foreach ($coupon_details as $key => $coupon_detail) {
                                if ($coupon_detail->product_id == $cartItem['product_id']) {
                                    if ($coupon->discount_type == 'percent') {
                                        $coupon_discount += (cart_product_price($cartItem, $product, false, false) * $coupon->discount / 100) * $cartItem['quantity'];
                                    } elseif ($coupon->discount_type == 'amount') {
                                        $coupon_discount += $coupon->discount * $cartItem['quantity'];
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ($coupon_discount > 0) {
                Cart::where('user_id', Auth::user()->id)
                    ->where('owner_id', $coupon->user_id)
                    ->update(
                        [
                            'discount' => $coupon_discount / count($carts),
                        ]
                    );
            } else {
                Cart::where('user_id', Auth::user()->id)
                    ->where('owner_id', $coupon->user_id)
                    ->update(
                        [
                            'discount' => 0,
                            'coupon_code' => null,
                        ]
                    );
            }
        }
        if ($formatted) {
            return format_price(convert_price($coupon_discount));
        } else {
            return $coupon_discount;
        }
    }
}


//Shows Price on page based on low to high
if (!function_exists('home_price')) {
    function home_price($product, $formatted = true)
    {
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $lowest_price += ($lowest_price * $product_tax->tax) / 100;
                $highest_price += ($highest_price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $lowest_price += $product_tax->tax;
                $highest_price += $product_tax->tax;
            }
        }

        if ($formatted) {
            if ($lowest_price == $highest_price) {
                return format_price(convert_price($lowest_price));
            } else {
                return format_price(convert_price($lowest_price)) . ' - ' . format_price(convert_price($highest_price));
            }
        } else {
            return $lowest_price . ' - ' . $highest_price;
        }
    }
}

//Shows Price on page based on low to high with discount
if (!function_exists('home_discounted_price')) {
    function home_discounted_price($product, $formatted = true)
    {
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $lowest_price -= ($lowest_price * $product->discount) / 100;
                $highest_price -= ($highest_price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $lowest_price -= $product->discount;
                $highest_price -= $product->discount;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $lowest_price += ($lowest_price * $product_tax->tax) / 100;
                $highest_price += ($highest_price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $lowest_price += $product_tax->tax;
                $highest_price += $product_tax->tax;
            }
        }

        if ($formatted) {
            if ($lowest_price == $highest_price) {
                return format_price(convert_price($lowest_price));
            } else {
                return format_price(convert_price($lowest_price)) . ' - ' . format_price(convert_price($highest_price));
            }
        } else {
            return $lowest_price . ' - ' . $highest_price;
        }
    }
}

//Shows Base Price
if (!function_exists('home_base_price_by_stock_id')) {
    function home_base_price_by_stock_id($id)
    {
        $product_stock = ProductStock::findOrFail($id);
        $price = $product_stock->price;
        $tax = 0;

        foreach ($product_stock->product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }
        $price += $tax;
        return format_price(convert_price($price));
    }
}


if (!function_exists('home_base_price')) {
    function home_base_price($product, $formatted = true)
    {
        // $price = $product->unit_price;
        $price = isset($product) ? $product->unit_price : null;

        $tax = 0;

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }
        $price += $tax;
        return $formatted ? format_price(convert_price($price)) : convert_price($price);
    }
}

//Shows Base Price with discount
if (!function_exists('home_discounted_base_price_by_stock_id')) {
    function home_discounted_base_price_by_stock_id($id)
    {
        $product_stock = ProductStock::findOrFail($id);
        $product = $product_stock->product;
        $price = $product_stock->price;
        $tax = 0;

        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }
        $price += $tax;

        return format_price(convert_price($price));
    }
}


//Shows Base Price with discount
if (!function_exists('home_discounted_base_price')) {
    function home_discounted_base_price($product, $formatted = true)
    {
        // $price = $product->unit_price;
        $price = isset($product) ? $product->unit_price : null;
        $tax = 0;

        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }
        $price += $tax;


        return $formatted ? format_price(convert_price($price)) : convert_price($price);
    }
}

if (!function_exists('renderStarRating')) {
    function renderStarRating($rating, $maxRating = 5)
    {
        $fullStar = "<i class = 'las la-star active'></i>";
        $halfStar = "<i class = 'las la-star half'></i>";
        $emptyStar = "<i class = 'las la-star'></i>";
        $rating = $rating <= $maxRating ? $rating : $maxRating;

        $fullStarCount = (int)$rating;
        $halfStarCount = ceil($rating) - $fullStarCount;
        $emptyStarCount = $maxRating - $fullStarCount - $halfStarCount;

        $html = str_repeat($fullStar, $fullStarCount);
        $html .= str_repeat($halfStar, $halfStarCount);
        $html .= str_repeat($emptyStar, $emptyStarCount);
        echo $html;
    }
}

function translate($key, $lang = null, $addslashes = false)
{
    if ($lang == null) {
        $lang = App::getLocale();
    }

    $lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($key)));

    $translations_en = Cache::rememberForever('translations-en', function () {
        return Translation::where('lang', 'en')->pluck('lang_value', 'lang_key')->toArray();
    });

    if (!isset($translations_en[$lang_key])) {
        $translation_def = new Translation;
        $translation_def->lang = 'en';
        $translation_def->lang_key = $lang_key;
        $translation_def->lang_value = str_replace(array("\r", "\n", "\r\n"), "", $key);
        $translation_def->save();
        Cache::forget('translations-en');
    }

    // return user session lang
    $translation_locale = Cache::rememberForever("translations-{$lang}", function () use ($lang) {
        return Translation::where('lang', $lang)->pluck('lang_value', 'lang_key')->toArray();
    });
    if (isset($translation_locale[$lang_key])) {
        return $addslashes ? addslashes(trim($translation_locale[$lang_key])) : trim($translation_locale[$lang_key]);
    }

    // return default lang if session lang not found
    $translations_default = Cache::rememberForever('translations-' . env('DEFAULT_LANGUAGE', 'en'), function () {
        return Translation::where('lang', env('DEFAULT_LANGUAGE', 'en'))->pluck('lang_value', 'lang_key')->toArray();
    });
    if (isset($translations_default[$lang_key])) {
        return $addslashes ? addslashes(trim($translations_default[$lang_key])) : trim($translations_default[$lang_key]);
    }

    // fallback to en lang
    if (!isset($translations_en[$lang_key])) {
        return trim($key);
    }
    return $addslashes ? addslashes(trim($translations_en[$lang_key])) : trim($translations_en[$lang_key]);
}

function remove_invalid_charcaters($str)
{
    $str = str_ireplace(array("\\"), '', $str);
    return str_ireplace(array('"'), '\"', $str);
}

if (!function_exists('translation_tables')) {
    function translation_tables($uniqueIdentifier)
    {
        $noTableAddons =  ['african_pg', 'paytm', 'pos_system'];
        if (!in_array($uniqueIdentifier, $noTableAddons)) {
            $addons = [];
            $addons['affiliate'] = ['affiliate_options', 'affiliate_configs', 'affiliate_users', 'affiliate_payments', 'affiliate_withdraw_requests', 'affiliate_logs', 'affiliate_stats'];
            $addons['auction'] = ['auction_product_bids'];
            $addons['club_point'] = ['club_points', 'club_point_details'];
            $addons['delivery_boy'] = ['delivery_boys', 'delivery_histories', 'delivery_boy_payments', 'delivery_boy_collections'];
            $addons['offline_payment'] = ['manual_payment_methods'];
            $addons['otp_system'] = ['otp_configurations', 'sms_templates'];
            $addons['refund_request'] = ['refund_requests'];
            $addons['seller_subscription'] = ['seller_packages', 'seller_package_translations', 'seller_package_payments'];
            $addons['wholesale'] = ['wholesale_prices'];

            foreach ($addons as $key => $addon_tables) {
                if ($key == $uniqueIdentifier) {
                    foreach ($addon_tables as $table) {
                        Schema::dropIfExists($table);
                    }
                }
            }
        }
    }
}

function getShippingCost($carts, $index, $carrier = '')
{
    $shipping_type = get_setting('shipping_type');
    $admin_products = array();
    $seller_products = array();
    $admin_product_total_weight = 0;
    $admin_product_total_price = 0;
    $seller_product_total_weight = array();
    $seller_product_total_price = array();

    $cartItem = $carts[$index];
    $product = Product::find($cartItem['product_id']);

    if ($product->digital == 1) {
        return 0;
    }

    foreach ($carts as $key => $cart_item) {
        $item_product = Product::find($cart_item['product_id']);
        if ($item_product->added_by == 'admin') {
            array_push($admin_products, $cart_item['product_id']);

            // For carrier wise shipping
            if ($shipping_type == 'carrier_wise_shipping') {
                $admin_product_total_weight += ($item_product->weight * $cart_item['quantity']);
                $admin_product_total_price += (cart_product_price($cart_item, $item_product, false, false) * $cart_item['quantity']);
            }
        } else {
            $product_ids = array();
            $weight = 0;
            $price = 0;
            if (isset($seller_products[$item_product->user_id])) {
                $product_ids = $seller_products[$item_product->user_id];

                // For carrier wise shipping
                if ($shipping_type == 'carrier_wise_shipping') {
                    $weight += $seller_product_total_weight[$item_product->user_id];
                    $price += $seller_product_total_price[$item_product->user_id];
                }
            }

            array_push($product_ids, $cart_item['product_id']);
            $seller_products[$item_product->user_id] = $product_ids;

            // For carrier wise shipping
            if ($shipping_type == 'carrier_wise_shipping') {
                $weight += ($item_product->weight * $cart_item['quantity']);
                $seller_product_total_weight[$item_product->user_id] = $weight;

                $price += (cart_product_price($cart_item, $item_product, false, false) * $cart_item['quantity']);
                $seller_product_total_price[$item_product->user_id] = $price;
            }
        }
    }

    if ($shipping_type == 'flat_rate') {
        return get_setting('flat_rate_shipping_cost') / count($carts);
    } elseif ($shipping_type == 'seller_wise_shipping') {
        if ($product->added_by == 'admin') {
            return get_setting('shipping_cost_admin') / count($admin_products);
        } else {
            return Shop::where('user_id', $product->user_id)->first()->shipping_cost / count($seller_products[$product->user_id]);
        }
    } elseif ($shipping_type == 'area_wise_shipping') {
        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
        $city = City::where('id', $shipping_info->city_id)->first();
        if ($city != null) {
            if ($product->added_by == 'admin') {
                return $city->cost / count($admin_products);
            } else {
                return $city->cost / count($seller_products[$product->user_id]);
            }
        }
        return 0;
    } elseif ($shipping_type == 'carrier_wise_shipping') { // carrier wise shipping
        $user_zone = Address::where('id', $carts[0]['address_id'])->first()->country->zone_id;
        if ($carrier == null || $user_zone == 0) {
            return 0;
        }

        $carrier = Carrier::find($carrier);
        if ($carrier->carrier_ranges->first()) {
            $carrier_billing_type   = $carrier->carrier_ranges->first()->billing_type;
            if ($product->added_by == 'admin') {
                $itemsWeightOrPrice = $carrier_billing_type == 'weight_based' ? $admin_product_total_weight : $admin_product_total_price;
            } else {
                $itemsWeightOrPrice = $carrier_billing_type == 'weight_based' ? $seller_product_total_weight[$product->user_id] : $seller_product_total_price[$product->user_id];
            }
        }

        foreach ($carrier->carrier_ranges as $carrier_range) {
            if ($itemsWeightOrPrice >= $carrier_range->delimiter1 && $itemsWeightOrPrice < $carrier_range->delimiter2) {
                $carrier_price = $carrier_range->carrier_range_prices->where('zone_id', $user_zone)->first()->price;
                return $product->added_by == 'admin' ? ($carrier_price / count($admin_products)) : ($carrier_price / count($seller_products[$product->user_id]));
            }
        }
        return 0;
    } else {
        if ($product->is_quantity_multiplied && ($shipping_type == 'product_wise_shipping')) {
            return  $product->shipping_cost * $cartItem['quantity'];
        }
        return $product->shipping_cost;
    }
}

//return carrier wise shipping cost against seller
if (!function_exists('carrier_base_price')) {
    function carrier_base_price($carts, $carrier_id, $owner_id)
    {
        $shipping = 0;
        foreach ($carts as $key => $cartItem) {
            if ($cartItem->owner_id == $owner_id) {
                $shipping_cost = getShippingCost($carts, $key, $carrier_id);
                $shipping += $shipping_cost;
            }
        }
        return $shipping;
    }
}

//return seller wise carrier list
if (!function_exists('seller_base_carrier_list')) {
    function seller_base_carrier_list($owner_id)
    {
        $carrier_list = array();
        $carts = Cart::where('user_id', auth()->user()->id)->get();
        if (count($carts) > 0) {
            $zone = $carts[0]['address'] ? Country::where('id', $carts[0]['address']['country_id'])->first()->zone_id : null;
            $carrier_query = Carrier::query();
            $carrier_query->whereIn('id', function ($query) use ($zone) {
                $query->select('carrier_id')->from('carrier_range_prices')
                    ->where('zone_id', $zone);
            })->orWhere('free_shipping', 1);
            $carrier_list = $carrier_query->active()->get();
        }
        return (new CarrierCollection($carrier_list))->extra($owner_id);
    }
}

function timezones()
{
    return array(
        '(GMT-12:00) International Date Line West' => 'Pacific/Kwajalein',
        '(GMT-11:00) Midway Island' => 'Pacific/Midway',
        '(GMT-11:00) Samoa' => 'Pacific/Apia',
        '(GMT-10:00) Hawaii' => 'Pacific/Honolulu',
        '(GMT-09:00) Alaska' => 'America/Anchorage',
        '(GMT-08:00) Pacific Time (US & Canada)' => 'America/Los_Angeles',
        '(GMT-08:00) Tijuana' => 'America/Tijuana',
        '(GMT-07:00) Arizona' => 'America/Phoenix',
        '(GMT-07:00) Mountain Time (US & Canada)' => 'America/Denver',
        '(GMT-07:00) Chihuahua' => 'America/Chihuahua',
        '(GMT-07:00) La Paz' => 'America/Chihuahua',
        '(GMT-07:00) Mazatlan' => 'America/Mazatlan',
        '(GMT-06:00) Central Time (US & Canada)' => 'America/Chicago',
        '(GMT-06:00) Central America' => 'America/Managua',
        '(GMT-06:00) Guadalajara' => 'America/Mexico_City',
        '(GMT-06:00) Mexico City' => 'America/Mexico_City',
        '(GMT-06:00) Monterrey' => 'America/Monterrey',
        '(GMT-06:00) Saskatchewan' => 'America/Regina',
        '(GMT-05:00) Eastern Time (US & Canada)' => 'America/New_York',
        '(GMT-05:00) Indiana (East)' => 'America/Indiana/Indianapolis',
        '(GMT-05:00) Bogota' => 'America/Bogota',
        '(GMT-05:00) Lima' => 'America/Lima',
        '(GMT-05:00) Quito' => 'America/Bogota',
        '(GMT-04:00) Atlantic Time (Canada)' => 'America/Halifax',
        '(GMT-04:00) Caracas' => 'America/Caracas',
        '(GMT-04:00) La Paz' => 'America/La_Paz',
        '(GMT-04:00) Santiago' => 'America/Santiago',
        '(GMT-03:30) Newfoundland' => 'America/St_Johns',
        '(GMT-03:00) Brasilia' => 'America/Sao_Paulo',
        '(GMT-03:00) Buenos Aires' => 'America/Argentina/Buenos_Aires',
        '(GMT-03:00) Georgetown' => 'America/Argentina/Buenos_Aires',
        '(GMT-03:00) Greenland' => 'America/Godthab',
        '(GMT-02:00) Mid-Atlantic' => 'America/Noronha',
        '(GMT-01:00) Azores' => 'Atlantic/Azores',
        '(GMT-01:00) Cape Verde Is.' => 'Atlantic/Cape_Verde',
        '(GMT) Casablanca' => 'Africa/Casablanca',
        '(GMT) Dublin' => 'Europe/London',
        '(GMT) Edinburgh' => 'Europe/London',
        '(GMT) Lisbon' => 'Europe/Lisbon',
        '(GMT) London' => 'Europe/London',
        '(GMT) UTC' => 'UTC',
        '(GMT) Monrovia' => 'Africa/Monrovia',
        '(GMT+01:00) Amsterdam' => 'Europe/Amsterdam',
        '(GMT+01:00) Belgrade' => 'Europe/Belgrade',
        '(GMT+01:00) Berlin' => 'Europe/Berlin',
        '(GMT+01:00) Bern' => 'Europe/Berlin',
        '(GMT+01:00) Bratislava' => 'Europe/Bratislava',
        '(GMT+01:00) Brussels' => 'Europe/Brussels',
        '(GMT+01:00) Budapest' => 'Europe/Budapest',
        '(GMT+01:00) Copenhagen' => 'Europe/Copenhagen',
        '(GMT+01:00) Ljubljana' => 'Europe/Ljubljana',
        '(GMT+01:00) Madrid' => 'Europe/Madrid',
        '(GMT+01:00) Paris' => 'Europe/Paris',
        '(GMT+01:00) Prague' => 'Europe/Prague',
        '(GMT+01:00) Rome' => 'Europe/Rome',
        '(GMT+01:00) Sarajevo' => 'Europe/Sarajevo',
        '(GMT+01:00) Skopje' => 'Europe/Skopje',
        '(GMT+01:00) Stockholm' => 'Europe/Stockholm',
        '(GMT+01:00) Vienna' => 'Europe/Vienna',
        '(GMT+01:00) Warsaw' => 'Europe/Warsaw',
        '(GMT+01:00) West Central Africa' => 'Africa/Lagos',
        '(GMT+01:00) Zagreb' => 'Europe/Zagreb',
        '(GMT+02:00) Athens' => 'Europe/Athens',
        '(GMT+02:00) Bucharest' => 'Europe/Bucharest',
        '(GMT+02:00) Cairo' => 'Africa/Cairo',
        '(GMT+02:00) Harare' => 'Africa/Harare',
        '(GMT+02:00) Helsinki' => 'Europe/Helsinki',
        '(GMT+02:00) Istanbul' => 'Europe/Istanbul',
        '(GMT+02:00) Jerusalem' => 'Asia/Jerusalem',
        '(GMT+02:00) Kyev' => 'Europe/Kiev',
        '(GMT+02:00) Minsk' => 'Europe/Minsk',
        '(GMT+02:00) Pretoria' => 'Africa/Johannesburg',
        '(GMT+02:00) Riga' => 'Europe/Riga',
        '(GMT+02:00) Sofia' => 'Europe/Sofia',
        '(GMT+02:00) Tallinn' => 'Europe/Tallinn',
        '(GMT+02:00) Vilnius' => 'Europe/Vilnius',
        '(GMT+03:00) Baghdad' => 'Asia/Baghdad',
        '(GMT+03:00) Kuwait' => 'Asia/Kuwait',
        '(GMT+03:00) Moscow' => 'Europe/Moscow',
        '(GMT+03:00) Nairobi' => 'Africa/Nairobi',
        '(GMT+03:00) Riyadh' => 'Asia/Riyadh',
        '(GMT+03:00) St. Petersburg' => 'Europe/Moscow',
        '(GMT+03:00) Volgograd' => 'Europe/Volgograd',
        '(GMT+03:30) Tehran' => 'Asia/Tehran',
        '(GMT+04:00) Abu Dhabi' => 'Asia/Muscat',
        '(GMT+04:00) Baku' => 'Asia/Baku',
        '(GMT+04:00) Muscat' => 'Asia/Muscat',
        '(GMT+04:00) Tbilisi' => 'Asia/Tbilisi',
        '(GMT+04:00) Yerevan' => 'Asia/Yerevan',
        '(GMT+04:30) Kabul' => 'Asia/Kabul',
        '(GMT+05:00) Ekaterinburg' => 'Asia/Yekaterinburg',
        '(GMT+05:00) Islamabad' => 'Asia/Karachi',
        '(GMT+05:00) Karachi' => 'Asia/Karachi',
        '(GMT+05:00) Tashkent' => 'Asia/Tashkent',
        '(GMT+05:30) Chennai' => 'Asia/Kolkata',
        '(GMT+05:30) Kolkata' => 'Asia/Kolkata',
        '(GMT+05:30) Mumbai' => 'Asia/Kolkata',
        '(GMT+05:30) New Delhi' => 'Asia/Kolkata',
        '(GMT+05:45) Kathmandu' => 'Asia/Kathmandu',
        '(GMT+06:00) Almaty' => 'Asia/Almaty',
        '(GMT+06:00) Astana' => 'Asia/Dhaka',
        '(GMT+06:00) Dhaka' => 'Asia/Dhaka',
        '(GMT+06:00) Novosibirsk' => 'Asia/Novosibirsk',
        '(GMT+06:00) Sri Jayawardenepura' => 'Asia/Colombo',
        '(GMT+06:30) Rangoon' => 'Asia/Rangoon',
        '(GMT+07:00) Bangkok' => 'Asia/Bangkok',
        '(GMT+07:00) Hanoi' => 'Asia/Bangkok',
        '(GMT+07:00) Jakarta' => 'Asia/Jakarta',
        '(GMT+07:00) Krasnoyarsk' => 'Asia/Krasnoyarsk',
        '(GMT+08:00) Beijing' => 'Asia/Hong_Kong',
        '(GMT+08:00) Chongqing' => 'Asia/Chongqing',
        '(GMT+08:00) Hong Kong' => 'Asia/Hong_Kong',
        '(GMT+08:00) Irkutsk' => 'Asia/Irkutsk',
        '(GMT+08:00) Kuala Lumpur' => 'Asia/Kuala_Lumpur',
        '(GMT+08:00) Perth' => 'Australia/Perth',
        '(GMT+08:00) Singapore' => 'Asia/Singapore',
        '(GMT+08:00) Taipei' => 'Asia/Taipei',
        '(GMT+08:00) Ulaan Bataar' => 'Asia/Irkutsk',
        '(GMT+08:00) Urumqi' => 'Asia/Urumqi',
        '(GMT+09:00) Osaka' => 'Asia/Tokyo',
        '(GMT+09:00) Sapporo' => 'Asia/Tokyo',
        '(GMT+09:00) Seoul' => 'Asia/Seoul',
        '(GMT+09:00) Tokyo' => 'Asia/Tokyo',
        '(GMT+09:00) Yakutsk' => 'Asia/Yakutsk',
        '(GMT+09:30) Adelaide' => 'Australia/Adelaide',
        '(GMT+09:30) Darwin' => 'Australia/Darwin',
        '(GMT+10:00) Brisbane' => 'Australia/Brisbane',
        '(GMT+10:00) Canberra' => 'Australia/Sydney',
        '(GMT+10:00) Guam' => 'Pacific/Guam',
        '(GMT+10:00) Hobart' => 'Australia/Hobart',
        '(GMT+10:00) Melbourne' => 'Australia/Melbourne',
        '(GMT+10:00) Port Moresby' => 'Pacific/Port_Moresby',
        '(GMT+10:00) Sydney' => 'Australia/Sydney',
        '(GMT+10:00) Vladivostok' => 'Asia/Vladivostok',
        '(GMT+11:00) Magadan' => 'Asia/Magadan',
        '(GMT+11:00) New Caledonia' => 'Asia/Magadan',
        '(GMT+11:00) Solomon Is.' => 'Asia/Magadan',
        '(GMT+12:00) Auckland' => 'Pacific/Auckland',
        '(GMT+12:00) Fiji' => 'Pacific/Fiji',
        '(GMT+12:00) Kamchatka' => 'Asia/Kamchatka',
        '(GMT+12:00) Marshall Is.' => 'Pacific/Fiji',
        '(GMT+12:00) Wellington' => 'Pacific/Auckland',
        '(GMT+13:00) Nuku\'alofa' => 'Pacific/Tongatapu'
    );
}

if (!function_exists('app_timezone')) {
    function app_timezone()
    {
        return config('app.timezone');
    }
}

//return file uploaded via uploader
if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {
        if (($asset = Upload::find($id)) != null) {
            return $asset->external_link == null ? my_asset($asset->file_name) : $asset->external_link;
        }
        return static_asset('assets/img/placeholder.jpg');
    }
}

if (!function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        if (config('filesystems.default') != 'local') {
            return Storage::disk(config('filesystems.default'))->url($path);
        }

        return app('url')->asset( $path, $secure);
    }
}

if (!function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function static_asset($path, $secure = null)
    {
        return app('url')->asset($path, $secure);
    }
}


// if (!function_exists('isHttps')) {
//     function isHttps()
//     {
//         return !empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']);
//     }
// }

if (!function_exists('getBaseURL')) {
    function getBaseURL()
    {
        $root = '//' . $_SERVER['HTTP_HOST'];
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        return $root;
    }
}


if (!function_exists('getFileBaseURL')) {
    function getFileBaseURL()
    {
        if (env('FILESYSTEM_DRIVER') != 'local') {
            return env(Str::upper(env('FILESYSTEM_DRIVER')) . '_URL') . '/';
        }

        return getBaseURL() . 'public/';
    }
}


if (!function_exists('isUnique')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function isUnique($email)
    {
        $user = \App\Models\User::where('email', $email)->first();

        if ($user == null) {
            return '1'; // $user = null means we did not get any match with the email provided by the user inside the database
        } else {
            return '0';
        }
    }
}

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null, $lang = false)
    {
        $settings = Cache::remember('business_settings', 86400, function () {
            return BusinessSetting::all();
        });

        if ($lang == false) {
            $setting = $settings->where('type', $key)->first();
        } else {
            $setting = $settings->where('type', $key)->where('lang', $lang)->first();
            $setting = !$setting ? $settings->where('type', $key)->first() : $setting;
        }
        return $setting == null ? $default : $setting->value;
    }
}

function hex2rgba($color, $opacity = false)
{
    return (new ColorCodeConverter())->convertHexToRgba($color, $opacity);
}

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        if (Auth::check() && (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff')) {
            return true;
        }
        return false;
    }
}

if (!function_exists('isSeller')) {
    function isSeller()
    {
        if (Auth::check() && Auth::user()->user_type == 'seller') {
            return true;
        }
        return false;
    }
}

if (!function_exists('isCustomer')) {
    function isCustomer()
    {
        if (Auth::check() && Auth::user()->user_type == 'customer') {
            return true;
        }
        return false;
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

// duplicates m$ excel's ceiling function
if (!function_exists('ceiling')) {
    function ceiling($number, $significance = 1)
    {
        return (is_numeric($number) && is_numeric($significance)) ? (ceil($number / $significance) * $significance) : false;
    }
}

//for api
if (!function_exists('get_images_path')) {
    function get_images_path($given_ids, $with_trashed = false)
    {
        $paths = [];
        foreach (explode(',', $given_ids) as $id) {
            $paths[] = uploaded_asset($id);
        }

        return $paths;
    }
}

//for api
if (!function_exists('checkout_done')) {
    function checkout_done($combined_order_id, $payment)
    {
        $combined_order = CombinedOrder::find($combined_order_id);

        foreach ($combined_order->orders as $key => $order) {
            $order->payment_status = 'paid';
            $order->payment_details = $payment;
            $order->save();

            try {
                NotificationUtility::sendOrderPlacedNotification($order);
                calculateCommissionAffilationClubPoint($order);
            } catch (\Exception $e) {
            }
        }
    }
}

// get user total ordered products
if (!function_exists('get_user_total_ordered_products')) {
    function get_user_total_ordered_products()
    {
        $orders_query = Order::query();
        $orders       = $orders_query->where('user_id', Auth::user()->id)->get();
        $total        = 0;
        foreach ($orders as $order) {
            $total += count($order->orderDetails);
        }
        return $total;
    }
}

//for api
if (!function_exists('wallet_payment_done')) {
    function wallet_payment_done($user_id, $amount, $payment_method, $payment_details)
    {
        $user = \App\Models\User::find($user_id);
        $user->balance = $user->balance + $amount;
        $user->save();

        $wallet = new Wallet;
        $wallet->user_id = $user->id;
        $wallet->amount = $amount;
        $wallet->payment_method = $payment_method;
        $wallet->payment_details = $payment_details;
        $wallet->save();
    }
}

if (!function_exists('purchase_payment_done')) {
    function purchase_payment_done($user_id, $package_id)
    {
        $user = User::findOrFail($user_id);
        $user->customer_package_id = $package_id;
        $customer_package = CustomerPackage::findOrFail($package_id);
        $user->remaining_uploads += $customer_package->product_upload;
        $user->save();

        return 'success';
    }
}

if (!function_exists('seller_purchase_payment_done')) {
    function seller_purchase_payment_done($user_id, $seller_package_id, $amount, $payment_method, $payment_details)
    {
        $seller = Shop::where('user_id', $user_id)->first();
        $seller->seller_package_id = $seller_package_id;
        $seller_package = SellerPackage::findOrFail($seller_package_id);
        $seller->product_upload_limit = $seller_package->product_upload_limit;
        $seller->package_invalid_at = date('Y-m-d', strtotime($seller->package_invalid_at . ' +' . $seller_package->duration . 'days'));
        $seller->save();

        $seller_package = new SellerPackagePayment();
        $seller_package->user_id = $user_id;
        $seller_package->seller_package_id = $seller_package_id;
        $seller_package->payment_method = $payment_method;
        $seller_package->payment_details = $payment_details;
        $seller_package->approval = 1;
        $seller_package->offline_payment = 2;
        $seller_package->save();
    }
}

if (!function_exists('customer_purchase_payment_done')) {
    function customer_purchase_payment_done($user_id, $customer_package_id)
    {
        $user = User::findOrFail($user_id);
        $user->customer_package_id = $customer_package_id;
        $customer_package = CustomerPackage::findOrFail($customer_package_id);
        $user->remaining_uploads += $customer_package->product_upload;
        $user->save();
    }
}

if (!function_exists('product_restock')) {
    function product_restock($orderDetail)
    {
        $variant = $orderDetail->variation;
        if ($orderDetail->variation == null) {
            $variant = '';
        }

        $product_stock = ProductStock::where('product_id', $orderDetail->product_id)
            ->where('variant', $variant)
            ->first();

        if ($product_stock != null) {
            $product_stock->qty += $orderDetail->quantity;
            $product_stock->save();
        }
    }
}

//Commission Calculation
if (!function_exists('calculateCommissionAffilationClubPoint')) {
    function calculateCommissionAffilationClubPoint($order)
    {
        (new CommissionController)->calculateCommission($order);

        if (addon_is_activated('affiliate_system')) {
            (new AffiliateController)->processAffiliatePoints($order);
        }

        if (addon_is_activated('club_point')) {
            if ($order->user != null) {
                (new ClubPointController)->processClubPoints($order);
            }
        }

        $order->commission_calculated = 1;
        $order->save();
    }
}

// Addon Activation Check
if (!function_exists('addon_is_activated')) {
    function addon_is_activated($identifier, $default = null)
    {
        $addons = Cache::remember('addons', 86400, function () {
            return Addon::all();
        });

        $activation = $addons->where('unique_identifier', $identifier)->where('activated', 1)->first();
        return $activation == null ? false : true;
    }
}

// Addon Activation Check
if (!function_exists('seller_package_validity_check')) {
    function seller_package_validity_check($user_id = null)
    {
        $user = $user_id == null ? \App\Models\User::find(Auth::user()->id) : \App\Models\User::find($user_id);
        $shop = $user->shop;
        $package_validation = false;
        if (
            $shop->product_upload_limit > $shop->user->products()->count()
            && $shop->package_invalid_at != null
            && Carbon::now()->diffInDays(Carbon::parse($shop->package_invalid_at), false) >= 0
        ) {
            $package_validation = true;
        }

        return $package_validation;
        // Ture = Seller package is valid and seller has the product upload limit
        // False = Seller package is invalid or seller product upload limit exists.
    }
}

// Get URL params
if (!function_exists('get_url_params')) {
    function get_url_params($url, $key)
    {
        $query_str = parse_url($url, PHP_URL_QUERY);
        parse_str($query_str, $query_params);

        return $query_params[$key] ?? '';
    }
}

// get Admin
if (!function_exists('get_admin')) {
    function get_admin()
    {
        $admin_query = User::query();
        return $admin_query->where('user_type', 'admin')->first();
    }
}

// Get slider images
if (!function_exists('get_slider_images')) {
    function get_slider_images($ids)
    {
        $slider_query = Upload::query();
        $sliders = $slider_query->whereIn('id', $ids)->get();
        return $sliders;
    }
}

if (!function_exists('get_featured_flash_deal')) {
    function get_featured_flash_deal()
    {
        $flash_deal_query = FlashDeal::query();
        $featured_flash_deal = $flash_deal_query->isActiveAndFeatured()
            ->where('start_date', '<=', strtotime(date('Y-m-d H:i:s')))
            ->where('end_date', '>=', strtotime(date('Y-m-d H:i:s')))
            ->first();

        return $featured_flash_deal;
    }
}

if (!function_exists('get_flash_deal_products')) {
    function get_flash_deal_products($flash_deal_id)
    {
        $flash_deal_product_query = FlashDealProduct::query();
        $flash_deal_product_query->where('flash_deal_id', $flash_deal_id);
        $flash_deal_products = $flash_deal_product_query->with('product')->limit(10)->get();

        return $flash_deal_products;
    }
}

if (!function_exists('get_active_flash_deals')) {
    function get_active_flash_deals()
    {
        $activated_flash_deal_query = FlashDeal::query();
        $activated_flash_deal_query = $activated_flash_deal_query->where("status", 1);

        return $activated_flash_deal_query->get();
    }
}

if (!function_exists('get_active_taxes')) {
    function get_active_taxes()
    {
        $activated_tax_query = Tax::query();
        $activated_tax_query = $activated_tax_query->where("tax_status", 1);

        return $activated_tax_query->get();
    }
}

if (!function_exists('get_system_language')) {
    function get_system_language()
    {
        $language_query = Language::query();

        $locale = 'en';
        if (Session::has('locale')) {
            $locale = Session::get('locale', Config::get('app.locale'));
        }

        $language_query->where('code',  $locale);

        return $language_query->first();
    }
}

if (!function_exists('get_all_active_language')) {
    function get_all_active_language()
    {
        $language_query = Language::query();
        $language_query->where('status', 1);

        return $language_query->get();
    }
}

// get Session langauge
if (!function_exists('get_session_language')) {
    function get_session_language()
    {
        $language_query = Language::query();
        return $language_query->where('code', Session::get('locale', Config::get('app.locale')))->first();
    }
}

if (!function_exists('get_system_currency')) {
    function get_system_currency()
    {
        $currency_query = Currency::query();
        if (Session::has('currency_code')) {
            $currency_query->where('code', Session::get('currency_code'));
        } else {
            $currency_query = $currency_query->where('id', get_setting('system_default_currency'));
        }

        return $currency_query->first();
    }
}

if (!function_exists('get_all_active_currency')) {
    function get_all_active_currency()
    {
        $currency_query = Currency::query();
        $currency_query->where('status', 1);

        return $currency_query->get();
    }
}

if (!function_exists('get_single_product')) {
    function get_single_product($product_id)
    {
        $product_query = Product::query()->with('thumbnail');
        return $product_query->find($product_id);
    }
}

// get multiple Products
if (!function_exists('get_multiple_products')) {
    function get_multiple_products($product_ids)
    {
        $products_query = Product::query();
        return $products_query->whereIn('id', $product_ids)->get();
    }
}

// get count of products
if (!function_exists('get_products_count')) {
    function get_products_count($user_id = null)
    {
        $products_query = Product::query();
        if ($user_id) {
            $products_query = $products_query->where('user_id', $user_id);
        }
        return $products_query->isApprovedPublished()->count();
    }
}

// get minimum unit price of products
if (!function_exists('get_product_min_unit_price')) {
    function get_product_min_unit_price($user_id = null)
    {
        $product_query = Product::query();
        if ($user_id) {
            $product_query = $product_query->where('user_id', $user_id);
        }
        return $product_query->isApprovedPublished()->min('unit_price');
    }
}

// get maximum unit price of products
if (!function_exists('get_product_max_unit_price')) {
    function get_product_max_unit_price($user_id = null)
    {
        $product_query = Product::query();
        if ($user_id) {
            $product_query = $product_query->where('user_id', $user_id);
        }
        return $product_query->isApprovedPublished()->max('unit_price');
    }
}

if (!function_exists('get_featured_products')) {
    function get_featured_products()
    {
        return Cache::remember('featured_products', 3600, function () {
            $product_query = Product::query();
            return filter_products($product_query->where('featured', '1'))->latest()->limit(12)->get();
        });
    }
}

if (!function_exists('get_best_selling_products')) {
    function get_best_selling_products($limit, $user_id = null)
    {
        $product_query = Product::query();
        if ($user_id) {
            $product_query = $product_query->where('user_id', $user_id);
        }
        return filter_products($product_query->orderBy('num_of_sale', 'desc'))->limit($limit)->get();
    }
}

// Get Seller Products
if (!function_exists('get_all_sellers')) {
    function get_all_sellers()
    {
        $seller_query = Seller::query();
        return $seller_query->get();
    }
}

// Get Seller Products
if (!function_exists('get_seller_products')) {
    function get_seller_products($user_id)
    {
        $product_query = Product::query();
        return $product_query->where('user_id', $user_id)->isApprovedPublished()->orderBy('created_at', 'desc')->limit(15)->get();
    }
}

// Get Seller Best Selling Products
if (!function_exists('get_shop_best_selling_products')) {
    function get_shop_best_selling_products($user_id)
    {
        $product_query = Product::query();
        return $product_query->where('user_id', $user_id)->isApprovedPublished()->orderBy('num_of_sale', 'desc')->paginate(24);
    }
}

// Get all auction Products
if (!function_exists('get_all_auction_products')) {
    function get_auction_products($limit = null, $paginate = null)
    {
        $product_query = Product::query();
        $products = $product_query->latest()->where('published', 1)->where('auction_product', 1);
        if (get_setting('seller_auction_product') == 0) {
            $products = $products->where('added_by', 'admin');
        }
        $products = $products->where('auction_start_date', '<=', strtotime("now"))->where('auction_end_date', '>=', strtotime("now"));

        if ($limit) {
            $products = $products->limit($limit);
        } elseif ($paginate) {
            return $products->paginate($paginate);
        }
        return $products->get();
    }
}

//Get similiar classified products
if (!function_exists('get_similiar_classified_products')) {
    function get_similiar_classified_products($category_id = '', $product_id = '', $limit = '')
    {
        $classified_product_query = CustomerProduct::query();
        if ($category_id) {
            $classified_product_query->where('category_id', $category_id);
        }
        if ($product_id) {
            $classified_product_query->where('id', '!=', $product_id);
        }
        $classified_product_query->isActiveAndApproval();
        if ($limit) {
            $classified_product_query->take($limit);
        }

        return $classified_product_query->get();
    }
}

//Get home page classified products
if (!function_exists('get_home_page_classified_products')) {
    function get_home_page_classified_products($limit = '')
    {
        $classified_product_query = CustomerProduct::query()->with('user', 'thumbnail');
        $classified_product_query->isActiveAndApproval();
        if ($limit) {
            $classified_product_query->take($limit);
        }

        return $classified_product_query->get();
    }
}

// Get related product
if (!function_exists('get_related_products')) {
    function get_related_products($product)
    {
        $product_query = Product::query();
        return filter_products($product_query->where('id', '!=', $product->id)->where('category_id', $product->category_id))->limit(10)->get();
    }
}

// Get all brands
if (!function_exists('get_all_brands')) {
    function get_all_brands()
    {
        $brand_query = Brand::query();
        return  $brand_query->get();
    }
}

// Get single brands
if (!function_exists('get_brands')) {
    function get_brands($brand_ids)
    {
        $brand_query = Brand::query();
        $brand_query->with('brandLogo');
        // $brands = $brand_query->whereIn('id', $brand_ids)->get();
        // return $brands;
    }
}

// Get single brands
if (!function_exists('get_single_brand')) {
    function get_single_brand($brand_id)
    {
        $brand_query = Brand::query();
        return $brand_query->find($brand_id);
    }
}

// Get Brands by products
if (!function_exists('get_brands_by_products')) {
    function get_brands_by_products($usrt_id)
    {
        $product_query = Product::query();
        $brand_ids =  $product_query->where('user_id', $usrt_id)->isApprovedPublished()->whereNotNull('brand_id')->pluck('brand_id')->toArray();

        $brand_query = Brand::query();
        return $brand_query->whereIn('id', $brand_ids)->get();
    }
}

// Get category
if (!function_exists('get_category')) {
    function get_category($category_ids)
    {
        $category_query = Category::query();
        $category_query->with('coverImage');

        $category_query->whereIn('id', $category_ids);

        $categories = $category_query->get();
        return $categories;
    }
}

// Get single category
if (!function_exists('get_single_category')) {
    function get_single_category($category_id)
    {
        $category_query = Category::query()->with('coverImage');
        return $category_query->find($category_id);
    }
}

// Get categories by level zero
if (!function_exists('get_level_zero_categories')) {
    function get_level_zero_categories()
    {
        $categories_query = Category::query()->with(['coverImage', 'catIcon']);
        return $categories_query->where('level', 0)->orderBy('order_level', 'desc')->get();
    }
}

// Get categories by products
if (!function_exists('get_categories_by_products')) {
    function get_categories_by_products($user_id)
    {
        $product_query = Product::query();
        $category_ids = $product_query->where('user_id', $user_id)->isApprovedPublished()->pluck('category_id')->toArray();

        $category_query = Category::query();
        return $category_query->whereIn('id', $category_ids)->get();
    }
}

// Get single Color name
if (!function_exists('get_single_color_name')) {
    function get_single_color_name($color)
    {
        $color_query = Color::query();
        return $color_query->where('code', $color)->first()->name;
    }
}

// Get single Attribute
if (!function_exists('get_single_attribute_name')) {
    function get_single_attribute_name($attribute)
    {
        $attribute_query = Attribute::query();
        return $attribute_query->find($attribute)->getTranslation('name');
    }
}

// Get user cart
if (!function_exists('get_user_cart')) {
    function get_user_cart()
    {
        $cart = [];
        if (auth()->user() != null) {
            $cart = Cart::where('user_id', Auth::user()->id)->get();
        } else {
            $temp_user_id = Session()->get('temp_user_id');
            if ($temp_user_id) {
                $cart = Cart::where('temp_user_id', $temp_user_id)->get();
            }
        }
        return $cart;
    }
}

// Get user Wishlist
if (!function_exists('get_user_wishlist')) {
    function get_user_wishlist()
    {
        $wishlist_query = Wishlist::query();
        return $wishlist_query->where('user_id', Auth::user()->id)->get();
    }
}

//Get best seller
if (!function_exists('get_best_sellers')) {
    function get_best_sellers($limit = '')
    {
        return Cache::remember('best_selers', 86400, function () use ($limit) {
            return Shop::where('verification_status', 1)->orderBy('num_of_sale', 'desc')->take($limit)->get();
        });
    }
}

//Get users followed sellers
if (!function_exists('get_followed_sellers')) {
    function get_followed_sellers()
    {
        $followed_seller_query = FollowSeller::query();
        return $followed_seller_query->where('user_id', Auth::user()->id)->pluck('shop_id')->toArray();
    }
}

// Get Order Details
if (!function_exists('get_order_details')) {
    function get_order_details($order_id)
    {
        $order_detail_query = OrderDetail::query();
        return  $order_detail_query->find($order_id);
    }
}

// Get Order Details
if (!function_exists('get_order_details_by_product')) {
    function get_order_details_by_product($product_id)
    {
        $order_detail_query = OrderDetail::query();
        return  $order_detail_query->where('product_id', $product_id)->first();
    }
}

// Get Order Details by review
if (!function_exists('get_order_details_by_review')) {
    function get_order_details_by_review($review)
    {
        $order_detail_query = OrderDetail::query();
        return $order_detail_query->with(['order' => function ($q) use ($review) {
            $q->where('user_id', $review->user_id);
        }])->where('product_id', $review->product_id)->where('delivery_status', 'delivered')->first();
    }
}


// Get user total expenditure
if (!function_exists('get_user_total_expenditure')) {
    function get_user_total_expenditure()
    {
        $user_expenditure_query = Order::query();
        return  $user_expenditure_query->where('user_id', Auth::user()->id)->where('payment_status', 'paid')->sum('grand_total');
    }
}

// Get count by delivery viewed
if (!function_exists('get_count_by_delivery_viewed')) {
    function get_count_by_delivery_viewed()
    {
        $order_query = Order::query();
        return  $order_query->where('user_id', Auth::user()->id)->where('delivery_viewed', 0)->get()->count();
    }
}

// Get delivery boy info
if (!function_exists('get_delivery_boy_info')) {
    function get_delivery_boy_info()
    {
        $delivery_boy_info_query = DeliveryBoy::query();
        return  $delivery_boy_info_query->where('user_id', Auth::user()->id)->first();
    }
}

// Get count by completed delivery
if (!function_exists('get_delivery_boy_total_completed_delivery')) {
    function get_delivery_boy_total_completed_delivery()
    {
        $delivery_boy_delivery_query = Order::query();
        return  $delivery_boy_delivery_query->where('assign_delivery_boy', Auth::user()->id)
            ->where('delivery_status', 'delivered')
            ->count();
    }
}

// Get count by pending delivery
if (!function_exists('get_delivery_boy_total_pending_delivery')) {
    function get_delivery_boy_total_pending_delivery()
    {
        $delivery_boy_delivery_query = Order::query();
        return  $delivery_boy_delivery_query->where('assign_delivery_boy', Auth::user()->id)
            ->where('delivery_status', '!=', 'delivered')
            ->where('delivery_status', '!=', 'cancelled')
            ->where('cancel_request', '0')
            ->count();
    }
}

// Get count by cancelled delivery
if (!function_exists('get_delivery_boy_total_cancelled_delivery')) {
    function get_delivery_boy_total_cancelled_delivery()
    {
        $delivery_boy_delivery_query = Order::query();
        return  $delivery_boy_delivery_query->where('assign_delivery_boy', Auth::user()->id)
            ->where('delivery_status', 'cancelled')
            ->count();
    }
}

// Get count by payment status viewed
if (!function_exists('get_order_info')) {
    function get_order_info($order_id = null)
    {
        $order_query = Order::query();
        return  $order_query->where('id', $order_id)->first();
    }
}

// Get count by payment status viewed
if (!function_exists('get_user_order_by_id')) {
    function get_user_order_by_id($order_id = null)
    {
        $order_query = Order::query();
        return  $order_query->where('id', $order_id)->where('user_id', Auth::user()->id)->first();
    }
}

// Get Auction Product Bid Info
if (!function_exists('get_auction_product_bid_info')) {
    function get_auction_product_bid_info($bid_id = null)
    {
        $product_bid_info_query = AuctionProductBid::query();
        return  $product_bid_info_query->where('id', $bid_id)->first();
    }
}

// Get count by payment status viewed
if (!function_exists('get_count_by_payment_status_viewed')) {
    function get_count_by_payment_status_viewed()
    {
        $order_query = Order::query();
        return  $order_query->where('user_id', Auth::user()->id)->where('payment_status_viewed', 0)->get()->count();
    }
}

// Get Uploaded file
if (!function_exists('get_single_uploaded_file')) {
    function get_single_uploaded_file($file_id)
    {
        $file_query = Upload::query();
        return $file_query->find($file_id);
    }
}

// Get single customer package file
if (!function_exists('get_single_customer_package')) {
    function get_single_customer_package($package_id)
    {
        $customer_package_query = CustomerPackage::query();
        return $customer_package_query->find($package_id);
    }
}

// Get single Seller package file
if (!function_exists('get_single_seller_package')) {
    function get_single_seller_package($package_id)
    {
        $seller_package_query = SellerPackage::query();
        return $seller_package_query->find($package_id);
    }
}

// Get user last wallet recharge
if (!function_exists('get_user_last_wallet_recharge')) {
    function get_user_last_wallet_recharge()
    {
        $recharge_query = Wallet::query();
        return $recharge_query->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
    }
}

// Get user total Club point
if (!function_exists('get_user_total_club_point')) {
    function get_user_total_club_point()
    {
        $club_point_query = ClubPoint::query();
        return $club_point_query->where('user_id', Auth::user()->id)->where('convert_status', 0)->sum('points');
    }
}

// Get all manual payment methods
if (!function_exists('get_all_manual_payment_methods')) {
    function get_all_manual_payment_methods()
    {
        $manual_payment_methods_query = ManualPaymentMethod::query();
        return $manual_payment_methods_query->get();
    }
}

// Get all blog category
if (!function_exists('get_all_blog_categories')) {
    function get_all_blog_categories()
    {
        $blog_category_query = BlogCategory::query();
        return  $blog_category_query->get();
    }
}

// Get all Pickup Points
if (!function_exists('get_all_pickup_points')) {
    function get_all_pickup_points()
    {
        $pickup_points_query = PickupPoint::query();
        return  $pickup_points_query->isActive()->get();
    }
}

// get Shop by user id
if (!function_exists('get_shop_by_user_id')) {
    function get_shop_by_user_id($user_id)
    {
        $shop_query = Shop::query();
        return $shop_query->where('user_id', $user_id)->first();
    }
}

// get Coupons
if (!function_exists('get_coupons')) {
    function get_coupons($user_id = null, $paginate = null)
    {
        $coupon_query = Coupon::query();
        $coupon_query = $coupon_query->where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')));
        if ($user_id) {
            $coupon_query = $coupon_query->where('user_id', $user_id);
        }
        if ($paginate) {
            return $coupon_query->paginate($paginate);
        }
        return $coupon_query->get();
    }
}

// get non-viewed Conversations
if (!function_exists('get_non_viewed_conversations')) {
    function get_non_viewed_conversations()
    {
        $Conversation_query = Conversation::query();
        return $Conversation_query->where('sender_id', Auth::user()->id)->where('sender_viewed', 0)->get();
    }
}

// get affliate option status
if (!function_exists('get_affliate_option_status')) {
    function get_affliate_option_status($status = false)
    {
        if (
            AffiliateOption::where('type', 'product_sharing')->first()->status ||
            AffiliateOption::where('type', 'category_wise_affiliate')->first()->status
        ) {
            $status = true;
        }
        return $status;
    }
}

// get affliate option purchase status
if (!function_exists('get_affliate_purchase_option_status')) {
    function get_affliate_purchase_option_status($status = false)
    {
        if (AffiliateOption::where('type', 'user_registration_first_purchase')->first()->status) {
            $status = true;
        }
        return $status;
    }
}

// get affliate config
if (!function_exists('get_Affiliate_onfig_value')) {
    function get_Affiliate_onfig_value()
    {
        return AffiliateConfig::where('type', 'verification_form')->first()->value;
    }
}

// Welcome Coupon add for user
if (!function_exists('offerUserWelcomeCoupon')) {
    function offerUserWelcomeCoupon()
    {
        $coupon = Coupon::where('type', 'welcome_base')->where('status', 1)->first();
        if ($coupon) {

            $couponDetails = json_decode($coupon->details);

            $user_coupon                = new UserCoupon();
            $user_coupon->user_id       = auth()->user()->id;
            $user_coupon->coupon_id     = $coupon->id;
            $user_coupon->coupon_code   = $coupon->code;
            $user_coupon->min_buy       = $couponDetails->min_buy;
            $user_coupon->validation_days = $couponDetails->validation_days;
            $user_coupon->discount      = $coupon->discount;
            $user_coupon->discount_type = $coupon->discount_type;
            $user_coupon->expiry_date   = strtotime(date('d-m-Y H:i:s') . ' +' . $couponDetails->validation_days . 'days');
            $user_coupon->save();
        }
    }
}

// get User Welcome Coupon
if (!function_exists('ifUserHasWelcomeCouponAndNotUsed')) {
    function ifUserHasWelcomeCouponAndNotUsed()
    {
        $user = auth()->user();
        $userCoupon = $user->userCoupon;

        if($userCoupon){
            if($userCoupon->expiry_date >=strtotime(date('d-m-Y H:i:s'))){
                $couponUse = $userCoupon->coupon->couponUsages->where('user_id',$user->id)->first();
                if(!$couponUse){
                    return $userCoupon;
                }
            }
        }

        return false;
    }
}

// get dev mail
if (!function_exists('get_dev_mail')) {
    function get_dev_mail()
    {
        $dev_mail = (chr(100) . chr(101) . chr(118) . chr(101) . chr(108) . chr(111) . chr(112) . chr(101) . chr(114) . chr(46)
            . chr(97) . chr(99) . chr(116) . chr(105) . chr(118) . chr(101) . chr(105) . chr(116) . chr(122) . chr(111)
            . chr(110) . chr(101) . chr(64) . chr(103) . chr(109) . chr(97) . chr(105) . chr(108) . chr(46) . chr(99) . chr(111) . chr(109));
        return $dev_mail;
    }
}


// Get Thumbnail Image
if (!function_exists('get_image')) {
    function get_image($image)
    {
        $image_url = static_asset('assets/img/placeholder.jpg');
        if ($image != null) {
            $image_url = $image->external_link == null ? my_asset($image->file_name) : $image->external_link;
        }
        return $image_url;
    }
}

// Get POS user cart
if (!function_exists('get_pos_user_cart')) {
    function get_pos_user_cart($sessionUserID = null, $sessionTemUserId = null)
    {
        $cart               = [];
        $authUser           = auth()->user();
        $owner_id           = $authUser->type == 'admin' ? User::where('user_type', 'admin')->first()->id : $authUser->id;

        if ($sessionUserID == null) {
            $sessionUserID = Session::has('pos.user_id') ? Session::get('pos.user_id') : null;
        }
        if ($sessionTemUserId == null) {
            $sessionTemUserId = Session::has('pos.temp_user_id') ? Session::get('pos.temp_user_id') : null;
        }

        $cart = Cart::where('owner_id', $owner_id)->where('user_id', $sessionUserID)->where('temp_user_id', $sessionTemUserId)->get();
        return $cart;
    }
}

if (!function_exists('number_format_short')) {
    function number_format_short($n, $precision = 1)
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }

        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }

        return $n_format . $suffix;
    }
}

if (!function_exists('timezones')) {
    function timezones()
    {
        return array(
            '(GMT-12:00) International Date Line West' => 'Pacific/Kwajalein',
            '(GMT-11:00) Midway Island' => 'Pacific/Midway',
            '(GMT-11:00) Samoa' => 'Pacific/Apia',
            '(GMT-10:00) Hawaii' => 'Pacific/Honolulu',
            '(GMT-09:00) Alaska' => 'America/Anchorage',
            '(GMT-08:00) Pacific Time (US & Canada)' => 'America/Los_Angeles',
            '(GMT-08:00) Tijuana' => 'America/Tijuana',
            '(GMT-07:00) Arizona' => 'America/Phoenix',
            '(GMT-07:00) Mountain Time (US & Canada)' => 'America/Denver',
            '(GMT-07:00) Chihuahua' => 'America/Chihuahua',
            '(GMT-07:00) La Paz' => 'America/Chihuahua',
            '(GMT-07:00) Mazatlan' => 'America/Mazatlan',
            '(GMT-06:00) Central Time (US & Canada)' => 'America/Chicago',
            '(GMT-06:00) Central America' => 'America/Managua',
            '(GMT-06:00) Guadalajara' => 'America/Mexico_City',
            '(GMT-06:00) Mexico City' => 'America/Mexico_City',
            '(GMT-06:00) Monterrey' => 'America/Monterrey',
            '(GMT-06:00) Saskatchewan' => 'America/Regina',
            '(GMT-05:00) Eastern Time (US & Canada)' => 'America/New_York',
            '(GMT-05:00) Indiana (East)' => 'America/Indiana/Indianapolis',
            '(GMT-05:00) Bogota' => 'America/Bogota',
            '(GMT-05:00) Lima' => 'America/Lima',
            '(GMT-05:00) Quito' => 'America/Bogota',
            '(GMT-04:00) Atlantic Time (Canada)' => 'America/Halifax',
            '(GMT-04:00) Caracas' => 'America/Caracas',
            '(GMT-04:00) La Paz' => 'America/La_Paz',
            '(GMT-04:00) Santiago' => 'America/Santiago',
            '(GMT-03:30) Newfoundland' => 'America/St_Johns',
            '(GMT-03:00) Brasilia' => 'America/Sao_Paulo',
            '(GMT-03:00) Buenos Aires' => 'America/Argentina/Buenos_Aires',
            '(GMT-03:00) Georgetown' => 'America/Argentina/Buenos_Aires',
            '(GMT-03:00) Greenland' => 'America/Godthab',
            '(GMT-02:00) Mid-Atlantic' => 'America/Noronha',
            '(GMT-01:00) Azores' => 'Atlantic/Azores',
            '(GMT-01:00) Cape Verde Is.' => 'Atlantic/Cape_Verde',
            '(GMT) Casablanca' => 'Africa/Casablanca',
            '(GMT) Dublin' => 'Europe/London',
            '(GMT) Edinburgh' => 'Europe/London',
            '(GMT) Lisbon' => 'Europe/Lisbon',
            '(GMT) London' => 'Europe/London',
            '(GMT) UTC' => 'UTC',
            '(GMT) Monrovia' => 'Africa/Monrovia',
            '(GMT+01:00) Amsterdam' => 'Europe/Amsterdam',
            '(GMT+01:00) Belgrade' => 'Europe/Belgrade',
            '(GMT+01:00) Berlin' => 'Europe/Berlin',
            '(GMT+01:00) Bern' => 'Europe/Berlin',
            '(GMT+01:00) Bratislava' => 'Europe/Bratislava',
            '(GMT+01:00) Brussels' => 'Europe/Brussels',
            '(GMT+01:00) Budapest' => 'Europe/Budapest',
            '(GMT+01:00) Copenhagen' => 'Europe/Copenhagen',
            '(GMT+01:00) Ljubljana' => 'Europe/Ljubljana',
            '(GMT+01:00) Madrid' => 'Europe/Madrid',
            '(GMT+01:00) Paris' => 'Europe/Paris',
            '(GMT+01:00) Prague' => 'Europe/Prague',
            '(GMT+01:00) Rome' => 'Europe/Rome',
            '(GMT+01:00) Sarajevo' => 'Europe/Sarajevo',
            '(GMT+01:00) Skopje' => 'Europe/Skopje',
            '(GMT+01:00) Stockholm' => 'Europe/Stockholm',
            '(GMT+01:00) Vienna' => 'Europe/Vienna',
            '(GMT+01:00) Warsaw' => 'Europe/Warsaw',
            '(GMT+01:00) West Central Africa' => 'Africa/Lagos',
            '(GMT+01:00) Zagreb' => 'Europe/Zagreb',
            '(GMT+02:00) Athens' => 'Europe/Athens',
            '(GMT+02:00) Bucharest' => 'Europe/Bucharest',
            '(GMT+02:00) Cairo' => 'Africa/Cairo',
            '(GMT+02:00) Harare' => 'Africa/Harare',
            '(GMT+02:00) Helsinki' => 'Europe/Helsinki',
            '(GMT+02:00) Istanbul' => 'Europe/Istanbul',
            '(GMT+02:00) Jerusalem' => 'Asia/Jerusalem',
            '(GMT+02:00) Kyev' => 'Europe/Kiev',
            '(GMT+02:00) Minsk' => 'Europe/Minsk',
            '(GMT+02:00) Pretoria' => 'Africa/Johannesburg',
            '(GMT+02:00) Riga' => 'Europe/Riga',
            '(GMT+02:00) Sofia' => 'Europe/Sofia',
            '(GMT+02:00) Tallinn' => 'Europe/Tallinn',
            '(GMT+02:00) Vilnius' => 'Europe/Vilnius',
            '(GMT+03:00) Baghdad' => 'Asia/Baghdad',
            '(GMT+03:00) Kuwait' => 'Asia/Kuwait',
            '(GMT+03:00) Moscow' => 'Europe/Moscow',
            '(GMT+03:00) Nairobi' => 'Africa/Nairobi',
            '(GMT+03:00) Riyadh' => 'Asia/Riyadh',
            '(GMT+03:00) St. Petersburg' => 'Europe/Moscow',
            '(GMT+03:00) Volgograd' => 'Europe/Volgograd',
            '(GMT+03:30) Tehran' => 'Asia/Tehran',
            '(GMT+04:00) Abu Dhabi' => 'Asia/Muscat',
            '(GMT+04:00) Baku' => 'Asia/Baku',
            '(GMT+04:00) Muscat' => 'Asia/Muscat',
            '(GMT+04:00) Tbilisi' => 'Asia/Tbilisi',
            '(GMT+04:00) Yerevan' => 'Asia/Yerevan',
            '(GMT+04:30) Kabul' => 'Asia/Kabul',
            '(GMT+05:00) Ekaterinburg' => 'Asia/Yekaterinburg',
            '(GMT+05:00) Islamabad' => 'Asia/Karachi',
            '(GMT+05:00) Karachi' => 'Asia/Karachi',
            '(GMT+05:00) Tashkent' => 'Asia/Tashkent',
            '(GMT+05:30) Chennai' => 'Asia/Kolkata',
            '(GMT+05:30) Kolkata' => 'Asia/Kolkata',
            '(GMT+05:30) Mumbai' => 'Asia/Kolkata',
            '(GMT+05:30) New Delhi' => 'Asia/Kolkata',
            '(GMT+05:45) Kathmandu' => 'Asia/Kathmandu',
            '(GMT+06:00) Almaty' => 'Asia/Almaty',
            '(GMT+06:00) Astana' => 'Asia/Dhaka',
            '(GMT+06:00) Dhaka' => 'Asia/Dhaka',
            '(GMT+06:00) Novosibirsk' => 'Asia/Novosibirsk',
            '(GMT+06:00) Sri Jayawardenepura' => 'Asia/Colombo',
            '(GMT+06:30) Rangoon' => 'Asia/Rangoon',
            '(GMT+07:00) Bangkok' => 'Asia/Bangkok',
            '(GMT+07:00) Hanoi' => 'Asia/Bangkok',
            '(GMT+07:00) Jakarta' => 'Asia/Jakarta',
            '(GMT+07:00) Krasnoyarsk' => 'Asia/Krasnoyarsk',
            '(GMT+08:00) Beijing' => 'Asia/Hong_Kong',
            '(GMT+08:00) Chongqing' => 'Asia/Chongqing',
            '(GMT+08:00) Hong Kong' => 'Asia/Hong_Kong',
            '(GMT+08:00) Irkutsk' => 'Asia/Irkutsk',
            '(GMT+08:00) Kuala Lumpur' => 'Asia/Kuala_Lumpur',
            '(GMT+08:00) Perth' => 'Australia/Perth',
            '(GMT+08:00) Singapore' => 'Asia/Singapore',
            '(GMT+08:00) Taipei' => 'Asia/Taipei',
            '(GMT+08:00) Ulaan Bataar' => 'Asia/Irkutsk',
            '(GMT+08:00) Urumqi' => 'Asia/Urumqi',
            '(GMT+09:00) Osaka' => 'Asia/Tokyo',
            '(GMT+09:00) Sapporo' => 'Asia/Tokyo',
            '(GMT+09:00) Seoul' => 'Asia/Seoul',
            '(GMT+09:00) Tokyo' => 'Asia/Tokyo',
            '(GMT+09:00) Yakutsk' => 'Asia/Yakutsk',
            '(GMT+09:30) Adelaide' => 'Australia/Adelaide',
            '(GMT+09:30) Darwin' => 'Australia/Darwin',
            '(GMT+10:00) Brisbane' => 'Australia/Brisbane',
            '(GMT+10:00) Canberra' => 'Australia/Sydney',
            '(GMT+10:00) Guam' => 'Pacific/Guam',
            '(GMT+10:00) Hobart' => 'Australia/Hobart',
            '(GMT+10:00) Melbourne' => 'Australia/Melbourne',
            '(GMT+10:00) Port Moresby' => 'Pacific/Port_Moresby',
            '(GMT+10:00) Sydney' => 'Australia/Sydney',
            '(GMT+10:00) Vladivostok' => 'Asia/Vladivostok',
            '(GMT+11:00) Magadan' => 'Asia/Magadan',
            '(GMT+11:00) New Caledonia' => 'Asia/Magadan',
            '(GMT+11:00) Solomon Is.' => 'Asia/Magadan',
            '(GMT+12:00) Auckland' => 'Pacific/Auckland',
            '(GMT+12:00) Fiji' => 'Pacific/Fiji',
            '(GMT+12:00) Kamchatka' => 'Asia/Kamchatka',
            '(GMT+12:00) Marshall Is.' => 'Pacific/Fiji',
            '(GMT+12:00) Wellington' => 'Pacific/Auckland',
            '(GMT+13:00) Nuku\'alofa' => 'Pacific/Tongatapu'
        );
    }
}


//avg start rating by product id
if (!function_exists('avg_start_rating')) {
    function avg_start_rating($product_id)
    {
        $avg = Review::where('product_id', $product_id)->avg('rating');
        return $avg;
    }
}

// count review by product id
if (!function_exists('count_review')) {
    function count_review($product_id)
    {
        $count = Review::where('product_id', $product_id)->count();
        return $count;
    }
}
//get all products
if(!function_exists('get_all_products')){
    function get_all_products(){
        $product_query = Product::query();
        return $product_query->isApprovedPublished()->orderBy('created_at', 'desc')->limit(18)->get();
    }
}

//get one new product
if (!function_exists('get_todays_product')) {
    function get_todays_product()
    {
        $product_query = Product::query();
        return $product_query->where('published', 1)->orderBy('created_at', 'desc')->first();
    }
}