@extends('frontend.layouts.app')
@php
    $cart_added = [];
    $decoded_slider_images = json_decode(get_setting('home_slider_images', null, $lang), true);
    $sliders = get_slider_images($decoded_slider_images);
    $home_slider_links = get_setting('home_slider_links', null, $lang);
    $top_brands = json_decode(get_setting('top_brands'));
    $brands = get_brands($top_brands);

@endphp
@section('content')
    <style>
        @media (max-width: 767px) {
            product__oneday-card #flash_deal .flash-deals-baner {
                height: 203px !important;
            }
        }
    </style>

    @php $lang = get_system_language()->code;  @endphp
    <!-- Sliders -->
    <div class="container">
        <!-- Sliders -->
        <div class="home-banner-area mb-3" style="">
            <div class="container">
                <div class="row d-flex flex-nowrap h-280px mt-4">
                    <!-- Sliders -->
                    @if (get_setting('home_slider_images', null, $lang) != null)
                        <div class="banner-main-slider col-8 w-100">
                            @foreach ($sliders as $key => $slider)
                                <img class="sliderBannerPrimary d-block rounded-xl mw-100 w-100 img-fit h-280px"
                                    src="{{ $slider ? my_asset($slider->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                    alt="{{ env('APP_NAME') }} promo"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                            @endforeach
                        </div>
                    @endif
                    <!-- One day product -->
                    @php $oneday_product = get_todays_product(); @endphp
                    <div class="payMoneyAdsProduct col-4  d-flex flex-column align-items-center justify-content-center">
                        <div class="productOneDay d-flex align-items-center justify-content-between w-100">
                            <h2 class="font-weight-bold fs-20">Sản phẩm trong ngày</h2>
                            {{-- <span class="font-weight-bold inline-block fs-16">
                                {{ date('H:i d/m/Y', strtotime($oneday_product->created_at)) }}
                            </span> --}}
                            <?php
                            $date = isset($oneday_product->created_at) ? date('H:i d/m/Y', strtotime($oneday_product->created_at)) : '';
                            ?>
                            <span class="font-weight-bold inline-block fs-16">
                                <?php echo $date; ?>
                            </span>
                        </div>
                        <div class="product__oneday-card row d-flex align-items-center w-100">
                            <div class="col-6">
                                {{-- <img class="mw-100 img-fit h-140px"
                                    src="{{ $oneday_product->thumbnail != null ? my_asset($oneday_product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                    alt="{{ $oneday_product->getTranslation('name') }}"
                                    title="{{ $oneday_product->getTranslation('name') }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                    alt="" /> --}}
                                @if ($oneday_product != null && $oneday_product->getTranslation() != null)
                                    <img class="mw-100 img-fit h-140px"
                                        src="{{ my_asset($oneday_product->thumbnail->file_name) }}"
                                        alt="{{ $oneday_product->getTranslation('name') }}"
                                        title="{{ $oneday_product->getTranslation('name') }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                @else
                                    <img class="mw-100 img-fit h-140px"
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}" alt=""
                                        title="">
                                @endif
                            </div>
                            <div class="col-6 px-0 d-flex flex-column" style="gap:10px;">
                                <div class="product__oneday-price d-flex align-items-center">
                                    <span class="fw-700 fs-20 text-primary">
                                        {{-- {{ number_format($oneday_product->unit_price, 0, ',', '.') }} --}}
                                        {{ number_format(isset($oneday_product->unit_price), 0, ',', '.') }}
                                        đ
                                    </span>
                                    <span class="fw-500 text-gray-dark fs-11 ml-2 text-decoration-line-through">
                                        {{ home_discounted_base_price($oneday_product) }}
                                    </span>
                                </div>

                                @if (avg_start_rating($oneday_product->id) > 0)
                                    <div
                                        class="oneday_product__onday-rate d-flex align-items-center justify-content-between">
                                        <div class="start__count d-flex align-items-center ">
                                            <img class="icon-xs" src="{{ static_asset('assets/img/star.svg') }}"
                                                alt="">
                                            <span
                                                class="rating-count fs-12 fw-700">{{ avg_start_rating($oneday_product->id) }}</span>
                                        </div>

                                        <div class="numberReviews ml-3  flex items-center gap-1 d-flex align-items-center"
                                            style="gap:5px">
                                            <img width="20px" src="{{ static_asset('assets/img/chat.svg') }}"
                                                alt=""><span class="count__rate">
                                                {{ count_review($oneday_product->id) }}
                                                đánh
                                                giá</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="product-rating my-1 d-flex align-items-center mb-2">
                                        <span class="text-danger">Chưa có đánh giá</span>
                                    </div>
                                @endif

                                <div class="product__oneday-name">
                                    <h2 class="fs-15 fw-500 ">
                                        <a href="{{ route('product', $oneday_product->slug) }}"
                                            class="text-reset">{{ $oneday_product->getTranslation('name') }}</a>
                                    </h2>

                                </div>

                                <a @if (in_array($oneday_product->id, $cart_added)) active @endif" href="javascript:void(0)"
                                    @if (Auth::check()) onclick="showAddToCartModal({{ $oneday_product->id }})" @else onclick="showLoginModal()" @endif>
                                    <button class="btn__add-to-cart fs-12 btn w-100 p-2" style="white-space:nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="icon-sm mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>
                                        Thêm vào giỏ hàng
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="categoryBodyContainer text-center">
            <h2 class="categoryBodyContainer--title font-weight-bold">Danh mục của chúng tôi</h2>
            <div class="aiz-category-menu bg-white rounded-0 " id="category-sidebar">
                <ul class="category-section d-flex justify-content-center slideCategory">
                    @foreach (get_level_zero_categories()->take(10) as $key => $category)
                        @php
                            $category_name = $category->getTranslation('name');
                        @endphp
                        <li class="category-nav-element " data-id="{{ $category->id }}">
                            <a href="{{ route('products.category', $category->slug) }}"
                                class="category-section--child text-center d-flex flex-column align-items-center ">
                                <img class="category-child--image lazyload"
                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ isset($category->catIcon->file_name) ? my_asset($category->catIcon->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                    width="16" alt="{{ $category_name }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                <span class="cat-name has-transition">{{ $category_name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="bannerBody container">
            <div class="smallBannerAds row d-flex flex-nowrap justify-content-between">
                <div class="bannerContainerChild col-4">
                    <img class="imageBannerAds w-100 img-fit"
                        src="{{ static_asset('assets/img/bannerqcbody/banner_qc.webp') }}" alt="">
                    <div class="payMoneyAds">
                        <span class="text-[10px]">Quảng cáo</span>
                    </div>
                </div>
                <div class="bannerContainerChild col-4">
                    <img class="imageBannerAds w-100 img-fit"
                        src="{{ static_asset('assets/img/bannerqcbody/banner_qc.webp') }}" alt="">
                    <div class="payMoneyAds">
                        <span class="text-[10px]">Quảng cáo</span>
                    </div>
                </div>
                <div class="bannerContainerChild col-4">
                    <img class="imageBannerAds w-100 img-fit"
                        src="{{ static_asset('assets/img/bannerqcbody/banner_qc.webp') }}" alt="">
                    <div class="payMoneyAds">
                        <span class="text-[10px]">Quảng cáo</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Products -->
        <div class="productContainer my-5">
            <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                <!-- Title -->
                <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                    <span class="">Sản phẩm bán chạy nhất</span>
                </h3>
                <!-- Links -->
                <div class="d-flex px-3">
                    <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                        href="{{ route('categories.all') }}">Xem tất cả <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="icon-xs">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="productList container">
                <div class="row featured-product-list-product productListSlide product-sale-home-page ">
                    @foreach (get_all_products() as $product)
                        @php
                            $product_url = route('product', $product->slug);
                        @endphp
                        <div class="featured__product-card product-hover position-relative  p-md-3 p-2   col-lg-2 col-md-3 col-6 d-flex flex-column justify-content-between"
                            style="gap:15px">
                            @if (discount_in_percentage($product) > 0)
                                <div class="product__badge position-absolute start-0 translate-middle rounded px-2"
                                    style="top: 10px; left: 10px;">
                                    <span class="fw-500 text-light">-{{ discount_in_percentage($product) }}%</span>
                                </div>
                            @endif

                            <img class="lazyload mx-auto img-fit has-transition h-150px"
                                src="{{ $product->thumbnail != null ? my_asset($product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                alt="{{ $product->getTranslation('name') }}"
                                title="{{ $product->getTranslation('name') }}"
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                            <div class="product__card-content d-flex flex-column">
                                <a href="{{ $product_url }}" class="product__card-title text-dark">
                                    <h2 class="fs-14 fw-500 text-ellipsis-2">{{ $product->getTranslation('name') }}</h2>
                                </a>
                                @if (avg_start_rating($product->id) > 0)
                                    <div class="product-rating my-1 d-flex align-items-center mb-2">
                                        <div class="star-icons d-flex align-items-center">
                                            <img width="20px" src="{{ static_asset('assets/img/star.svg') }}"
                                                alt="Star">
                                        </div>
                                        <div class="rating-count ml-1 text-sm font-semibold">
                                            {{ avg_start_rating($product->id) }}
                                        </div>
                                        <div class="numberReviews ml-3  flex items-center gap-1 d-flex align-items-center"
                                            style="gap:5px">
                                            <img width="20px" src="{{ static_asset('assets/img/chat.svg') }}"
                                                alt=""><span class="count__rate">
                                                {{ count_review($product->id) }}
                                                đánh
                                                giá</span>
                                        </div>

                                    </div>
                                @else
                                    <div class="product-rating my-1 d-flex align-items-center mb-2">
                                        <span class="text-danger">Chưa có đánh giá</span>
                                    </div>
                                @endif

                                <div class="price-and-cart d-flex flex-column justify-content-between mb-2">
                                    <div class="price-info text-gray-600 d-flex align-items-center gap-3 d-flex "
                                        style="gap:10px;">
                                        {{-- <span class="new-price text-red-600 font-bold text-[24px] inline-block">400.000đ</span>
                                    <span class="old-price text-decoration-line-through">499.000đ</span> --}}

                                        @if (home_base_price($product) != home_discounted_base_price($product))
                                            <div class="disc-amount has-transition">
                                                <del
                                                    class="old-price text-decoration-line-through">{{ $product->unit_price }}</del>
                                            </div>
                                        @endif
                                        <!-- price -->
                                        <div class="">
                                            <span
                                                class="new-price text-red-600 font-bold  inline-block">{{ home_discounted_base_price($product) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="cartContainerandOp d-flex align-items-center justify-content-between ">
                                    <a @if (in_array($product->id, $cart_added)) active @endif" href="javascript:void(0)"
                                        @if (Auth::check()) onclick="showAddToCartModal({{ $product->id }})" @else onclick="showLoginModal()" @endif
                                        class="cart-icon btn__add-to-cart  h-40px d-flex justify-content-center align-items-center">
                                        <img src="{{ static_asset('assets/img/shopping-cart.svg') }}"
                                            alt="Shopping Cart">
                                    </a>
                                    <!-- add to cart -->

                                    <div class="wishlistContainer d-flex  align-items-center " style="gap:10px;">
                                        <div class="wishlist-icon-container flex ">
                                            <a href="javascript:void(0)" class="hov-svg-white"
                                                onclick="addToWishList({{ $product->id }})" data-toggle="tooltip"
                                                data-title="Thêm vào mục ưa thích" data-placement="left">
                                                <img width="20px" class="w-5 h-5 transition transform hover:scale-110"
                                                    src="{{ static_asset('assets/img/heart 2.svg') }}" alt="Wishlist"
                                                    style="cursor: pointer;">
                                            </a>
                                        </div>
                                        <div class="wishlist-icon-container flex">
                                            <a href="javascript:void(0)" data-toggle="tooltip"
                                                data-title="Thêm vào mục so sánh" data-placement="left"
                                                onclick="addToCompare({{ $product->id }})">
                                                <img width="20px" class=" transition transform hover:scale-110"
                                                    src="{{ static_asset('assets/img/chart.svg') }}" alt="Compare"
                                                    style="cursor: pointer;">
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- -------------end list product --}}
                    <!-- Top Sellers -->
                    @if (get_setting('vendor_system_activation') == 1)
                        @php
                            $best_selers = get_best_sellers(5);
                        @endphp
                        @if (count($best_selers) > 0)
                            <section class="mb-2 mb-md-3 mt-2 mt-md-3">
                                <div class="container">
                                    <!-- Top Section -->
                                    <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                                        <!-- Title -->
                                        <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                                            <span class="pb-3">{{ translate('Top Sellers') }}</span>
                                        </h3>
                                        <!-- Links -->
                                        <div class="d-flex">
                                            <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                                                href="{{ route('sellers') }}">{{ translate('View All Sellers') }}</a>
                                        </div>
                                    </div>
                                    <!-- Sellers Section -->
                                    <div class="aiz-carousel arrow-x-0 arrow-inactive-none" data-items="5"
                                        data-xxl-items="5" data-xl-items="4" data-lg-items="3.4" data-md-items="2.5"
                                        data-sm-items="2" data-xs-items="1.4" data-arrows="true" data-dots="false">
                                        @foreach ($best_selers as $key => $seller)
                                            @if ($seller->user != null)
                                                <div
                                                    class="carousel-box h-100 position-relative text-center border-right border-top border-bottom @if ($key == 0) border-left @endif has-transition hov-animate-outline">
                                                    <div class="position-relative px-3"
                                                        style="padding-top: 2rem; padding-bottom:2rem;">
                                                        <!-- Shop logo & Verification Status -->
                                                        <div class="position-relative mx-auto size-100px size-md-120px">
                                                            <a href="{{ route('shop.visit', $seller->slug) }}"
                                                                class="d-flex mx-auto justify-content-center align-item-center size-100px size-md-120px border overflow-hidden hov-scale-img"
                                                                tabindex="0"
                                                                style="border: 1px solid #e5e5e5; border-radius: 50%; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.06);">
                                                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                                    data-src="{{ uploaded_asset($seller->logo) }}"
                                                                    alt="{{ $seller->name }}"
                                                                    class="img-fit lazyload has-transition"
                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                                            </a>
                                                            <div
                                                                class="absolute-top-right z-1 mr-md-2 mt-1 rounded-content bg-white">
                                                                @if ($seller->verification_status == 1)
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24.001"
                                                                        height="24" viewBox="0 0 24.001 24">
                                                                        <g id="Group_25929" data-name="Group 25929"
                                                                            transform="translate(-480 -345)">
                                                                            <circle id="Ellipse_637"
                                                                                data-name="Ellipse 637" cx="12"
                                                                                cy="12" r="12"
                                                                                transform="translate(480 345)"
                                                                                fill="#fff" />
                                                                            <g id="Group_25927" data-name="Group 25927"
                                                                                transform="translate(480 345)">
                                                                                <path id="Union_5" data-name="Union 5"
                                                                                    d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z"
                                                                                    transform="translate(0 0)"
                                                                                    fill="#3490f3" />
                                                                            </g>
                                                                        </g>
                                                                    </svg>
                                                                @else
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24.001"
                                                                        height="24" viewBox="0 0 24.001 24">
                                                                        <g id="Group_25929" data-name="Group 25929"
                                                                            transform="translate(-480 -345)">
                                                                            <circle id="Ellipse_637"
                                                                                data-name="Ellipse 637" cx="12"
                                                                                cy="12" r="12"
                                                                                transform="translate(480 345)"
                                                                                fill="#fff" />
                                                                            <g id="Group_25927" data-name="Group 25927"
                                                                                transform="translate(480 345)">
                                                                                <path id="Union_5" data-name="Union 5"
                                                                                    d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z"
                                                                                    transform="translate(0 0)"
                                                                                    fill="red" />
                                                                            </g>
                                                                        </g>
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <!-- Shop name -->
                                                        <h2
                                                            class="fs-14 fw-700 text-dark text-truncate-2 h-40px mt-3 mt-md-4 mb-0 mb-md-3">
                                                            <a href="{{ route('shop.visit', $seller->slug) }}"
                                                                class="text-reset hov-text-primary"
                                                                tabindex="0">{{ $seller->name }}</a>
                                                        </h2>
                                                        <!-- Shop Rating -->
                                                        <div class="rating rating-mr-1 text-dark mb-3">
                                                            {{ renderStarRating($seller->rating) }}
                                                            <span class="opacity-60 fs-14">({{ $seller->num_of_reviews }}
                                                                {{ translate('Reviews') }})</span>
                                                        </div>
                                                        <!-- Visit Button -->
                                                        <a href="{{ route('shop.visit', $seller->slug) }}"
                                                            class="btn-visit">
                                                            <span class="circle" aria-hidden="true">
                                                                <span class="icon arrow"></span>
                                                            </span>
                                                            <span
                                                                class="button-text">{{ translate('Visit Store') }}</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                        @endif
                    @endif


                </div>
            </div>
            <!-- Banner Section 2 -->
            @php $homeBanner2Images = get_setting('home_banner2_images', null, $lang);   @endphp
            @if ($homeBanner2Images != null)
                <div class="mb-2 mb-md-3 mt-2 mt-md-3">
                    <div class="container">
                        @php
                            $banner_2_imags = json_decode($homeBanner2Images);
                            $data_md = count($banner_2_imags) >= 2 ? 2 : 1;
                            $home_banner2_links = get_setting('home_banner2_links', null, $lang);
                        @endphp
                        <div class="aiz-carousel gutters-16 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15"
                            data-items="{{ count($banner_2_imags) }}" data-xxl-items="{{ count($banner_2_imags) }}"
                            data-xl-items="{{ count($banner_2_imags) }}" data-lg-items="{{ $data_md }}"
                            data-md-items="{{ $data_md }}" data-sm-items="1" data-xs-items="1" data-arrows="true"
                            data-dots="false">
                            @foreach ($banner_2_imags as $key => $value)
                                <div class="carousel-box overflow-hidden hov-scale-img p-0">
                                    <a href="{{ isset(json_decode($home_banner2_links, true)[$key]) ? json_decode($home_banner2_links, true)[$key] : '' }}"
                                        class="d-block text-reset overflow-hidden position-relative">
                                        <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                            data-src="{{ uploaded_asset($value) }}" alt="{{ env('APP_NAME') }} promo"
                                            class="img-fluid lazyload w-100 has-transition"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                        <div class="adsTitle position-absolute">
                                            <span>Quảng cáo</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif



        </div>

        <div class="list__ads row">
            <div class="col-md-4 col-lg-3 col-6 position-relative mb-4">
                <img class="img-fit w-100" style="border-radius:10px;"
                    src="{{ static_asset('assets/img/BANNER DOC.jpg') }}" alt="">
                <div class="ads__title p-1 bg-light position-absolute rounded-lg" style=" top:5px ;right:20px">
                    <span class="fs-12 fw-500 text-dark d-block">Quảng cáo</span>
                </div>
            </div>

            <div class="col-md-4 col-lg-3 col-6 position-relative mb-4">
                <img class="img-fit w-100" style="border-radius:10px;"
                    src="{{ static_asset('assets/img/BANNER DOC.jpg') }}" alt="">
                <div class="ads__title p-1 bg-light position-absolute rounded-lg" style=" top:5px ;right:20px">
                    <span class="fs-12 fw-500 text-dark d-block">Quảng cáo</span>
                </div>
            </div>

            <div class="col-md-4 col-lg-3 col-6 position-relative mb-4">
                <img class="img-fit w-100" style="border-radius:10px;"
                    src="{{ static_asset('assets/img/BANNER DOC.jpg') }}" alt="">
                <div class="ads__title p-1 bg-light position-absolute rounded-lg" style=" top:5px ;right:20px">
                    <span class="fs-12 fw-500 text-dark d-block">Quảng cáo</span>
                </div>
            </div>

            <div class="col-md-4 col-lg-3 col-6 position-relative mb-4">
                <img class="img-fit w-100" style="border-radius:10px;"
                    src="{{ static_asset('assets/img/BANNER DOC.jpg') }}" alt="">
                <div class="ads__title p-1 bg-light position-absolute rounded-lg" style=" top:5px ;right:20px">
                    <span class="fs-12 fw-500 text-dark d-block">Quảng cáo</span>
                </div>
            </div>
        </div>

        <!-- list san pham section2 -->
        <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
            <!-- Title -->
            <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                <span class="">Sản phẩm nổi bật</span>
            </h3>
            <!-- Links -->
            <div class="d-flex px-3">
                <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                    href="{{ route('categories.all') }}">Xem tất cả <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon-xs">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="productList container">
            <div class="row featured-product-list-product productListSlide product-sale-home-page ">
                @foreach (get_all_products() as $product)
                    @php
                        $product_url = route('product', $product->slug);
                    @endphp
                    <div class="featured__product-card product-hover position-relative  p-md-3 p-2   col-lg-2 col-md-3 col-6 d-flex flex-column justify-content-between"
                        style="gap:15px">
                        @if (discount_in_percentage($product) > 0)
                            <div class="product__badge position-absolute start-0 translate-middle rounded px-2"
                                style="top: 10px; left: 10px;">
                                <span class="fw-500 text-light">-{{ discount_in_percentage($product) }}%</span>
                            </div>
                        @endif

                        <img class="lazyload mx-auto img-fit has-transition h-150px"
                            src="{{ $product->thumbnail != null ? my_asset($product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                            alt="{{ $product->getTranslation('name') }}" title="{{ $product->getTranslation('name') }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                        <div class="product__card-content d-flex flex-column">
                            <a href="{{ $product_url }}" class="product__card-title text-dark">
                                <h2 class="fs-14 fw-500 text-ellipsis-2">{{ $product->getTranslation('name') }}</h2>
                            </a>
                            @if (avg_start_rating($product->id) > 0)
                                <div class="product-rating my-1 d-flex align-items-center mb-2">
                                    <div class="star-icons d-flex align-items-center">
                                        <img width="20px" src="{{ static_asset('assets/img/star.svg') }}"
                                            alt="Star">
                                    </div>
                                    <div class="rating-count ml-1 text-sm font-semibold">
                                        {{ avg_start_rating($product->id) }}
                                    </div>
                                    <div class="numberReviews ml-3  flex items-center gap-1 d-flex align-items-center"
                                        style="gap:5px">
                                        <img width="20px" src="{{ static_asset('assets/img/chat.svg') }}"
                                            alt=""><span class="count__rate"> {{ count_review($product->id) }}
                                            đánh
                                            giá</span>
                                    </div>

                                </div>
                            @else
                                <div class="product-rating my-1 d-flex align-items-center mb-2">
                                    <span class="text-danger">Chưa có đánh giá</span>
                                </div>
                            @endif

                            <div class="price-and-cart d-flex flex-column justify-content-between mb-2">
                                <div class="price-info text-gray-600 d-flex align-items-center gap-3 d-flex "
                                    style="gap:10px;">
                                    {{-- <span class="new-price text-red-600 font-bold text-[24px] inline-block">400.000đ</span>
                                    <span class="old-price text-decoration-line-through">499.000đ</span> --}}

                                    @if (home_base_price($product) != home_discounted_base_price($product))
                                        <div class="disc-amount has-transition">
                                            <del
                                                class="old-price text-decoration-line-through">{{ $product->unit_price }}</del>
                                        </div>
                                    @endif
                                    <!-- price -->
                                    <div class="">
                                        <span
                                            class="new-price text-red-600 font-bold  inline-block">{{ home_discounted_base_price($product) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="cartContainerandOp d-flex align-items-center justify-content-between ">
                                <a @if (in_array($product->id, $cart_added)) active @endif" href="javascript:void(0)"
                                    @if (Auth::check()) onclick="showAddToCartModal({{ $product->id }})" @else onclick="showLoginModal()" @endif
                                    class="cart-icon btn__add-to-cart  h-40px d-flex justify-content-center align-items-center">
                                    <img src="{{ static_asset('assets/img/shopping-cart.svg') }}" alt="Shopping Cart">
                                </a>
                                <!-- add to cart -->

                                <div class="wishlistContainer d-flex  align-items-center " style="gap:10px;">
                                    <div class="wishlist-icon-container flex ">
                                        <a href="javascript:void(0)" class="hov-svg-white"
                                            onclick="addToWishList({{ $product->id }})" data-toggle="tooltip"
                                            data-title="Thêm vào mục ưa thích" data-placement="left">
                                            <img width="20px" class="w-5 h-5 transition transform hover:scale-110"
                                                src="{{ static_asset('assets/img/heart 2.svg') }}" alt="Wishlist"
                                                style="cursor: pointer;">
                                        </a>
                                    </div>
                                    <div class="wishlist-icon-container flex">
                                        <a href="javascript:void(0)" data-toggle="tooltip"
                                            data-title="Thêm vào mục so sánh" data-placement="left"
                                            onclick="addToCompare({{ $product->id }})">
                                            <img width="20px" class=" transition transform hover:scale-110"
                                                src="{{ static_asset('assets/img/chart.svg') }}" alt="Compare"
                                                style="cursor: pointer;">
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- -------------end list product --}}
                <!-- Top Sellers -->
                @if (get_setting('vendor_system_activation') == 1)
                    @php
                        $best_selers = get_best_sellers(5);
                    @endphp
                    @if (count($best_selers) > 0)
                        <section class="mb-2 mb-md-3 mt-2 mt-md-3">
                            <div class="container">
                                <!-- Top Section -->
                                <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                                    <!-- Title -->
                                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                                        <span class="pb-3">{{ translate('Top Sellers') }}</span>
                                    </h3>
                                    <!-- Links -->
                                    <div class="d-flex">
                                        <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                                            href="{{ route('sellers') }}">{{ translate('View All Sellers') }}</a>
                                    </div>
                                </div>
                                <!-- Sellers Section -->
                                <div class="aiz-carousel arrow-x-0 arrow-inactive-none" data-items="5" data-xxl-items="5"
                                    data-xl-items="4" data-lg-items="3.4" data-md-items="2.5" data-sm-items="2"
                                    data-xs-items="1.4" data-arrows="true" data-dots="false">
                                    @foreach ($best_selers as $key => $seller)
                                        @if ($seller->user != null)
                                            <div
                                                class="carousel-box h-100 position-relative text-center border-right border-top border-bottom @if ($key == 0) border-left @endif has-transition hov-animate-outline">
                                                <div class="position-relative px-3"
                                                    style="padding-top: 2rem; padding-bottom:2rem;">
                                                    <!-- Shop logo & Verification Status -->
                                                    <div class="position-relative mx-auto size-100px size-md-120px">
                                                        <a href="{{ route('shop.visit', $seller->slug) }}"
                                                            class="d-flex mx-auto justify-content-center align-item-center size-100px size-md-120px border overflow-hidden hov-scale-img"
                                                            tabindex="0"
                                                            style="border: 1px solid #e5e5e5; border-radius: 50%; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.06);">
                                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                                data-src="{{ uploaded_asset($seller->logo) }}"
                                                                alt="{{ $seller->name }}"
                                                                class="img-fit lazyload has-transition"
                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                                        </a>
                                                        <div
                                                            class="absolute-top-right z-1 mr-md-2 mt-1 rounded-content bg-white">
                                                            @if ($seller->verification_status == 1)
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24.001"
                                                                    height="24" viewBox="0 0 24.001 24">
                                                                    <g id="Group_25929" data-name="Group 25929"
                                                                        transform="translate(-480 -345)">
                                                                        <circle id="Ellipse_637" data-name="Ellipse 637"
                                                                            cx="12" cy="12" r="12"
                                                                            transform="translate(480 345)"
                                                                            fill="#fff" />
                                                                        <g id="Group_25927" data-name="Group 25927"
                                                                            transform="translate(480 345)">
                                                                            <path id="Union_5" data-name="Union 5"
                                                                                d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z"
                                                                                transform="translate(0 0)"
                                                                                fill="#3490f3" />
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24.001"
                                                                    height="24" viewBox="0 0 24.001 24">
                                                                    <g id="Group_25929" data-name="Group 25929"
                                                                        transform="translate(-480 -345)">
                                                                        <circle id="Ellipse_637" data-name="Ellipse 637"
                                                                            cx="12" cy="12" r="12"
                                                                            transform="translate(480 345)"
                                                                            fill="#fff" />
                                                                        <g id="Group_25927" data-name="Group 25927"
                                                                            transform="translate(480 345)">
                                                                            <path id="Union_5" data-name="Union 5"
                                                                                d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z"
                                                                                transform="translate(0 0)"
                                                                                fill="red" />
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <!-- Shop name -->
                                                    <h2
                                                        class="fs-14 fw-700 text-dark text-truncate-2 h-40px mt-3 mt-md-4 mb-0 mb-md-3">
                                                        <a href="{{ route('shop.visit', $seller->slug) }}"
                                                            class="text-reset hov-text-primary"
                                                            tabindex="0">{{ $seller->name }}</a>
                                                    </h2>
                                                    <!-- Shop Rating -->
                                                    <div class="rating rating-mr-1 text-dark mb-3">
                                                        {{ renderStarRating($seller->rating) }}
                                                        <span class="opacity-60 fs-14">({{ $seller->num_of_reviews }}
                                                            {{ translate('Reviews') }})</span>
                                                    </div>
                                                    <!-- Visit Button -->
                                                    <a href="{{ route('shop.visit', $seller->slug) }}"
                                                        class="btn-visit">
                                                        <span class="circle" aria-hidden="true">
                                                            <span class="icon arrow"></span>
                                                        </span>
                                                        <span class="button-text">{{ translate('Visit Store') }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @endif
                @endif


            </div>
        </div>


        <div class="bannerBody">
            <div class="smallBannerAds row d-flex flex-nowrap justify-content-between">
                <div class="bannerContainerChild col-4">
                    <img class="imageBannerAds w-100 img-fit"
                        src="{{ static_asset('assets/img/bannerBody/sale 1.png') }}" alt="">
                    <div class="payMoneyAds">
                        <span class="text-[10px]">Quảng cáo</span>
                    </div>
                </div>
                <div class="bannerContainerChild col-4">
                    <img class="imageBannerAds w-100 img-fit"
                        src="{{ static_asset('assets/img/bannerBody/sale 2.png') }}" alt="">
                    <div class="payMoneyAds">
                        <span class="text-[10px]">Quảng cáo</span>
                    </div>
                </div>
                <div class="bannerContainerChild col-4">
                    <img class="imageBannerAds w-100 img-fit"
                        src="{{ static_asset('assets/img/bannerBody/sale 5.png') }}" alt="">
                    <div class="payMoneyAds">
                        <span class="text-[10px]">Quảng cáo</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Top Brands -->
        <!--  @if (get_setting('top_brands') != null)
    <swiper-container class="top-brand-container  pt-2" init="true" loop="true" autoplay="true">
                                                    @foreach ($brands as $brand)
    <swiper-slide class="pb-4">
                                                            <div class="col py-2  text-center  hov-scale-img has-transition hov-shadow-out z-1"
                                                                style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;border-radius:15px;">
                                                                <a href="{{ route('products.brand', $brand->slug) }}" class="d-block p-sm-2">
                                                                    <img src="{{ isset($brand->brandLogo->file_name) ? my_asset($brand->brandLogo->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                                                        class="lazyload h-80px h-md-50px  mx-auto has-transition p-2 mw-100"
                                                                        alt="{{ $brand->getTranslation('name') }}"
                                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                                    <p class="text-center text-dark fs-11  fw-700">
                                                                        {{ $brand->getTranslation('name') }}
                                                                    </p>
                                                                </a>
                                                            </div>
                                                        </swiper-slide>
    @endforeach
                                                </swiper-container>
    @endif
                            -->

        <div class="productList ">
            <div class="row featured-product-list-product productListSlide product-sale-home-page ">
                @foreach (get_all_products() as $product)
                    @php
                        $product_url = route('product', $product->slug);
                    @endphp
                    <div class="featured__product-card product-hover position-relative  p-md-3 p-2   col-lg-2 col-md-3 col-6 d-flex flex-column justify-content-between"
                        style="gap:15px">
                        @if (discount_in_percentage($product) > 0)
                            <div class="product__badge position-absolute start-0 translate-middle rounded px-2"
                                style="top: 10px; left: 10px;">
                                <span class="fw-500 text-light">-{{ discount_in_percentage($product) }}%</span>
                            </div>
                        @endif

                        <img class="lazyload mx-auto img-fit has-transition h-150px"
                            src="{{ $product->thumbnail != null ? my_asset($product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                            alt="{{ $product->getTranslation('name') }}"
                            title="{{ $product->getTranslation('name') }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                        <div class="product__card-content d-flex flex-column">
                            <a href="{{ $product_url }}" class="product__card-title text-dark">
                                <h2 class="fs-14 fw-500 text-ellipsis-2">{{ $product->getTranslation('name') }}</h2>
                            </a>
                            @if (avg_start_rating($product->id) > 0)
                                <div class="product-rating my-1 d-flex align-items-center mb-2">
                                    <div class="star-icons d-flex align-items-center">
                                        <img width="20px" src="{{ static_asset('assets/img/star.svg') }}"
                                            alt="Star">
                                    </div>
                                    <div class="rating-count ml-1 text-sm font-semibold">
                                        {{ avg_start_rating($product->id) }}
                                    </div>
                                    <div class="numberReviews ml-3  flex items-center gap-1 d-flex align-items-center"
                                        style="gap:5px">
                                        <img width="20px" src="{{ static_asset('assets/img/chat.svg') }}"
                                            alt=""><span class="count__rate"> {{ count_review($product->id) }}
                                            đánh
                                            giá</span>
                                    </div>

                                </div>
                            @else
                                <div class="product-rating my-1 d-flex align-items-center mb-2">
                                    <span class="text-danger">Chưa có đánh giá</span>
                                </div>
                            @endif

                            <div class="price-and-cart d-flex flex-column justify-content-between mb-2">
                                <div class="price-info text-gray-600 d-flex align-items-center gap-3 d-flex "
                                    style="gap:10px;">
                                    {{-- <span class="new-price text-red-600 font-bold text-[24px] inline-block">400.000đ</span>
                                    <span class="old-price text-decoration-line-through">499.000đ</span> --}}

                                    @if (home_base_price($product) != home_discounted_base_price($product))
                                        <div class="disc-amount has-transition">
                                            <del
                                                class="old-price text-decoration-line-through">{{ $product->unit_price }}</del>
                                        </div>
                                    @endif
                                    <!-- price -->
                                    <div class="">
                                        <span
                                            class="new-price text-red-600 font-bold  inline-block">{{ home_discounted_base_price($product) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="cartContainerandOp d-flex align-items-center justify-content-between ">
                                <a @if (in_array($product->id, $cart_added)) active @endif" href="javascript:void(0)"
                                    @if (Auth::check()) onclick="showAddToCartModal({{ $product->id }})" @else onclick="showLoginModal()" @endif
                                    class="cart-icon btn__add-to-cart  h-40px d-flex justify-content-center align-items-center">
                                    <img src="{{ static_asset('assets/img/shopping-cart.svg') }}" alt="Shopping Cart">
                                </a>
                                <!-- add to cart -->

                                <div class="wishlistContainer d-flex  align-items-center " style="gap:10px;">
                                    <div class="wishlist-icon-container flex ">
                                        <a href="javascript:void(0)" class="hov-svg-white"
                                            onclick="addToWishList({{ $product->id }})" data-toggle="tooltip"
                                            data-title="Thêm vào mục ưa thích" data-placement="left">
                                            <img width="20px" class="w-5 h-5 transition transform hover:scale-110"
                                                src="{{ static_asset('assets/img/heart 2.svg') }}" alt="Wishlist"
                                                style="cursor: pointer;">
                                        </a>
                                    </div>
                                    <div class="wishlist-icon-container flex">
                                        <a href="javascript:void(0)" data-toggle="tooltip"
                                            data-title="Thêm vào mục so sánh" data-placement="left"
                                            onclick="addToCompare({{ $product->id }})">
                                            <img width="20px" class=" transition transform hover:scale-110"
                                                src="{{ static_asset('assets/img/chart.svg') }}" alt="Compare"
                                                style="cursor: pointer;">
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- -------------end list product --}}
                <!-- Top Sellers -->
                @if (get_setting('vendor_system_activation') == 1)
                    @php
                        $best_selers = get_best_sellers(5);
                    @endphp
                    @if (count($best_selers) > 0)
                        <section class="mb-2 mb-md-3 mt-2 mt-md-3">
                            <div class="container">
                                <!-- Top Section -->
                                <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                                    <!-- Title -->
                                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                                        <span class="pb-3">{{ translate('Top Sellers') }}</span>
                                    </h3>
                                    <!-- Links -->
                                    <div class="d-flex">
                                        <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                                            href="{{ route('sellers') }}">{{ translate('View All Sellers') }}</a>
                                    </div>
                                </div>
                                <!-- Sellers Section -->
                                <div class="aiz-carousel arrow-x-0 arrow-inactive-none" data-items="5" data-xxl-items="5"
                                    data-xl-items="4" data-lg-items="3.4" data-md-items="2.5" data-sm-items="2"
                                    data-xs-items="1.4" data-arrows="true" data-dots="false">
                                    @foreach ($best_selers as $key => $seller)
                                        @if ($seller->user != null)
                                            <div
                                                class="carousel-box h-100 position-relative text-center border-right border-top border-bottom @if ($key == 0) border-left @endif has-transition hov-animate-outline">
                                                <div class="position-relative px-3"
                                                    style="padding-top: 2rem; padding-bottom:2rem;">
                                                    <!-- Shop logo & Verification Status -->
                                                    <div class="position-relative mx-auto size-100px size-md-120px">
                                                        <a href="{{ route('shop.visit', $seller->slug) }}"
                                                            class="d-flex mx-auto justify-content-center align-item-center size-100px size-md-120px border overflow-hidden hov-scale-img"
                                                            tabindex="0"
                                                            style="border: 1px solid #e5e5e5; border-radius: 50%; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.06);">
                                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                                data-src="{{ uploaded_asset($seller->logo) }}"
                                                                alt="{{ $seller->name }}"
                                                                class="img-fit lazyload has-transition"
                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                                        </a>
                                                        <div
                                                            class="absolute-top-right z-1 mr-md-2 mt-1 rounded-content bg-white">
                                                            @if ($seller->verification_status == 1)
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24.001"
                                                                    height="24" viewBox="0 0 24.001 24">
                                                                    <g id="Group_25929" data-name="Group 25929"
                                                                        transform="translate(-480 -345)">
                                                                        <circle id="Ellipse_637" data-name="Ellipse 637"
                                                                            cx="12" cy="12" r="12"
                                                                            transform="translate(480 345)"
                                                                            fill="#fff" />
                                                                        <g id="Group_25927" data-name="Group 25927"
                                                                            transform="translate(480 345)">
                                                                            <path id="Union_5" data-name="Union 5"
                                                                                d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z"
                                                                                transform="translate(0 0)"
                                                                                fill="#3490f3" />
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24.001"
                                                                    height="24" viewBox="0 0 24.001 24">
                                                                    <g id="Group_25929" data-name="Group 25929"
                                                                        transform="translate(-480 -345)">
                                                                        <circle id="Ellipse_637" data-name="Ellipse 637"
                                                                            cx="12" cy="12" r="12"
                                                                            transform="translate(480 345)"
                                                                            fill="#fff" />
                                                                        <g id="Group_25927" data-name="Group 25927"
                                                                            transform="translate(480 345)">
                                                                            <path id="Union_5" data-name="Union 5"
                                                                                d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z"
                                                                                transform="translate(0 0)"
                                                                                fill="red" />
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <!-- Shop name -->
                                                    <h2
                                                        class="fs-14 fw-700 text-dark text-truncate-2 h-40px mt-3 mt-md-4 mb-0 mb-md-3">
                                                        <a href="{{ route('shop.visit', $seller->slug) }}"
                                                            class="text-reset hov-text-primary"
                                                            tabindex="0">{{ $seller->name }}</a>
                                                    </h2>
                                                    <!-- Shop Rating -->
                                                    <div class="rating rating-mr-1 text-dark mb-3">
                                                        {{ renderStarRating($seller->rating) }}
                                                        <span class="opacity-60 fs-14">({{ $seller->num_of_reviews }}
                                                            {{ translate('Reviews') }})</span>
                                                    </div>
                                                    <!-- Visit Button -->
                                                    <a href="{{ route('shop.visit', $seller->slug) }}"
                                                        class="btn-visit">
                                                        <span class="circle" aria-hidden="true">
                                                            <span class="icon arrow"></span>
                                                        </span>
                                                        <span class="button-text">{{ translate('Visit Store') }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
