<?php

namespace App\Http\Controllers\Api\V2\Seller;

use App\Http\Controllers\Api\V2\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\V2\Seller\AuctionProductBidCollection;
use App\Http\Resources\V2\Seller\AuctionProductCollection;
use App\Http\Resources\V2\Seller\AuctionProductDetailsResource;
use App\Http\Resources\V2\Seller\OrderCollection;
use App\Models\AuctionProductBid;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\AuctionService;
use Auth;
use DB;

class SellerAuctionProductController extends Controller
{
    public function index()
    {
        $products = [];
        if (get_setting('seller_auction_product') == 0) {
            $products =    [];
        } else {

            $products = Product::where('auction_product', 1)->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc');
        }
        return new AuctionProductCollection($products->paginate(10));
    }

    public function store(ProductRequest $request)
    {
        if (addon_is_activated('seller_subscription')) {
            if (!seller_package_validity_check(auth()->user()->id)) {
                return $this->failed(translate('Please upgrade your package.'));
            }
        }

        (new AuctionService)->store($request);
        return $this->success(translate('Auction Product has been inserted successfully'));
    }

    public function edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->lang =  $request->lang == null ? env("DEFAULT_LANGUAGE") : $request->lang;

        return new AuctionProductDetailsResource($product);
    }

    public function update(ProductRequest $request, $id)
    {
        (new AuctionService)->update($request, $id);
        return $this->success(translate('Auction Product has been updated successfully'));
    }

    public function destroy($id)
    {
        (new AuctionService)->destroy($id);
        return $this->success(translate('Auction Product has been deleted successfully'));
    }

    public function productBids($id)
    {
        return new AuctionProductBidCollection(AuctionProductBid::latest()->where('product_id', $id)->paginate(15));
    }

    public function bidDestroy($id)
    {

        AuctionProductBid::destroy($id);
        return $this->success(translate('Bid deleted successfully'));
    }

    public function getAuctionOrderList(Request $request)
    {


        $orders = Order::leftJoin('order_details', 'orders.id', '=', 'order_details.order_id')
            ->leftJoin('products', 'order_details.product_id', '=', 'products.id')
            ->where('orders.seller_id', auth()->user()->id)
            ->where('products.auction_product', '1')
            ->select("orders.*")
            ->orderBy('code', 'desc');


        if ($request->payment_status != null) {
            $orders = $orders->where('orders.payment_status', $request->payment_status);
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('orders.delivery_status', $request->delivery_status);
        }

        if ($request->has('search')) {
            $orders = $orders->where('code', 'like', '%' . $request->search . '%');
        }
        return new OrderCollection($orders->paginate(15));
    }
}
