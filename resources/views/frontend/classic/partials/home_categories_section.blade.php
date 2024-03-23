@if (get_setting('home_categories') != null)
    @php
        $home_categories = json_decode(get_setting('home_categories'));
        $categories = get_category($home_categories);
    @endphp
    @foreach ($categories as $category_key => $category)
        @php
            $category_name = $category->getTranslation('name');
        @endphp
        <section class="@if ($category_key != 0) mt-4 @endif" style="">
            <div class="container">
                <div class="row gutters-16">
                    <!-- Home category banner & name -->
                    <div class="col-xl-3 col-lg-4 col-md-5">
                        <div class="h-200px h-sm-250px h-md-340px">
                            <a href="{{ route('products.category', $category->slug) }}" class="d-block h-100 w-100 w-xl-auto hov-scale-img overflow-hidden home-category-banner">
                                <span class="position-absolute h-100 w-100 overflow-hidden">
                                    <img src="{{ isset($category->coverImage->file_name) ? my_asset($category->coverImage->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                        alt="{{ $category_name }}"
                                        class="img-fit h-100 has-transition"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                </span>
                                <span class="home-category-name fs-15 fw-600 text-white text-center">
                                    <span class="">{{ $category_name }}</span>
                                </span>
                            </a>
                        </div>
                    </div>
                    <!-- Category Products -->
                    <div class="col-xl-9 col-lg-8 col-md-7">
                        <div class="aiz-carousel arrow-x-0 border-right arrow-inactive-none" data-items="5"
                            data-xxl-items="5" data-xl-items="4.5" data-lg-items="3" data-md-items="2" data-sm-items="2"
                            data-xs-items="2" data-arrows='true' data-infinite='false'>
                            @foreach (get_cached_products($category->id) as $product_key => $product)
                                <div
                                    class="carousel-box px-3 position-relative has-transition border-right border-top border-bottom @if ($product_key == 0) border-left @endif hov-animate-outline">
                                    @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1', ['product' => $product])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endif
