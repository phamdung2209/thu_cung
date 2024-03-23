<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuctionProductBid;
use App\Models\Product;
use Auth;
use Mail;
use DB;
use App\Mail\AuctionBidMailManager;


class AuctionProductBidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bids = DB::table('auction_product_bids')
            ->orderBy('id', 'desc')
            ->join('products', 'auction_product_bids.product_id', '=', 'products.id')
            ->where('auction_product_bids.user_id', Auth::user()->id)
            ->select('auction_product_bids.id')
            ->distinct()
            ->paginate(10);
        return view('auction.frontend.my_bidded_products', compact('bids'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bid = AuctionProductBid::where('product_id', $request->product_id)->where('user_id', Auth::user()->id)->first();
        if ($bid == null) {
            $bid =  new AuctionProductBid;
            $bid->user_id = Auth::user()->id;
        }
        $bid->product_id = $request->product_id;
        $bid->amount = $request->amount;
        if ($bid->save()) {
            $secound_max_bid = AuctionProductBid::where('product_id', $request->product_id)->orderBy('amount','desc')->skip(1)->first();
            if($secound_max_bid != null){
                if($secound_max_bid->user->email != null){
                    $product = Product::where('id',$request->product_id)->first();
                    $array['view'] = 'emails.auction_bid';
                    $array['subject'] = translate('Auction Bid');
                    $array['from'] = env('MAIL_FROM_ADDRESS');
                    $array['content'] = 'Hi! A new user bidded more then you for the product, '.$product->name.'. '.'Highest bid amount: '.$bid->amount;
                    $array['link'] = route('auction-product', $product->slug);
                    try {
                        Mail::to($secound_max_bid->user->email)->queue(new AuctionBidMailManager($array));
                    } catch (\Exception $e) {
                        //dd($e->getMessage());
                    }
                }
            }

            flash(translate('Bid Placed Successfully'))->success();
        } else {
            flash(translate('Something went wrong!'))->error();
        }
        return back();
    }

   
    public function product_bids_admin($id)
    {
        $product = Product::where('id', $id)->first();
        $bids = AuctionProductBid::latest()->where('product_id', $id)->paginate(15);
        return view('auction.auction_products.bids', compact('bids', 'product'));
    }

    public function product_bids_seller($id)
    {
        $product = Product::where('id', $id)->first();
        $bids = AuctionProductBid::latest()->where('product_id', $id)->paginate(15);
        return view('auction.frontend.seller.auction_products_bids', compact('bids', 'product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bid_destroy_admin($id)
    {
        AuctionProductBid::destroy($id);
        flash(translate('Bid deleted successfully'))->success();
        return back();
    }

    public function bid_destroy_seller($id)
    {
        AuctionProductBid::destroy($id);
        flash(translate('Bid deleted successfully'))->success();
        return back();
    }
}
