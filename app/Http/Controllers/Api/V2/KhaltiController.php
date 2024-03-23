<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\CombinedOrder;
use Illuminate\Http\Request;
use Redirect;

class KhaltiController extends Controller
{
    public function pay(Request $request)
    {
        if ($request->payment_type == 'cart_payment') {
            $combined_order = CombinedOrder::find($request->combined_order_id);
            $purchase_order_id = $combined_order->id . '-' . uniqid();
            $amount = $combined_order->grand_total;
        } elseif ($request->payment_type == 'wallet_payment') {
            $amount = $request->amount;
            $purchase_order_id = $request->payment_type . '-' . $amount  . '-' . uniqid();
        } elseif ($request->payment_type == 'seller_package_payment' || $request->payment_type == 'customer_package_payment') {
            $amount = $request->amount;
            $purchase_order_id = $request->package_id . '-' . uniqid();
        }

        $return_url = route('api.khalti.success'); //must be changed
        $args = http_build_query([
            'return_url' => $return_url,
            'website_url' => route('home'),
            'amount' => $amount * 100,
            "modes" => [
                "KHALTI",
                "EBANKING",
                "MOBILE_BANKING",
                "CONNECT_IPS",
                "SCT"
            ],
            'purchase_order_id' => $purchase_order_id,
            'purchase_order_name' => $request->payment_type,
        ]);
        if (get_setting('khalti_sandbox') == 1) {
            $url = 'https://a.khalti.com/api/v2/epayment/initiate/';
        } else {
            $url = 'https://khalti.com/api/v2/epayment/initiate/';
        }
        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = ['Authorization: Key ' . env('KHALTI_SECRET_KEY')];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Response
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        // return response()->json([
        //     "result" => true,
        //     "url" => $response['payment_url']
        // ]);
        return Redirect::to($response['payment_url']);
    }

    public function paymentDone(Request $request)
    {
        $args = http_build_query([
            'pidx' => $request->pidx,
        ]);
        if (get_setting('khalti_sandbox') == 1) {
            $url = 'https://a.khalti.com/api/v2/epayment/lookup/';
        } else {
            $url = 'https://khalti.com/api/v2/epayment/lookup/';
        }

        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = ['Authorization: Key ' . env('KHALTI_SECRET_KEY')];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Response
        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        if ($response->status == 'Completed') {

            if ($request->payment_type == 'cart_payment') {

                checkout_done($request->combined_order_id, json_encode($response));
            }

            if ($request->payment_type == 'wallet_payment') {

                wallet_payment_done($request->user_id, $request->amount, 'khalti', json_encode($response));
            }

            if ($request->payment_type == 'seller_package_payment') {
                seller_purchase_payment_done($request->user_id, $request->package_id, $request->amount, 'khalti', json_encode($response));
            }

            if ($request->payment_type == 'customer_package_payment') {
                customer_purchase_payment_done($request->user_id, $request->package_id);
            }

            return response()->json(['result' => true, 'message' => translate("Payment is successful")]);
        } else {
            return response()->json(['result' => false, 'message' => translate("Payment is failed")]);
        }
    }
}
