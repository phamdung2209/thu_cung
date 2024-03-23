@if(count($todays_deal_products) > 0)
    <section class="">
        <div class="container">
            <!-- Banner -->
            @if (get_setting('todays_deal_banner') != null || get_setting('todays_deal_banner_small') != null)
                <div class="overflow-hidden d-none d-md-block">
                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" 
                        data-src="{{ uploaded_asset(get_setting('todays_deal_banner')) }}" 
                        alt="{{ env('APP_NAME') }} promo" class="lazyload img-fit h-100 has-transition" 
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                </div>
                <div class="overflow-hidden d-md-none">
                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" 
                        data-src="{{ get_setting('todays_deal_banner_small') != null ? uploaded_asset(get_setting('todays_deal_banner_small')) : uploaded_asset(get_setting('todays_deal_banner')) }}" 
                        alt="{{ env('APP_NAME') }} promo" class="lazyload img-fit h-100 has-transition" 
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                </div>
            @endif
            <!-- Products -->
            @php
                $todays_deal_banner_text_color =  ((get_setting('todays_deal_banner_text_color') == 'light') ||  (get_setting('todays_deal_banner_text_color') == null)) ? 'text-white' : 'text-dark';
            @endphp
            <div class="" style="background-color: {{ get_setting('todays_deal_bg_color', '#3d4666') }}">
                <div class="text-right px-4 px-xl-5 pt-4 pt-md-3">
                    <a href="{{ route('todays-deal') }}" class="fs-12 fw-700 {{ $todays_deal_banner_text_color }} has-transition hov-text-secondary-base">{{ translate('View All') }}</a>
                </div>
                <div class="c-scrollbar-light overflow-hidden px-4 px-md-5 pb-3 pt-3 pt-md-3 pb-md-5">
                    <div class="h-100 d-flex flex-column justify-content-center">
                        <div class="todays-deal aiz-carousel" data-items="7" data-xxl-items="7" data-xl-items="6" data-lg-items="5" data-md-items="4" data-sm-items="3" data-xs-items="2" data-arrows="true" data-dots="false" data-autoplay="true" data-infinite="true">
                            @foreach ($todays_deal_products as $key => $product)
                                <div class="carousel-box h-100 px-3 px-lg-0">
                                    <a href="{{ route('product', $product->slug) }}" class="h-100 overflow-hidden hov-scale-img mx-auto" title="{{  $product->getTranslation('name')  }}">
                                        <!-- Image -->
                                        <div class="img h-80px w-80px rounded-content overflow-hidden mx-auto">
                                            <img class="lazyload img-fit m-auto has-transition"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ get_image($product->thumbnail) }}"
                                                alt="{{ $product->getTranslation('name') }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        </div>
                                        <!-- Price -->
                                        <div class="fs-14 mt-3 text-center">
                                            <span class="d-block {{ $todays_deal_banner_text_color }} fw-700">{{ home_discounted_base_price($product) }}</span>
                                            @if(home_base_price($product) != home_discounted_base_price($product))
                                                <del class="d-block text-secondary fw-400">{{ home_base_price($product) }}</del>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif