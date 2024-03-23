<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Api\V2\Seller\SellerPackageController as SellerSellerPackageController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CombinedOrder;
use App\Models\BusinessSetting;
use App\Models\CustomerPackage;
use App\Models\SellerPackage;
use App\Http\Controllers\CustomerPackageController;
use App\Http\Controllers\SellerPackageController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\CheckoutController;


class InstamojoController extends Controller
{
    public function pay(Request $request)
    {
// dd(auth()->user()->phone);
        if (BusinessSetting::where('type', 'instamojo_sandbox')->first()->value == 1) {
            // testing_url
            $endPoint = 'https://test.instamojo.com/api/1.1/';
        } else {
            // live_url
            $endPoint = 'https://www.instamojo.com/api/1.1/';
        }

        $api = new \Instamojo\Instamojo(
            env('IM_API_KEY'),
            env('IM_AUTH_TOKEN'),
            $endPoint
        );


        if (preg_match_all('/^(?:(?:\+|0{0,2})91(\s*[\ -]\s*)?|[0]?)?[789]\d{9}|(\d[ -]?){10}\d$/im', auth()->user()->phone)) {

            $amount = 0;

            if ($request->payment_type == 'cart_payment') {
                $combined_order = CombinedOrder::findOrFail($request->combined_order_id);
                $amount =  round($combined_order->grand_total);
            } elseif ($request->payment_type == 'wallet_payment') {
                $amount = round($request->wallet_amount);
            } elseif ($request->payment_type == 'customer_package_payment') {
                $customer_package = CustomerPackage::findOrFail($request->customer_package_id);
                $amount = round($customer_package->amount);
            }
            try {
                $response = $api->paymentRequestCreate(array(
                    "purpose" => ucfirst(str_replace('_', ' ', $request->payment_type)),
                    "amount" => $amount,
                    "send_email" => false,
                    "email" => auth()->user()->email,
                    "phone" => auth()->user()->phone,
                    "redirect_url" => url("api/v2/instamojo/success?payment_option=$request->payment_option&payment_type=$request->payment_type&combined_order_id=$request->combined_order_id&wallet_amount=$request->wallet_amount&customer_package_id=$request->customer_package_id")
                ));
                return redirect($response['longurl']);
            } catch (\Exception $e) {
            }
        }
        return redirect(url("api/v2/online-pay/failed"))->with("errors",'Please add phone number to your profile');
    }
    // success response method.
    public function success(Request $request)
    {
        try {
            if (BusinessSetting::where('type', 'instamojo_sandbox')->first()->value == 1) {
                $endPoint = 'https://test.instamojo.com/api/1.1/';
            } else {
                $endPoint = 'https://www.instamojo.com/api/1.1/';
            }

            $api = new \Instamojo\Instamojo(
                env('IM_API_KEY'),
                env('IM_AUTH_TOKEN'),
                $endPoint
            );

            $response = $api->paymentRequestStatus(request('payment_request_id'));

            if (!isset($response['payments'][0]['status']) || $response['payments'][0]['status'] != 'Credit') {
                return redirect(url("api/v2/online-pay/failed"))->with("errors",translate('Payment Failed'));
            }
        } catch (\Exception $e) {
            return redirect(url("api/v2/online-pay/failed"))->with('errors',translate('Payment Failed'));
        }

        $payment = json_encode($response);
        return redirect( url("api/v2/online-pay/success?payment_type=$request->payment_type&combined_order_id=$request->combined_order_id&wallet_amount=$request->wallet_amount&customer_package_id=$request->customer_package_id&payment_details=$payment"));
        // }
    }
}
