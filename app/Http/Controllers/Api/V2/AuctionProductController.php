<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\Auction\AuctionBidProducts;
use App\Http\Resources\V2\Auction\AuctionPurchaseHistory;
use App\Http\Resources\V2\AuctionMiniCollection;
use App\Http\Resources\V2\AuctionProductDetailCollection;
use App\Models\AuctionProductBid;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AuctionProductController extends Controller
{

    public function index()
    {
        $products = Product::latest()->where('published', 1)->where('auction_product', 1);
        if (get_setting('seller_auction_product') == 0) {
            $products = $products->where('added_by', 'admin');
        }
        $products = $products->where('auction_start_date', '<=', strtotime("now"))->where('auction_end_date', '>=', strtotime("now"));


        return new AuctionMiniCollection($products->paginate(10));
    }


    public function details_auction_product(Request $request, $id)
    {
        $detailedProduct  = Product::where('id', $id)->get();
        return new AuctionProductDetailCollection($detailedProduct);
    }

    public function bided_products_list()
    {
        $own_bids = AuctionProductBid::where('user_id', auth()->id())->orderBy('id', 'desc')->pluck('product_id');
        $bided_products = Product::whereIn('id', $own_bids)->paginate(10);
        return  AuctionBidProducts::collection($bided_products);
    }

    public function user_purchase_history(Request $request)
    {

        $orders = DB::table('orders')
            ->orderBy('code', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('orders.user_id', auth()->user()->id)
            ->where('products.auction_product', '1');
        if ($request->payment_status != "" || $request->payment_status != null) {
            $orders =   $orders->where('orders.payment_status', $request->payment_status);
        }
        if ($request->delivery_status != "" || $request->delivery_status != null) {
            $orders =   $orders->where('orders.delivery_status', $request->delivery_status);
        }

        $orders = $orders->select('order_details.order_id as id')->paginate(15);

        return AuctionPurchaseHistory::collection($orders);
    }
}
