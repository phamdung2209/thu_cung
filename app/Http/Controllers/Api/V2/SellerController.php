<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\V2\PurchaseHistoryMiniCollection;
use App\Http\Resources\V2\PurchaseHistoryCollection;
use App\Http\Resources\V2\PurchaseHistoryItemsCollection;
use App\Http\Resources\V2\ShopCollection;
use App\Models\OrderDetail;

class SellerController extends Controller
{

    public function topSellers()
    {
        $best_selers = get_best_sellers(5);
        return new ShopCollection($best_selers);
    }
}
