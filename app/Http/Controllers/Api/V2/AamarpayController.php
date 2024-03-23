<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\CombinedOrder;
use App\Models\User;
use Illuminate\Http\Request;

class AamarpayController extends Controller
{
    public function pay(Request $request)
    {
        $payment_type = $request->payment_type;
        $combined_order_id = $request->combined_order_id;
        $amount = round($request->amount);
        $user_id = $request->user_id;
        $package_id = 0;

        if (isset($request->package_id)) {
            $package_id = $request->package_id;
        }
        $user = User::find($user_id);
        if ($user->phone == null) {
            return response()->json(['result' => false, 'message' => translate("Please add phone number to your profile")]);
        }
        if ($user->email == null) {
            $email = 'customer@exmaple.com';
        } else {
            $email = $user->email;
        }

        if (get_setting('aamarpay_sandbox') == 1) {
            $url = 'https://sandbox.aamarpay.com/request.php'; // live url https://secure.aamarpay.com/request.php
        } else {
            $url = 'https://secure.aamarpay.com/request.php';
        }

        if ($payment_type) {
            if ($payment_type == 'cart_payment') {
                $combined_order = CombinedOrder::find($combined_order_id);
                $amount = round($combined_order->grand_total);
            }
        }

        $fields = array(
            'store_id' => env('AAMARPAY_STORE_ID'), //store id will be aamarpay,  contact integration@aamarpay.com for test/live id
            'amount' => $amount, //transaction amount
            'payment_type' => 'VISA', //no need to change
            'currency' => 'BDT',  //currenct will be USD/BDT
            'tran_id' => rand(1111111, 9999999), //transaction id must be unique from your end
            'cus_name' => $user->name,  //customer name
            'cus_email' => $email, //customer email address
            'cus_add1' => '',  //customer address
            'cus_add2' => '', //customer address
            'cus_city' => '',  //customer city
            'cus_state' => '',  //state
            'cus_postcode' => '', //postcode or zipcode
            'cus_country' => 'Bangladesh',  //country
            'cus_phone' => $user->phone, //customer phone number
            'cus_fax' => 'Not¬Applicable',  //fax
            'ship_name' => '', //ship name
            'ship_add1' => '',  //ship address
            'ship_add2' => '',
            'ship_city' => '',
            'ship_state' => '',
            'ship_postcode' => '',
            'ship_country' => 'Bangladesh',
            'desc' => env('APP_NAME') . ' payment',
            'success_url' => route('api.amarpay.success'), //your success route
            'fail_url' => route('api.amarpay.cancel'), //your fail route
            'cancel_url' => route('cart'), //your cancel url
            'opt_a' => $payment_type,  //optional paramter
            'opt_b' => $combined_order_id,
            'opt_c' => $package_id,
            'opt_d' => $user_id,
            'signature_key' => env('AAMARPAY_SIGNATURE_KEY') //signature key will provided aamarpay, contact integration@aamarpay.com for test/live signature key
        );

        $fields_string = http_build_query($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $url_forward = str_replace('"', '', stripslashes(curl_exec($ch)));
        curl_close($ch);

        $this->redirect_to_merchant($url_forward);
    }


    function redirect_to_merchant($url)
    {
        if (get_setting('aamarpay_sandbox') == 1) {
            $base_url = 'https://sandbox.aamarpay.com/';
        } else {
            $base_url = 'https://secure.aamarpay.com/';
        }

?>
        <html xmlns="http://www.w3.org/1999/xhtml">

        <head>
            <script type="text/javascript">
                function closethisasap() {
                    document.forms["redirectpost"].submit();
                }
            </script>
        </head>

        <body onLoad="closethisasap();">

            <form name="redirectpost" method="post" action="<?php echo $base_url . $url; ?>"></form>

        </body>

        </html>
<?php
        exit;
    }

    public function success(Request $request)
    {
        $payment_type = $request->opt_a;

        if ($payment_type == 'cart_payment') {
            checkout_done($request->opt_b, json_encode($request->all()));
        }
        if ($payment_type == 'wallet_payment') {
            wallet_payment_done($request->opt_d, $request->amount, 'AmarPay', json_encode($request->all()));
        }
        if ($payment_type == 'customer_package_payment') {
            customer_purchase_payment_done($request->opt_d, $request->package_id);
        }
        if ($payment_type == 'seller_package_payment') {
            seller_purchase_payment_done($request->opt_d, $request->opt_c, $request->amount, 'AmarPay', json_encode($request->all()));
        }
        return response()->json(['result' => true, 'message' => translate("Payment is successful")]);
    }

    public function fail(Request $request)
    {
        return response()->json(['result' => false, 'message' => translate("Payment is failed")]);
    }
}
