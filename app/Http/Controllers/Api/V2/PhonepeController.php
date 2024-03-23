<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\CombinedOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Redirect;

class PhonepeController extends Controller
{
    public function pay(Request $request)
    {
        if ($request->payment_type == 'cart_payment') {
            $combined_order = CombinedOrder::find($request->combined_order_id);
            $amount = $combined_order->grand_total;
            $merchantTransactionId = $request->payment_type . '-' . $combined_order->id . '-' . $request->user_id . '-' . rand(0, 100000);
            $merchantUserId = $request->user_id;
        } elseif ($request->payment_type == 'wallet_payment') {
            $amount = $request->amount;
            $merchantTransactionId = $request->payment_type . '-' . $request->user_id . '-' . $request->user_id . '-' . rand(0, 100000);
            $merchantUserId = $request->user_id;
        } elseif ($request->payment_type == 'seller_package_payment' || $request->payment_type == 'customer_package_payment') {
            $amount = $request->amount;
            $merchantTransactionId = $request->payment_type . '-' . $request->package_id . '-' . $request->user_id . '-' . rand(0, 100000);
            $merchantUserId = $request->user_id;
        }
        // $merchantTransactionId = "MT7850590068188104";
        $merchantId = env('PHONEPE_MERCHANT_ID');
        $salt_key = env('PHONEPE_SALT_KEY');
        $salt_index = env('PHONEPE_SALT_INDEX');


        $base_url = (get_setting('phonepe_sandbox') == 1) ? "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay" : "https://api.phonepe.com/apis/hermes/pg/v1/pay";

        $post_field = [
            'merchantId' => $merchantId,
            'merchantTransactionId' => $merchantTransactionId,
            'merchantUserId' => $merchantUserId,
            'amount' => $amount * 100,
            'redirectUrl' => route('api.phonepe.redirecturl'),
            'redirectMode' => 'POST',
            'callbackUrl' =>  route('api.phonepe.callbackUrl'),
            'mobileNumber' =>  "9999999999",
            "paymentInstrument" => [
                "type" => "PAY_PAGE"
            ],
        ];
        $payload = base64_encode(json_encode($post_field));

        $hashedkey =  hash('sha256', $payload . "/pg/v1/pay" . $salt_key) . '###' . $salt_index;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $base_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-VERIFY: ' . $hashedkey . '',
            'accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "\n{\n  \"request\": \"$payload\"\n}\n");

        $response = curl_exec($ch);
        $res = (json_decode($response));
        // dd($res);
        return Redirect::to($res->data->instrumentResponse->redirectInfo->url);
    }

    public function phonepe_redirecturl(Request $request)
    {
        $payment_type = explode("-", $request['transactionId']);
        // auth()->login(User::findOrFail($payment_type[2]));
        // dd($payment_type[0], $payment_type[1], $request['merchantId'], $request['transactionId'], $request->all());

        if ($request['code'] == 'PAYMENT_SUCCESS') {
            return response()->json(['result' => true, 'message' => translate("Payment is successful")]);
        }
        return response()->json(['result' => false, 'message' => translate("Payment is failed")]);
    }

    public function phonepe_callbackUrl(Request $request)
    {
        $res = $request->all();
        $response = $res['response'];
        $decodded_response = json_decode(base64_decode($response));

        $payment_type = explode("-", $decodded_response->data->merchantTransactionId);
        // auth()->login(User::findOrFail($payment_type[2]));
        // dd($payment_type[0], $payment_type[1], $request['merchantId'], $request['transactionId'], $request->all());
        $amount = $decodded_response->data->amount / 100;
        if ($decodded_response->code  == 'PAYMENT_SUCCESS') {
            if ($payment_type[0] == 'cart_payment') {

                checkout_done($payment_type[1], json_encode($decodded_response->data));
            }

            if ($payment_type[0] == 'wallet_payment') {

                wallet_payment_done($payment_type[2], $amount, 'phonepe', json_encode($decodded_response->data));
            }

            if ($payment_type[0] == 'seller_package_payment') {
                seller_purchase_payment_done($payment_type[2], $payment_type[1], $amount, 'phonepe', json_encode($decodded_response->data));
            }

            if ($payment_type[0] == 'customer_package_payment') {
                customer_purchase_payment_done($payment_type[2], $payment_type[1]);
            }
        }
    }
}
