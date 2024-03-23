<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\PurchasedResource;
use App\Http\Resources\V2\PurchaseHistoryMiniCollection;
use App\Http\Resources\V2\PurchaseHistoryCollection;
use App\Http\Resources\V2\PurchaseHistoryItemsCollection;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use App\Utility\CartUtility;
use Illuminate\Support\Facades\DB;

class PurchaseHistoryController extends Controller
{
    public function index(Request $request)
    {
        $order_query = Order::query();
        if ($request->payment_status != "" || $request->payment_status != null) {
            $order_query->where('payment_status', $request->payment_status);
        }
        if ($request->delivery_status != "" || $request->delivery_status != null) {
            $delivery_status = $request->delivery_status;
            $order_query->whereIn("id", function ($query) use ($delivery_status) {
                $query->select('order_id')
                    ->from('order_details')
                    ->where('delivery_status', $delivery_status);
            });
        }
        return new PurchaseHistoryMiniCollection($order_query->where('user_id', auth()->user()->id)->latest()->paginate(5));
    }

    public function details($id)
    {
        $order_detail = Order::where('id', $id)->where('user_id', auth()->user()->id)->get();
        // $order_query = auth()->user()->orders->where('id', $id);

        // return new PurchaseHistoryCollection($order_query->get());
        return new PurchaseHistoryCollection($order_detail);
    }

    public function items($id)
    {
        $order_id = Order::select('id')->where('id', $id)->where('user_id', auth()->user()->id)->first();
        $order_query = OrderDetail::where('order_id', $order_id->id);
        return new PurchaseHistoryItemsCollection($order_query->get());
    }

    public function digital_purchased_list()
    {
        $order_detail_products = Product::query()
            ->where('digital', 1)
            ->whereHas('orderDetails', function ($query) {
                $query->whereHas('order', function ($q) {
                    $q->where('payment_status', 'paid');
                    $q->where('user_id', auth()->id());
                });
            })->paginate(15);
        // $order_detail_products = OrderDetail::whereHas('order', function ($q) {
        //     $q->where('payment_status', 'paid');
        //     $q->where('user_id', auth()->id());
        // })->with(['product' => function ($query) {
        //     $query->where('digital', 1);
        // }])
        //     ->paginate(1);

        //   $products = Product::with(['orderDetails', 'orderDetails.order' => function($q) {
        //          $q->where('payment_status', 'paid');
        //          $q->where('user_id', auth()->id());
        //     }])
        //     ->where('digital', 1)
        //     ->paginate(15);  

        // dd($order_detail_products);

        return PurchasedResource::collection($order_detail_products);
    }

    public function re_order($id)
    {
        $user_id = auth()->user()->id;
        $success_msgs = [];
        $failed_msgs = [];

        $carts = Cart::where('user_id', auth()->user()->id)->get();
        $check_auction_in_cart = CartUtility::check_auction_in_cart($carts);
        if ($check_auction_in_cart) {
            array_push($failed_msgs, translate('Remove auction product from cart to add products.'));
            return response()->json([
                'success_msgs' => $success_msgs,
                'failed_msgs' => $failed_msgs
            ]);
        }

        $order = Order::findOrFail($id);

        $data['user_id'] = $user_id;
        foreach ($order->orderDetails as $key => $orderDetail) {
            $product = $orderDetail->product;

            if (
                !$product || $product->published == 0 ||
                $product->approved == 0 || ($product->wholesale_product && !addon_is_activated("wholesale"))
            ) {
                array_push($failed_msgs, translate('An item from this order is not available now.'));
                continue;
            }

            if ($product->auction_product == 1) {
                array_push($failed_msgs, translate('You can not re order an auction product.'));
                break;
            }



            // If product min qty is greater then the ordered qty, then update the order qty 
            $order_qty = $orderDetail->quantity;
            if ($product->digital == 0 && $order_qty < $product->min_qty) {
                $order_qty = $product->min_qty;
            }

            $cart = Cart::firstOrNew([
                'variation' => $orderDetail->variation,
                'user_id' => $user_id,
                'product_id' => $product->id
            ]);

            $product_stock = $product->stocks->where('variant', $orderDetail->variation)->first();
            if ($product_stock) {
                $quantity = 1;

                if ($product->digital != 1) {
                    $quantity = $product_stock->qty;
                    if ($quantity > 0) {
                        if ($cart->exists) {
                            $order_qty = $cart->quantity + $order_qty;
                        }
                        //If order qty is greater then the product stock, set order qty = current product stock qty
                        $quantity = ($quantity >= $order_qty) ? $order_qty : $quantity;
                    } else {
                        array_push($failed_msgs, $product->getTranslation('name') . ' ' . translate('is stock out.'));
                        continue;
                    }
                }

                $price = CartUtility::get_price($product, $product_stock, $quantity);
                $tax = CartUtility::tax_calculation($product, $price);

                CartUtility::save_cart_data($cart, $product, $price, $tax, $quantity);
                array_push($success_msgs, $product->getTranslation('name') . ' ' . translate('added to cart.'));
            } else {
                array_push($failed_msgs, $product->getTranslation('name') . ' ' . translate(' is stock out.'));
            }
        }

        return response()->json([
            'success_msgs' => $success_msgs,
            'failed_msgs' => $failed_msgs
        ]);
    }
}
