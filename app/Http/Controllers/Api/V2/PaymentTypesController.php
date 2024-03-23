<?php


namespace App\Http\Controllers\Api\V2;

use App\Models\ManualPaymentMethod;
use Illuminate\Http\Request;

class PaymentTypesController
{

    public function getList(Request $request)
    {
        $mode = "order";

        if ($request->has('mode')) {
            $mode = $request->mode; // wallet or other things , comes from query param ?mode=wallet
        }

        $list = "both";
        if ($request->has('list')) {
            $list = $request->list; // ?list=offline
        }

        $payment_types = array();

        if ($list == "online" || $list == "both") {
            if (get_setting('paypal_payment') == 1) {
                $payment_type = array();
                $payment_type['payment_type'] = 'paypal_payment';
                $payment_type['payment_type_key'] = 'paypal';
                $payment_type['image'] = static_asset('assets/img/cards/paypal.png');
                $payment_type['name'] = "Paypal";
                $payment_type['title'] = translate("Checkout with Paypal");
                $payment_type['offline_payment_id'] = 0;
                $payment_type['details'] = "";
                if ($mode == 'wallet') {
                    $payment_type['title'] = translate("Recharge with Paypal");
                }

                $payment_types[] = $payment_type;
            }

            if (get_setting('stripe_payment') == 1) {
                $payment_type = array();
                $payment_type['payment_type'] = 'stripe_payment';
                $payment_type['payment_type_key'] = 'stripe';
                $payment_type['image'] = static_asset('assets/img/cards/stripe.png');
                $payment_type['name'] = "Stripe";
                $payment_type['title'] = translate("Checkout with Stripe");
                $payment_type['offline_payment_id'] = 0;
                $payment_type['details'] = "";
                if ($mode == 'wallet') {
                    $payment_type['title'] = translate("Recharge with Stripe");
                }

                $payment_types[] = $payment_type;
            }
            if (get_setting('instamojo_payment') == 1) {
                $payment_type = array();
                $payment_type['payment_type'] = 'instamojo_payment';
                $payment_type['payment_type_key'] = 'instamojo_payment';
                $payment_type['image'] = static_asset('assets/img/cards/instamojo.png');
                $payment_type['name'] = "Instamojo";
                $payment_type['title'] = translate("Checkout with Instamojo");
                $payment_type['offline_payment_id'] = 0;
                $payment_type['details'] = "";
                if ($mode == 'wallet') {
                    $payment_type['title'] = translate("Recharge with Instamojo");
                }

                $payment_types[] = $payment_type;
            }

            if (get_setting('razorpay') == 1) {
                $payment_type = array();
                $payment_type['payment_type'] = 'razorpay';
                $payment_type['payment_type_key'] = 'razorpay';
                $payment_type['image'] = static_asset('assets/img/cards/rozarpay.png');
                $payment_type['name'] = "Razorpay";
                $payment_type['title'] = translate("Checkout with Razorpay");
                $payment_type['offline_payment_id'] = 0;
                $payment_type['details'] = "";
                if ($mode == 'wallet') {
                    $payment_type['title'] = translate("Recharge with Razorpay");
                }

                $payment_types[] = $payment_type;
            }

            if (get_setting('paystack') == 1) {
                $payment_type = array();
                $payment_type['payment_type'] = 'paystack';
                $payment_type['payment_type_key'] = 'paystack';
                $payment_type['image'] = static_asset('assets/img/cards/paystack.png');
                $payment_type['name'] = "Paystack";
                $payment_type['title'] = translate("Checkout with Paystack");
                $payment_type['offline_payment_id'] = 0;
                $payment_type['details'] = "";
                if ($mode == 'wallet') {
                    $payment_type['title'] = translate("Recharge with Paystack");
                }

                $payment_types[] = $payment_type;
            }

            if (get_setting('iyzico') == 1) {
                $payment_type = array();
                $payment_type['payment_type'] = 'iyzico';
                $payment_type['payment_type_key'] = 'iyzico';
                $payment_type['image'] = static_asset('assets/img/cards/iyzico.png');
                $payment_type['name'] = "Iyzico";
                $payment_type['title'] = translate("Checkout with Iyzico");
                $payment_type['offline_payment_id'] = 0;
                $payment_type['details'] = "";
                if ($mode == 'wallet') {
                    $payment_type['title'] = translate("Recharge with Iyzico");
                }

                $payment_types[] = $payment_type;
            }

            if (get_setting('bkash') == 1) {
                $payment_type = array();
                $payment_type['payment_type'] = 'bkash';
                $payment_type['payment_type_key'] = 'bkash';
                $payment_type['image'] = static_asset('assets/img/cards/bkash.png');
                $payment_type['name'] = "Bkash";
                $payment_type['title'] = translate("Checkout with Bkash");
                $payment_type['offline_payment_id'] = 0;
                $payment_type['details'] = "";
                if ($mode == 'wallet') {
                    $payment_type['title'] = translate("Recharge with Bkash");
                }

                $payment_types[] = $payment_type;
            }

            if (get_setting('nagad') == 1) {
                $payment_type = array();
                $payment_type['payment_type'] = 'nagad';
                $payment_type['payment_type_key'] = 'nagad';
                $payment_type['image'] = static_asset('assets/img/cards/nagad.png');
                $payment_type['name'] = "Nagad";
                $payment_type['title'] = translate("Checkout with Nagad");
                $payment_type['offline_payment_id'] = 0;
                $payment_type['details'] = "";
                if ($mode == 'wallet') {
                    $payment_type['title'] = translate("Recharge with Nagad");
                }

                $payment_types[] = $payment_type;
            }

            if (get_setting('sslcommerz_payment') == 1) {
                $payment_type = array();
                $payment_type['payment_type'] = 'sslcommerz_payment';
                $payment_type['payment_type_key'] = 'sslcommerz';
                $payment_type['image'] = static_asset('assets/img/cards/sslcommerz.png');
                $payment_type['name'] = "Sslcommerz";
                $payment_type['title'] = translate("Checkout with Sslcommerz");
                $payment_type['offline_payment_id'] = 0;
                $payment_type['details'] = "";
                if ($mode == 'wallet') {
                    $payment_type['title'] = translate("Recharge with Sslcommerz");
                }

                $payment_types[] = $payment_type;
            }

            if (get_setting('aamarpay') == 1) {
                $payment_type = array();
                $payment_type['payment_type'] = 'aamarpay';
                $payment_type['payment_type_key'] = 'aamarpay';
                $payment_type['image'] = static_asset('assets/img/cards/aamarpay.png');
                $payment_type['name'] = "aamarpay";
                $payment_type['title'] = translate("Checkout with aamarpay");
                $payment_type['offline_payment_id'] = 0;
                $payment_type['details'] = "";
                if ($mode == 'wallet') {
                    $payment_type['title'] = translate("Recharge with aamarpay");
                }
                $payment_types[] = $payment_type;
            }

            //African Payment Gateways
            if (addon_is_activated('african_pg')) {
                if (get_setting('flutterwave') == 1) {
                    $payment_type = array();
                    $payment_type['payment_type'] = 'flutterwave';
                    $payment_type['payment_type_key'] = 'flutterwave';
                    $payment_type['image'] = static_asset('assets/img/cards/flutterwave.png');
                    $payment_type['name'] = "Flutterwave";
                    $payment_type['title'] = translate("Checkout with Flutterwave");
                    $payment_type['offline_payment_id'] = 0;
                    $payment_type['details'] = "";
                    if ($mode == 'wallet') {
                        $payment_type['title'] = translate("Recharge with Flutterwave");
                    }
                    $payment_types[] = $payment_type;
                }
                if (get_setting('payfast') == 1) {
                    $payment_type = array();
                    $payment_type['payment_type'] = 'payfast';
                    $payment_type['payment_type_key'] = 'payfast';
                    $payment_type['image'] = static_asset('assets/img/cards/payfast.png');
                    $payment_type['name'] = "Payfast";
                    $payment_type['title'] = translate("Checkout with Payfast");
                    $payment_type['offline_payment_id'] = 0;
                    $payment_type['details'] = "";
                    if ($mode == 'wallet') {
                        $payment_type['title'] = translate("Recharge with Payfast");
                    }
                    $payment_types[] = $payment_type;
                }
            }

            if (addon_is_activated('paytm')) {

                if (get_setting('paytm_payment') == 1) {
                    $payment_type = array();
                    $payment_type['payment_type'] = 'paytm';
                    $payment_type['payment_type_key'] = 'paytm';
                    $payment_type['image'] = static_asset('assets/img/cards/paytm.jpg');
                    $payment_type['name'] = "Paytm";
                    $payment_type['title'] = translate("Checkout with Paytm");
                    $payment_type['offline_payment_id'] = 0;
                    $payment_type['details'] = "";
                    if ($mode == 'wallet') {
                        $payment_type['title'] = translate("Recharge with Paytm");
                    }

                    $payment_types[] = $payment_type;
                }
                if (get_setting('khalti_payment') == 1) {
                    $payment_type = array();
                    $payment_type['payment_type'] = 'khalti';
                    $payment_type['payment_type_key'] = 'khalti';
                    $payment_type['image'] = static_asset('assets/img/cards/khalti.png');
                    $payment_type['name'] = "Khalti";
                    $payment_type['title'] = translate("Checkout with Khalti");
                    $payment_type['offline_payment_id'] = 0;
                    $payment_type['details'] = "";
                    if ($mode == 'wallet') {
                        $payment_type['title'] = translate("Recharge with Khalti");
                    }

                    $payment_types[] = $payment_type;
                }
                if (get_setting('myfatoorah') == 1) {
                    $payment_type = array();
                    $payment_type['payment_type'] = 'myfatoorah';
                    $payment_type['payment_type_key'] = 'myfatoorah';
                    $payment_type['image'] = static_asset('assets/img/cards/myfatoorah.png');
                    $payment_type['name'] = "myfatoorah";
                    $payment_type['title'] = translate("Checkout with myfatoorah");
                    $payment_type['offline_payment_id'] = 0;
                    $payment_type['details'] = "";
                    if ($mode == 'wallet') {
                        $payment_type['title'] = translate("Recharge with myfatoorah");
                    }

                    $payment_types[] = $payment_type;
                }
                if (get_setting('phonepe_payment') == 1) {
                    $payment_type = array();
                    $payment_type['payment_type'] = 'phonepe';
                    $payment_type['payment_type_key'] = 'phonepe';
                    $payment_type['image'] = static_asset('assets/img/cards/phonepe.png');
                    $payment_type['name'] = "phonepe";
                    $payment_type['title'] = translate("Checkout with Phonepe");
                    $payment_type['offline_payment_id'] = 0;
                    $payment_type['details'] = "";
                    if ($mode == 'wallet') {
                        $payment_type['title'] = translate("Recharge with Phonepe");
                    }

                    $payment_types[] = $payment_type;
                }
            }
        }

        // you cannot recharge wallet by wallet or cash payment
        if ($mode != 'wallet' && $mode != 'seller_package' && $list != "offline") {
            if (get_setting('wallet_system') == 1) {
                $payment_type = array();
                $payment_type['payment_type'] = 'wallet_system';
                $payment_type['payment_type_key'] = 'wallet';
                $payment_type['image'] = static_asset('assets/img/cards/wallet.png');
                $payment_type['name'] = "Wallet";
                $payment_type['title'] = translate("Wallet Payment");
                $payment_type['offline_payment_id'] = 0;
                $payment_type['details'] = "";

                $payment_types[] = $payment_type;
            }

            $haveDigitalProduct = false;
            $cash_on_delivery = false;

            if ($mode == "order") {
                $carts = auth()->user()->carts;

                foreach ($carts as $key => $cart) {
                    $haveDigitalProduct =  $cart->product->digital == 1;
                    $cash_on_delivery =  $cart->product->cash_on_delivery == 0;
                    if ($haveDigitalProduct || $cash_on_delivery) {
                        break;
                    }
                }
            }

            if (get_setting('cash_payment') == 1  && !$haveDigitalProduct && !$cash_on_delivery) {
                $payment_type = array();
                $payment_type['payment_type'] = 'cash_payment';
                $payment_type['payment_type_key'] = 'cash_on_delivery';
                $payment_type['image'] = static_asset('assets/img/cards/cod.png');
                $payment_type['name'] = "Cash Payment";
                $payment_type['title'] = translate("Cash on delivery");
                $payment_type['offline_payment_id'] = 0;
                $payment_type['details'] = "";

                $payment_types[] = $payment_type;
            }
        }

        if (($list == 'offline' || $list == "both")  && addon_is_activated('offline_payment')) {
            foreach (ManualPaymentMethod::all() as $method) {

                $bank_list = "";
                $bank_list_item = "";

                if ($method->bank_info != null) {
                    foreach (json_decode($method->bank_info) as $key => $info) {
                        $bank_list_item .= "<li>" . 'Bank Name' . " -  {$info->bank_name} ," .  'Account Name' . "  -  $info->account_name , " . 'Account Number' . " - {$info->account_number} , " . 'Routing Number' . " - {$info->routing_number}</li>";
                    }
                    $bank_list = "<ul> $bank_list_item <ul>";
                }

                $payment_type = array();
                $payment_type['payment_type'] = 'manual_payment';
                $payment_type['payment_type_key'] = 'manual_payment_' . $method->id;
                $payment_type['image'] = uploaded_asset($method->photo);
                $payment_type['name'] = $method->heading;
                $payment_type['title'] = $method->heading;
                $payment_type['offline_payment_id'] = $method->id;
                $payment_type['details'] = "<div> {$method->description} $bank_list  </div>";

                $payment_types[] = $payment_type;
            }
        }

        return response()->json($payment_types);
    }
}
