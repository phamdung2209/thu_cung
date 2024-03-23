@props(['notifications', 'is_linkable' => false])


@forelse($notifications as $notification)
    <li class="list-group-item d-flex justify-content-between align-items- py-3">
        <div class="media text-inherit">
            <div class="media-body">
                <p class="mb-1 text-truncate-2">
                    @php $user_type = auth()->user()->user_type; @endphp

                    @if ($notification->type == 'App\Notifications\OrderNotification')
                        {{ translate('Order code: ') }}
                        @if ($is_linkable)
                            @php
                                if ($user_type == 'admin'){
                                    $route = route('all_orders.show', encrypt($notification->data['order_id']));
                                }
                                if ($user_type == 'seller'){
                                    $route = route('seller.orders.show', encrypt($notification->data['order_id']));
                                }
                            @endphp
                            <a href="{{ $route }}">
                        @endif

                        {{ $notification->data['order_code'] }}

                        @if ($is_linkable)
                            </a>
                        @endif
                        
                        {{ translate(' has been ' . ucfirst(str_replace('_', ' ', $notification->data['status']))) }}
                        
                    @elseif ($notification->type == 'App\Notifications\ShopVerificationNotification')
                        @if ($user_type == 'admin')
                            @if ($is_linkable)
                                <a href="{{ route('sellers.show_verification_request', $notification->data['id']) }}">
                            @endif
                            {{ $notification->data['name'] }}: 
                            @if ($is_linkable)
                                </a>
                            @endif
                        @else
                            {{ translate('Your ') }}
                        @endif
                        {{ translate('verification request has been '.$notification->data['status']) }}
                    @elseif ($notification->type == 'App\Notifications\ShopProductNotification')
                        @php 
                            $product_id     = $notification->data['id'];
                            $product_type   = $notification->data['type'];
                            $product_name   = $notification->data['name'];
                            $lang           = env('DEFAULT_LANGUAGE');

                            $route = $user_type == 'admin'
                                    ? ( $product_type == 'physical'
                                        ? route('products.seller.edit', ['id'=>$product_id, 'lang'=>$lang])
                                        : route('digitalproducts.edit', ['id'=>$product_id, 'lang'=>$lang] ))
                                    : ( $product_type == 'physical'
                                        ? route('seller.products.edit', ['id'=>$product_id, 'lang'=>$lang]) 
                                        : route('seller.digitalproducts.edit',  ['id'=>$product_id, 'lang'=>$lang] ));
                        @endphp

                        {{ translate('Product : ') }}
                        @if ($is_linkable)
                            <a href="{{ $route }}">{{ $product_name }}</a>
                        @else
                            {{ $product_name }}
                        @endif
                        
                        {{ translate(' is').' '.$notification->data['status'] }}
                    @elseif ($notification->type == 'App\Notifications\PayoutNotification')
                        @php 
                            $route = $user_type == 'admin'
                                    ? ( $notification->data['status'] == 'pending' ? route('withdraw_requests_all') : route('sellers.payment_histories'))
                                    : ( $notification->data['status'] == 'pending' ? route('seller.money_withdraw_requests.index') : route('seller.payments.index'));
                            
                        @endphp

                         {{ $user_type == 'admin' ? $notification->data['name'].': ' : translate('Your') }}
                         @if ($is_linkable )
                             <a href="{{ $route }}">{{ translate('payment') }}</a>
                         @else
                             {{ translate('payment') }}
                         @endif
                         {{ single_price($notification->data['payment_amount']).' '.translate('is').' '.translate($notification->data['status']) }}
                    @endif
                </p>
                <small class="text-muted">
                    {{ date('F j Y, g:i a', strtotime($notification->created_at)) }}
                </small>
            </div>
        </div>
    </li>
@empty
    <li class="list-group-item">
        <div class="py-4 text-center fs-16">
            {{ translate('No notification found') }}
        </div>
    </li>
@endforelse
