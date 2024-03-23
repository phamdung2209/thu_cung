<?php

namespace App\Http\Controllers\Api\V2\Seller;

use App\Http\Resources\PosProductCollection;
use App\Http\Resources\V2\AddressCollection;
use App\Http\Resources\V2\Seller\CartCollection;
use App\Http\Resources\V2\Seller\CustomerCollection;
use App\Models\Address;
use App\Models\User;
use App\Utility\PosUtility;
use Illuminate\Http\Request;
use App\Models\Cart;

class PosController extends Controller
{
    public function productsList(Request $request)
    {
        $products = PosUtility::product_search($request->only('category', 'brand', 'keyword'));

        return response()->json([
            'products' => new PosProductCollection($products),
            'keyword'  => $request->keyword,
            'category' => $request->category,
            'brand'    => $request->brand
        ]);
    }

    public function getCustomers()
    {
        $customers = User::where('user_type', 'customer')->where('email_verified_at', '!=', null)->orderBy('created_at', 'desc')->get();
        return new CustomerCollection($customers);
    }

    public function updateSessionUser(Request $request)
    {
        $userID             = $request->userId;
        $sessionUserId      = $request->sessionUserId;
        $sessionTemUserId   = $request->sessionTemUserId;
        $carts = get_pos_user_cart($sessionUserId, $sessionTemUserId);

        // If user is selected but Session user is not this user
        if ($userID && $carts) {
            PosUtility::updatePosUserCartData($carts, $userID, null);
        }

        // If user is not selected, and if session has not Temp user ID
        if (!$userID) {
            if (!$sessionTemUserId) {
                $sessionTemUserId = bin2hex(random_bytes(10));
            }
            if ($carts) {
                PosUtility::updatePosUserCartData($carts, null, $sessionTemUserId);
            }
        }

        return response()->json([
            'result' => true,
            'message' => translate('Customer Updated Successfully'),
            'userID' => $userID,
            'temUserId' => $sessionTemUserId
        ]);
    }

    public function getShippingAddress($id)
    {
        $user = user::where('id', $id)->first();
        $shippingAddresses = $user->addresses;
        return new AddressCollection($shippingAddresses);
    }


    public function posConfigurationUpdate (Request $request) {
        $shop = auth()->user()->shop;
        $shop->thermal_printer_width = $request->thermal_printer_width;
        $shop->save();

        return $this->success(translate('Pos Configuration Updated Successfully'));
        
    }

    public function posConfiguration(Request $request) {
        $shop = auth()->user()->shop;
      $data=  $shop->thermal_printer_width;
        return $this->success($data);
        
    }


    public function createShippingAddress(Request $request)
    {
        $address = new Address;
        $address->user_id = $request->user_id;
        $address->address = $request->address;
        $address->country_id = $request->country_id;
        $address->state_id = $request->state_id;
        $address->city_id = $request->city_id;
        $address->postal_code = $request->postal_code;
        $address->phone = $request->phone;
        $address->save();

        return response()->json([
            'result' => true,
            'message' => translate('Shipping information has been added successfully')
        ]);
    }

    // Add product To cart
    public function addToCart(Request $request)
    {
        $stockId    = $request->stock_id;
        $userID     = $request->userID;
        $temUserId  = $request->temUserId;
        if (!$temUserId && !$userID) {
            $temUserId = bin2hex(random_bytes(10));
        }
        $response = PosUtility::addToCart($stockId, $userID, $temUserId);

        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
            'userId'  => $userID,
            'temUserId' => $temUserId
        ]);
    }

    public function getUserCartData(Request $request)
    {
        $shippingCost   = $request->shippingCost;
        $discount       = $request->discount;
        $carts          = get_pos_user_cart($request->userId, $request->tempUserId);
        $subtotal       = 0;
        $tax            = 0;

        foreach ($carts as $cartItem) {
            $product = $cartItem->product;
            $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
            $tax += cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
        }

        return response()->json([
            'result' => true,
            'data' => [
                'cart_data'     => new CartCollection($carts),
                'subtotal'      => single_price($subtotal),
                'tax'           => single_price($tax),
                'shippingCost'  => ($shippingCost),
                'shippingCost_str'  => single_price($shippingCost),
                'discount'      => single_price($discount),
                'Total'         => single_price($subtotal + $tax + $shippingCost - $discount)
            ]
        ]);
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $cart = Cart::find($request->cart_id);
        $response = PosUtility::updateCartItemQuantity($cart, $request->only(['cart_id', 'quantity']));

        return response()->json(['result' => (bool)$response['success']??true, 'message' => $response['message']]);
    }

    public function removeFromCart(Request $request)
    {
        Cart::where('id', $request->id)->delete();
        return $this->success( translate('Cart has been deleted successfully'));
    }




    //order place
    public function orderStore(Request $request)
    {
        $response = PosUtility::orderStore($request->except(['_token']));
        return $response['success'] ? $this->success($response['message']) : $this->success($response['message']);
    }

}
