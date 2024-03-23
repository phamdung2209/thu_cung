@if (count($newest_products) > 0)
    <section class="mb-2 mb-md-3 mt-2 mt-md-3 border">
        <div class="container">
            <!-- Top Section -->
            <div class="d-flex mb-2 mb-md-3 mt-2 mt-md-3  align-items-baseline justify-content-between">
                <!-- Title -->
                <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                    <span class="">{{ translate('New Products') }}</span>
                </h3>
                <!-- Links -->
                <div class="d-flex">
                    <a type="button" class="arrow-prev slide-arrow link-disable text-secondary mr-2" onclick="clickToSlide('slick-prev','section_newest')"><i class="las la-angle-left fs-20 fw-600"></i></a>
                    <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary" href="{{ route('search',['sort_by'=>'newest']) }}">{{ translate('View All') }}</a>
                    <a type="button" class="arrow-next slide-arrow text-secondary ml-2" onclick="clickToSlide('slick-next','section_newest')"><i class="las la-angle-right fs-20 fw-600"></i></a>
                </div>
            </div>
            <!-- Products Section -->
            <div class="px-sm-3">
                <div class="aiz-carousel arrow-none sm-gutters-16" data-rows="2" data-items="3" data-xl-items="3" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='false'>
                    @foreach ($newest_products as $key => $new_product)
                    <div class="carousel-box px-3 position-relative has-transition hov-animate-outline">
                        @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $new_product])
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif