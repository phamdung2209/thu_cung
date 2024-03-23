@extends('seller.layouts.app')

@section('panel_content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Bidded Products') }}</h5>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th width="40%" >{{ translate('Product Name')}}</th>
                        <th data-breakpoints="md">{{ translate('My Bidded Amount')}}</th>
                        <th data-breakpoints="md">{{ translate('Highest Bid Amount')}}</th>
                        <th data-breakpoints="md">{{ translate('Auction End Date')}}</th>
                        <th class="text-right">{{ translate('Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bids as $key => $bid_id)
                        @php
                            $bid = \App\Models\AuctionProductBid::find($bid_id->id);;
                        @endphp
                        <tr>
                            <td>{{ ($key+1) + ($bids->currentPage() - 1)*$bids->perPage() }}</td>
                            <td><a href="{{ route('auction-product', $bid->product->slug) }}">{{ $bid->product->getTranslation('name') }}</a></td>
                            <td>{{ single_price($bid->amount) }}</td>
                            <td>
                                @php $highest_bid = $bid->where('product_id',$bid->product_id)->max('amount'); @endphp
                                <span class="badge badge-inline @if($bid->amount < $highest_bid) badge-danger @else badge-success @endif">
                                    {{ single_price($highest_bid) }}
                                </span>
                            </td>
                            <td>
                                @if($bid->product->auction_end_date < strtotime("now"))
                                    {{ translate('Ended') }}
                                @else
                                    {{ date('Y-m-d H:i:s', $bid->product->auction_end_date) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @php
                                    $order = null;
                                    $order_detail = \App\Models\OrderDetail::where('product_id',$bid->product_id)->first();
                                    if($order_detail != null ){
                                        $order = \App\Models\Order::where('id',$order_detail->order_id)->where('user_id',Auth::user()->id)->first();
                                    }
                                @endphp
                                @if($bid->product->auction_end_date < strtotime("now") && $bid->amount == $highest_bid && $order == null)
                                    @php
                                        $carts = \App\Models\Cart::where('user_id', Auth::user()->id)->get();
                                    @endphp
                                    @if(count($carts) > 0 )
                                        @php
                                            $cart_has_this_product = false;
                                            foreach ($carts as $key => $cart){
                                                if($cart->product_id == $bid->product_id){
                                                    $cart_has_this_product = true;
                                                    break;
                                                }
                                            }
                                        @endphp
                                        @if($cart_has_this_product)
                                            <button type="button" class="btn btn-sm btn-primary buy-now fw-600" data-toggle="tooltip" title="{{ translate('Item alreday added to the cart.') }}">
                                                {{ translate('Buy') }}
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-primary buy-now fw-600" data-toggle="tooltip" title="{{ translate('Remove other items to add auction product.') }}">
                                                {{ translate('Buy') }}
                                            </button>
                                        @endif
                                    @else
                                        <button type="button" class="btn btn-sm btn-primary buy-now fw-600" onclick="showAuctionAddToCartModal({{ $bid->product_id }})">
                                            {{ translate('Buy') }}
                                        </button>
                                    @endif
                                @elseif($order != null)
                                    <button type="button" class="btn btn-sm btn-success buy-now fw-600" >{{ translate('Purchased') }}</button>
                                @else
                                    N\A
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
            	{{ $bids->links() }}
          	</div>
        </div>
    </div>

@endsection

@section('script')
<script type="text/javascript">
    function showAuctionAddToCartModal(id){
        if(!$('#modal-size').hasClass('modal-lg')){
            $('#modal-size').addClass('modal-lg');
        }
        $('#addToCart-modal-body').html(null);
        $('#addToCart').modal();
        $('.c-preloader').show();
        $.post('{{ route('auction.cart.showCartModal') }}', {_token: AIZ.data.csrf, id:id}, function(data){
            $('.c-preloader').hide();
            $('#addToCart-modal-body').html(data);
            AIZ.plugins.slickCarousel();
            AIZ.plugins.zoom();
            AIZ.extra.plusMinus();
            getVariantPrice();
        });
    }
</script>
@endsection
