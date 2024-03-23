@if (get_setting('home_categories') != null)
    @php
        $home_categories = json_decode(get_setting('home_categories'));
        $categories = get_category($home_categories);
    @endphp
    @if (count($categories) > 0)
        <div class="py-4">
            @foreach ($categories as $category_key => $category)
                @php
                    $category_name = $category->getTranslation('name');
                @endphp
                <section class="py-3" style="">
                    <div class="container">
                        <div class="d-sm-flex bg-white">
                            <!-- Home category banner & name -->
                            <div class="px-0 pt-0 pb-3 p-sm-4">
                                <div class="w-sm-260px h-260px mx-auto">
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
                            <div class="p-0 p-sm-4 w-100 overflow-hidden">
                                <div class="aiz-carousel arrow-x-0 arrow-inactive-none" data-items="5"
                                    data-xxl-items="5" data-xl-items="3.5" data-lg-items="3" data-md-items="2" data-sm-items="1"
                                    data-xs-items="2" data-arrows='true' data-infinite='false'>
                                    @foreach (get_cached_products($category->id) as $product_key => $product)
                                        <div
                                            class="carousel-box px-3 position-relative has-transition hov-animate-outline">
                                            @include('frontend.'.get_setting('homepage_select').'.partials.product_box_2', ['product' => $product])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endforeach
        </div>
    @endif
@endif
