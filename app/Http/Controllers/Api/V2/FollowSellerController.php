<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\FollowSellerResource;
use App\Models\FollowSeller;
use Illuminate\Http\Request;

class FollowSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $followed_sellers = FollowSeller::query()
            ->with('shop')
            ->where('user_id', auth()->user()->id)
            ->orderBy('shop_id', 'asc')
            ->paginate(10);

        return FollowSellerResource::collection($followed_sellers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($shop_id)
    {
        if (auth()->user()->user_type == 'customer') {
            $followed_seller = FollowSeller::where('user_id', auth()->user()->id)->where('shop_id', $shop_id)->first();
            if ($followed_seller == null) {
                FollowSeller::insert([
                    'user_id' => auth()->user()->id,
                    'shop_id' => $shop_id
                ]);
            }
            return $this->success(translate('Seller follow is successfull'));
        }

        return $this->failed(translate('You need to login as a customer to follow this seller'));
    }

    public function remove($shop_id)
    {
        $followed_seller = FollowSeller::where('user_id', auth()->user()->id)->where('shop_id', $shop_id)->first();
        if ($followed_seller != null) {
            FollowSeller::where('user_id', auth()->user()->id)->where('shop_id', $shop_id)->delete();

            return $this->success(translate('Seller unfollow is successfull'));
        }
    }

    public function checkFollow($shop_id)
    {
        $followed_seller = FollowSeller::where('user_id', auth()->user()->id)->where('shop_id', $shop_id)->first();
        if ($followed_seller != null) {
            return $this->success(translate('This seller is followed'));
        }
        return $this->failed(translate('This seller is unfollowed'));
    }
    
}
