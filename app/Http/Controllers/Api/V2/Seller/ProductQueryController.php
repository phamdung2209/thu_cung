<?php

namespace App\Http\Controllers\Api\V2\Seller;

use App\Models\ProductQuery;
use Illuminate\Http\Request;
use App\Http\Resources\V2\Seller\ProductQueryResource;

class ProductQueryController extends Controller
{

    public function product_queries()
    {
        $queries = ProductQuery::where('seller_id', auth()->user()->id)->latest()->paginate(20);
        return ProductQueryResource::collection($queries);
    }

    public function product_queries_show($id)
    {
        $product_query = ProductQuery::findOrFail($id);
        if (auth()->user()->id != $product_query->seller_id) {
            return $this->failed(translate('This Query is not yours'));
        }
        
        return new ProductQueryResource($product_query);
    }

    public function product_queries_reply(Request $request, $id)
    {
        $this->validate($request, [
            'reply' => 'required',
        ]);
        
        $product_query = ProductQuery::findOrFail($id);
        if (auth()->user()->id != $product_query->seller_id) {
            return $this->failed(translate('You cannot reply to this query'));
        }

        $product_query->reply = $request->reply;
        $product_query->save();
        return $this->success(translate('Replied successfully'));
    }
}
