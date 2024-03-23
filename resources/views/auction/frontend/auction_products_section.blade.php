<section class="mb-4">
    <div class="container">
        <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
            <div class="d-flex mb-3 align-items-baseline border-bottom">
                <h3 class="h5 fw-700 mb-0">
                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Auction Products') }}</span>
                </h3>
                <a href="{{ route('auction_products.all') }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View More') }}</a>
            </div>
            <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'>
                @php
                    $products = \App\Models\Product::latest()->where('published', 1)->where('auction_product', 1);
                    if(get_setting('seller_auction_product') == 0){
                        $products = $products->where('added_by','admin');
                    }
                    $products = $products->where('auction_start_date','<=', strtotime("now"))->where('auction_end_date','>=', strtotime("now"))->limit(12)->get();
                @endphp
                @foreach ($products as $key => $product)
                    <div class="carousel-box">
                        <div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                            <div class="position-relative">
                                <a href="{{ route('auction-product', $product->slug) }}" class="d-block">
                                    <img
                                        class="img-fit lazyload mx-auto h-140px h-md-210px"
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                        alt="{{  $product->getTranslation('name')  }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                    >
                                </a>
                            </div>
                            <div class="p-md-3 p-2 text-left">
                                <div class="fs-15">
                                    <span class="fw-700 text-primary">{{ single_price($product->starting_bid) }}</span>
                                </div>
                                <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                    <a href="{{ route('auction-product', $product->slug) }}" class="d-block text-reset">{{  $product->getTranslation('name')  }}</a>
                                </h3>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
