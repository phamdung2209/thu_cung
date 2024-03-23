<?php

/*
|--------------------------------------------------------------------------
| POS Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\PosController;
use App\Http\Controllers\BusinessSettingsController;
use App\Http\Controllers\Seller\PosController as SellerPosController;

Route::controller(PosController::class)->group(function () {
    
});

//Admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    //pos
    Route::controller(PosController::class)->group(function () {
        Route::get('/pos', 'index')->name('poin-of-sales.index');
        Route::get('/pos/products', 'search')->name('pos.search_product');
        Route::post('/add-to-cart-pos', 'addToCart')->name('pos.addToCart');
        Route::post('/update-quantity-cart-pos', 'updateQuantity')->name('pos.updateQuantity');
        Route::post('/remove-from-cart-pos', 'removeFromCart')->name('pos.removeFromCart');
        Route::post('/update-session-user-cart-data', 'updateSessionUserCartData')->name('pos.updateSessionUserCartData');
        Route::post('/get_shipping_address', 'getShippingAddress')->name('pos.getShippingAddress');
        Route::post('/setDiscount', 'setDiscount')->name('pos.setDiscount');
        Route::post('/setShipping', 'setShipping')->name('pos.setShipping');
        Route::post('/set-shipping-address', 'set_shipping_address')->name('pos.set-shipping-address');
        Route::post('/pos-order-summary', 'get_order_summary')->name('pos.getOrderSummary');
        Route::post('/pos-order', 'order_store')->name('pos.order_place');
        Route::get('/pos-activation', 'configuration')->name('poin-of-sales.activation');
        Route::get('/pos/thermal-printer/{order_id}', 'invoice')->name('admin.invoice.thermal_printer');
    });
});

//Seller
Route::group(['prefix' => 'seller', 'middleware' => ['seller', 'verified']], function () {
    Route::controller(SellerPosController::class)->group(function () {
        Route::get('/pos', 'index')->name('poin-of-sales.seller_index');
        Route::get('/pos/products', 'search')->name('pos.search_seller_product');
        Route::post('/add-to-cart-pos', 'addToCart')->name('seller.pos.addToCart');
        Route::post('/update-quantity-cart-pos', 'updateQuantity')->name('seller.pos.updateQuantity');
        Route::post('/remove-from-cart-pos', 'removeFromCart')->name('seller.pos.removeFromCart');
        Route::post('/update-session-user-cart-data', 'updateSessionUserCartData')->name('seller.pos.updateSessionUserCartData');
        Route::post('/get_shipping_address', 'getShippingAddress')->name('seller.pos.getShippingAddress');
        Route::post('/setDiscount', 'setDiscount')->name('seller.pos.setDiscount');
        Route::post('/setShipping', 'setShipping')->name('seller.pos.setShipping');
        Route::post('/set-shipping-address', 'set_shipping_address')->name('seller.pos.set-shipping-address');
        Route::post('/pos-order-summary', 'get_order_summary')->name('seller.pos.getOrderSummary');
        Route::post('/pos-order', 'order_store')->name('seller.pos.order_place');
        Route::get('/pos-configuration', 'configuration')->name('pos.configuration');
        Route::post('/pos-configuration/update', 'posConfigurationUpdate')->name('pos_configuration.update');
        Route::get('/pos/thermal-printer/{order_id}', 'invoice')->name('seller.invoice.thermal_printer');
    });
});
