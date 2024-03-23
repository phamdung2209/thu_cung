<!-- categories -->
<div class="aiz-carousel dashboard-box-carousel half-outside-arrow" data-items="6.5" data-xl-items="5" data-lg-items="4.5"
    data-md-items="7" data-sm-items="5" data-xs-items="3" data-arrows='true'>
    @php
        $top_categories_product_limit = 1;
    @endphp
    @foreach ($top_categories_products as $key => $top_categories_product)
        <div class="carousel-box topproducts top_category_products @if ($key == $top_categories2[0]) active @endif" onclick="top_category_products({{ $key }}, this)">
            <div class="size-80px border border-dashed rounded-2 overflow-hidden p-1">
                <div class="h-100 rounded-2 overflow-hidden d-flex align-items-center">
                    <img src="{{ uploaded_asset($top_categories_product[0]->cover_image) }}" alt="{{ translate('category')}}" 
                        class="img-fit lazyload" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                </div>
            </div>
            <p class="fs-11 fw-400 text-soft-dark text-truncate-2 h-30px px-1 w-80px">
                @php
                    $lang = App::getLocale();
                    $category = App\Models\CategoryTranslation::where('category_id', $top_categories_product[0]->category_id)
                    ->where('lang', $lang)
                    ->first();
                @endphp
                {{ $category ? $category->name : translate('Not Found') }}
            </p>
        </div>

        @php
            $top_categories_product_limit++;
            if($top_categories_product_limit > 12)
                break;
        @endphp
    @endforeach
</div>

<!-- category products -->
<div class="position-relative">
    @php
        $top_categories_product_limit = 1;
    @endphp
    @foreach($top_categories_products as $key => $top_categories_product)
        <div class="top_category_product_table top-products-table table-responsive c-scrollbar-light @if ($key == $top_categories2[0]) show @endif" style="max-height: 215px; width: 100%;" id="top_category_product_table_{{ $key }}">
            <table class="table dashboard-table mb-0">
                <thead>
                    <tr class="fs-11 fw-600 text-secondary">
                        <th class="pl-0 border-top-0 border-bottom-1">{{translate('Item')}}</th>
                        <th class="border-top-0 border-bottom-1">{{translate('Quantity')}}</th>
                        <th class="text-right pr-1 border-top-0 border-bottom-1">{{translate('Total Price')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($top_categories_product as $row)
                        @php
                            $product_url = route('product', $row->product_slug);
                            if ($row->auction_product == 1) {
                                $product_url = route('auction-product', $row->product_slug);
                            }
                        @endphp
                        <tr>
                            <td class="pl-0" style="vertical-align: middle">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-2 overflow-hidden" style="min-height: 48px !important; min-width: 48px !important;max-height: 48px !important; max-width: 48px !important;">
                                        <a href="{{ $product_url }}" class="d-block" target="_blank">
                                            <img src="{{ ($row->product_thumbnail_img->external_link == null) ? my_asset($row->product_thumbnail_img->file_name) : $row->product_thumbnail_img->external_link }}" alt="{{ translate('category')}}" 
                                                class="h-100 img-fit lazyload" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        </a>
                                    </div>
                                    <a href="{{ $product_url }}" target="_blank" class="d-block text-soft-dark fw-400 hov-text-primary ml-2 fs-13" title="{{ $row->product_name }}">
                                        {{ Str::limit($row->product_name, 50, ' ...') }}
                                    </a>
                                </div>
                            </td>
                            <td style="vertical-align: middle" class="text-soft-dark fw-700">
                                X {{ $row->sales }}
                            </td>
                            <td style="vertical-align: middle" class="text-soft-dark fw-700 text-right pr-1">
                                {{ single_price($row->total) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @php
            $top_categories_product_limit++;
            if($top_categories_product_limit > 12)
                break;
        @endphp
    @endforeach
</div>