@if (count(get_featured_products()) > 0)
    <section class="mb-2 mb-md-3">
        <div class="container">
            <div class="border border-primary overflow-hidden">
                <!-- Top Section -->
                <div class="d-flex mb-2 mb-md-3 pt-3 pt-md-4 px-3 align-items-baseline justify-content-between">
                    <!-- Title -->
                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                        <span class="">{{ translate('Featured Products') }}</span>
                    </h3>
                    <!-- Links -->
                    <div class="d-flex">
                        <a type="button" class="arrow-prev slide-arrow link-disable text-secondary mr-2" onclick="clickToSlide('slick-prev','section_featured')"><i class="las la-angle-left fs-20 fw-600"></i></a>
                        <a type="button" class="arrow-next slide-arrow text-secondary ml-2" onclick="clickToSlide('slick-next','section_featured')"><i class="las la-angle-right fs-20 fw-600"></i></a>
                    </div>
                </div>
                <!-- Products Section -->
                <div class="px-sm-3">
                    <div class="aiz-carousel sm-gutters-15 arrow-none" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='false'>
                        @foreach (get_featured_products() as $key => $product)
                        <div class="carousel-box position-relative px-0 has-transition hov-animate-outline">
                            <div class="px-3">
                                @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $product])
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>   
@endif