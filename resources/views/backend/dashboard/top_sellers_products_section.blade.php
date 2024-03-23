<!-- sellers -->
<div class="aiz-carousel dashboard-box-carousel half-outside-arrow" data-items="6.5" data-xl-items="4.5"
    data-lg-items="5" data-md-items="7" data-sm-items="5" data-xs-items="3" data-arrows='true'>
    
    @foreach ($new_top_sellers as $key => $top_sellers_product)
        <div class="carousel-box top_sellers_products @if ($key == 0) active @endif" onclick="top_sellers_products({{ $top_sellers_product->shop_id }}, this)">
            <div class="size-80px border border-dashed rounded-2 overflow-hidden p-1">
                <div class="h-100 rounded-2 overflow-hidden d-flex align-items-center">
                    <img src="{{ uploaded_asset($top_sellers_product->logo) }}" alt="{{ translate('sellers') }}"
                        class="img-fit lazyload" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                </div>
            </div>
            <p class="fs-11 fw-400 text-soft-dark text-truncate-2 h-30px px-1 w-80px">
                {{ $top_sellers_product->shop_name }}
            </p>
        </div>
        
    @endforeach
</div>

<!-- seller products -->
<div class="position-relative">
    @foreach($new_top_sellers as $key => $top_sellers_product)
        <div class="top_sellers_product_table top-products-table table-responsive c-scrollbar-light @if ($key == 0) show @endif" 
            style="max-height: 215px; width: 100%;" id="top_sellers_product_table_{{ $top_sellers_product->shop_id }}">
            <table class="table dashboard-table mb-0">
                <thead>
                    <tr class="fs-11 fw-600 text-secondary">
                        <th class="pl-0 border-top-0 border-bottom-1">{{ translate('Item') }}</th>
                        <th class="border-top-0 border-bottom-1">{{ translate('Quantity') }}</th>
                        <th class="text-right pr-1 border-top-0 border-bottom-1">{{ translate('Total Price') }}</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($top_sellers_product->products as $row)
                        @php
                            $external_link = $row->thumbnail->external_link;
                            $product_url = route('product', $row->product_slug);
                            if ($row->auction_product == 1) {
                                $product_url = route('auction-product', $row->product_slug);
                            }
                        @endphp
                        <tr>
                            <td class="pl-0" style="vertical-align: middle">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-2 overflow-hidden"
                                        style="min-height: 48px !important; min-width: 48px !important;max-height: 48px !important; max-width: 48px !important;">
                                        <a href="{{ $product_url }}" class="d-block" target="_blank">
                                            <img src="{{ ($external_link == null) ? my_asset($row->thumbnail->file_name) : $external_link }}" alt="{{ translate('category')}}" 
                                                class="h-100 img-fit lazyload" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        </a>
                                    </div>
                                    <a href="{{ $product_url }}" target="_blank" class="d-block text-soft-dark fw-400 hov-text-primary ml-2 fs-13" title="{{ $row->name }}">
                                        {{ Str::limit($row->name, 50, ' ...') }}
                                    </a>
                                </div>
                            </td>
                            <td style="vertical-align: middle" class="text-soft-dark fw-700">
                                X {{ $row->total_quantity }}
                            </td>
                            <td style="vertical-align: middle" class="text-soft-dark fw-700 text-right pr-1">
                                {{ single_price($row->sale) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>