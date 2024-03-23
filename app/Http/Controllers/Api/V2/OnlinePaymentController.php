<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Api\V2\Controller;
use Illuminate\Http\Request;

class OnlinePaymentController extends Controller
{
    public  function init(Request $request)
    {
        $directory = __NAMESPACE__ . '\\' . str_replace(' ', '', ucwords(str_replace('_payment', ' ', $request->payment_option))) . "Controller";
        
        return (new $directory)->pay($request);
    }
    public  function paymentSuccess(Request $request)
    {
        try {

            $payment_type = $request->payment_type;

            if ($payment_type == 'cart_payment') {
                checkout_done($request->combined_order_id, $request->payment_details);
            }

            if ($payment_type == 'wallet_payment') {
                wallet_payment_done($request->user_id, $request->amount, 'Iyzico', $request->payment_details);
            }

            if ($payment_type == 'seller_package_payment') {
                seller_purchase_payment_done($request->user_id, $request->package_id, $request->amount, 'Iyzico', $request->payment_details);
            }
            if ($payment_type == 'customer_package_payment') {
                customer_purchase_payment_done($request->user_id, $request->package_id);
            }
            return redirect(url("api/v2/online-pay/done"));
        } catch (\Exception $e) {
            return redirect(url("api/v2/online-pay/done"))->with('errors',$e->getMessage());
        }
    }

    public  function paymentFailed()
    {
        return $this->failed(session('errors'));
    }

    function paymentDone(){
        return $this->success("Payment Done");
    }
}
