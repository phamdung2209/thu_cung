    <!-- Top Bar Banner -->
    @php
        $topbar_banner = get_setting('topbar_banner');
        $topbar_banner_medium = get_setting('topbar_banner_medium');
        $topbar_banner_small = get_setting('topbar_banner_small');
        $topbar_banner_asset = uploaded_asset($topbar_banner);
    @endphp
    @if ($topbar_banner != null)
        <div class="position-relative top-banner removable-session z-1035 d-none" data-key="top-banner"
            data-value="removed">
            <a href="{{ get_setting('topbar_banner_link') }}" class="d-block text-reset h-40px h-lg-60px">
                <!-- For Large device -->
                <img src="{{ $topbar_banner_asset }}" class="d-none d-xl-block img-fit h-100"
                    alt="{{ translate('topbar_banner') }}">
                <!-- For Medium device -->
                <img src="{{ $topbar_banner_medium != null ? uploaded_asset($topbar_banner_medium) : $topbar_banner_asset }}"
                    class="d-none d-md-block d-xl-none img-fit h-100" alt="{{ translate('topbar_banner') }}">
                <!-- For Small device -->
                <img src="{{ $topbar_banner_small != null ? uploaded_asset($topbar_banner_small) : $topbar_banner_asset }}"
                    class="d-md-none img-fit h-100" alt="{{ translate('topbar_banner') }}">
            </a>
            <button class="btn text-white h-100 absolute-top-right set-session" data-key="top-banner"
                data-value="removed" data-toggle="remove-parent" data-parent=".top-banner">
                <i class="la la-close la-2x"></i>
            </button>
        </div>
    @endif
    <!-- Top Bar -->
    <div class="top-navbar bg-white z-1035 h-35px h-sm-auto container">
        <div class="container">
            <div class="d-flex justify-content-between">
                <ul
                    class="serviceTop--left list-inline d-flex justify-content-between align-item-center justify-content-lg-start mb-0">
                    <!-- Currency Switcher -->
                    @if (get_setting('show_currency_switcher') == 'on')
                        <li class="list-inline-item dropdown ml-auto ml-lg-0 mr-0 d-flex align-items-center" id="currency-change">
                            @php
                                $system_currency = get_system_currency();
                            @endphp

                            <a href="javascript:void(0)"
                                class="dropdown-toggle text-secondary fs-14 font-weight-bold py-2"
                                data-toggle="dropdown" data-display="static">
                                {{ $system_currency->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                @foreach (get_all_active_currency() as $key => $currency)
                                    <li>
                                        <a class="dropdown-item @if ($system_currency->code == $currency->code) active @endif"
                                            href="javascript:void(0)"
                                            data-currency="{{ $currency->code }}">{{ $currency->name }}
                                            ({{ $currency->symbol }})
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    <!-- Language switcher -->
                    <!-- @if (get_setting('show_language_switcher') == 'on')
<li class="list-inline-item dropdown mr-4" id="lang-change">
                                
                                <a href="javascript:void(0)" class="dropdown-toggle text-secondary fs-12 py-2"
                                    data-toggle="dropdown" data-display="static">
                                    <span class="">{{ $system_language->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    @foreach (get_all_active_language() as $key => $language)
<li>
                                            <a href="javascript:void(0)" data-flag="{{ $language->code }}"
                                                class="dropdown-item @if ($system_language->code == $language->code) active @endif">
                                                <img src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ static_asset('assets/img/flags/' . $language->code . '.png') }}"
                                                    class="mr-1 lazyload" alt="{{ $language->name }}" height="11">
                                                <span class="language">{{ $language->name }}</span>
                                            </a>
                                        </li>
@endforeach
                                </ul>
                            </li>
@endif -->
                    <div class="choooseLocationContainer d-flex align-items-center justify-content-between"
                        style="gap:4px;">
                        <div class="choose-location--header d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                class="ga28-a0 ga28-a1 d-block" style="color: rgb(0, 26, 52); width: 20px">
                                <path fill="currentColor" d="M8 9a2 2 0 1 0 0-4 2 2 0 0 0 0 4"></path>
                                <path fill="currentColor"
                                    d="M8 0a7 7 0 0 0-7 7c0 2.91 1.713 5.148 3.285 6.596a16 16 0 0 0 2.945 2.13c.155.085.32.172.406.205a1 1 0 0 0 .728 0c.086-.033.25-.12.406-.206a16 16 0 0 0 2.945-2.13C13.287 12.149 15 9.91 15 7a7 7 0 0 0-7-7M3 7a5 5 0 0 1 10 0c0 2.09-1.237 3.833-2.64 5.125A14 14 0 0 1 8 13.863a14 14 0 0 1-2.36-1.738C4.237 10.833 3 9.09 3 7">
                                </path>
                            </svg>
                            <h4 class="choose-location-text font-weight-bold fs-13 mb-0 text-nowrap">Hà Nội, Việt Nam</h4>
                        </div>
                        <span class="d-none d-md-flex">•</span>
                        <div class="chooseLocationDelivery dropdown d-none d-md-flex align-items-center ">
                            <h4 class="chooseLocationDeliveryText fs-13 font-weight-bold m-0 p-0 text-nowrap">Nhập địa chỉ giao hàng
                                của bạn</h4>

                        </div>
                    </div>
                </ul>

                <div class="serviceTop--right d-flex align-items-center serviceTop-menu">
                    <div class="d-xl-none d-block nav-btn-menu">
                        <svg id="Component_43_1" data-name="Component 43 – 1" xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" viewBox="0 0 16 16">
                            <rect id="Rectangle_19062" data-name="Rectangle 19062" width="16" height="2"
                                transform="translate(0 7)" fill="#919199" />
                            <rect id="Rectangle_19063" data-name="Rectangle 19063" width="16" height="2"
                                fill="#919199" />
                            <rect id="Rectangle_19064" data-name="Rectangle 19064" width="16" height="2"
                                transform="translate(0 14)" fill="#919199" />
                        </svg>
                    </div>

                    <div class="nav-menu">
                        <a href="#">Thú Cưng cho doanh nghiệp</a>
                        <a href="#">Ứng dụng di động</a>
                        <a href="#">Bán trên thú cưng</a>
                        <a href="#">Kiếm tiền với thú cưng</a>
                        <a href="#">Phiếu quà tặng</a>
                        <a href="#">Giúp đỡ</a>
                    </div>

                    <ul class="serviceTop--menu d-xl-flex d-none align-items-center mb-0">
                        <li><a href="#" class="text-nowrap">Thú Cưng cho doanh nghiệp</a></li>
                        <li><a href="#" class="text-nowrap">Ứng dụng di động</a></li>
                        <li><a href="#" class="text-nowrap">Bán trên thú cưng</a></li>
                        <li><a href="#" class="text-nowrap">Kiếm tiền với thú cưng</a></li>
                        <li><a href="#" class="text-nowrap">Phiếu quà tặng</a></li>
                        <li><a href="#" class="text-nowrap">Giúp đỡ</a></li>
                    </ul>
                    
                </div>
                <!-- <div class="col-6 text-right d-none d-lg-block">
                    <ul class="list-inline mb-0 h-100 d-flex justify-content-end align-items-center">
                        @if (get_setting('vendor_system_activation') == 1)
-->
                <!-- Become a Seller -->
                <!-- <li class="list-inline-item mr-0 pl-0 py-2">
                                <a href="{{ route('shops.create') }}"
                                    class="text-secondary fs-12 pr-3 d-inline-block border-width-2 border-right">{{ translate('Become a Seller !') }}</a>
                            </li> -->
                <!-- Seller Login -->
                <!-- <li class="list-inline-item mr-0 pl-0 py-2">
                                <a href="{{ route('seller.login') }}"
                                    class="text-secondary fs-12 pl-3 d-inline-block">{{ translate('Login to Seller') }}</a>
                            </li>
@endif
                        @if (get_setting('helpline_number'))
-->
                <!-- Helpline -->
                <!-- <li class="list-inline-item ml-3 pl-3 mr-0 pr-0">
                                <a href="tel:{{ get_setting('helpline_number') }}"
                                    class="text-secondary fs-12 d-inline-block py-2">
                                    <span>{{ translate('Helpline') }}</span>
                                    <span>{{ get_setting('helpline_number') }}</span>
                                </a>
                            </li>
@endif
                    </ul>
                </div> -->
            </div>
        </div>
    </div>

    <header class="@if (get_setting('header_stikcy') == 'on') sticky-top @endif z-1020 bg-white container">
        <!-- Search Bar -->
        <div class="position-relative logo-bar-area border-md-nonea z-1025">
            <div class="container">
                <div class="d-flex align-items-center">
                    <!-- top menu sidebar button -->
                    <button type="button" class="btn d-lg-none mr-3 mr-sm-4 p-0 active" data-toggle="class-toggle"
                        data-target=".aiz-top-menu-sidebar">
                        <svg id="Component_43_1" data-name="Component 43 – 1" xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" viewBox="0 0 16 16">
                            <rect id="Rectangle_19062" data-name="Rectangle 19062" width="16" height="2"
                                transform="translate(0 7)" fill="#919199" />
                            <rect id="Rectangle_19063" data-name="Rectangle 19063" width="16" height="2"
                                fill="#919199" />
                            <rect id="Rectangle_19064" data-name="Rectangle 19064" width="16" height="2"
                                transform="translate(0 14)" fill="#919199" />
                        </svg>

                    </button>

                    <div class="menuPrimary mt-8 justify-content-between d-flex align-items-center h-50px w-100">
                        <!-- Header Logo -->
                        <div class="logo-main d-flex align-items-center ">
                            <a href="{{ route('home') }}">
                                @php
                                    $header_logo = get_setting('header_logo');
                                @endphp
                                @if ($header_logo != null)
                                    <!-- <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}"
                                        class="mw-50 h-30px h-md-40px logo" height="50"> -->
                                    <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}"
                                        class="mw-50 w-50px logo" height="50">
                                @else
                                    <!-- <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}"
                                        class="mw-50 h-30px h-md-40px logo" height="50"> -->
                                    <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}"
                                        class="mw-50 w-50px logo" height="50">
                                @endif
                            </a>
                            <h2 class="logo-main--text">Thú cưng</h2>
                        </div>

                        <div class="d-none d-lg-block position-relative bg-primary h-40px" style="border-radius:8px;">

                            <!-- Categoty Menu Button -->
                            <div class="d-none d-xl-block all-category has-transition bg-black-10"
                                id="category-menu-bar">

                                <div class="category-header--button d-flex  align-items-center hover:cursor-pointer ">
                                    <img class="category-header--icon"
                                        src="{{ static_asset('assets/img/danhmucicon.svg') }}" alt="" />
                                    <span class="fw-700 fs-14 text-white"
                                        style="padding-top:2px;">{{ translate('Danh mục') }}</span>
                                    <!-- <a href="{{ route('categories.all') }}" class="text-reset"> -->
                                    <!-- <span class="d-none d-lg-inline-block text-white hov-opacity-80">({{ translate('See All') }})</span> -->

                                    <!-- </a> -->

                                    <!-- <i class="las la-angle-down text-white has-transition" id="category-menu-bar-icon"
                                                            style="font-size: 1.2rem !important"></i> -->
                                </div>

                            </div>
                            <!-- Category Menus -->
                            <div class="hover-category-menu position-absolute list-hidden-animation w-100 top-100 left-0 right-0 z-3 d-none"
                                id="click-category-menu">
                                <!-- <div class="container"> -->
                                <div class="d-flex position-relative">
                                    <div class="position-static">
                                        @include(
                                            'frontend.' .
                                                get_setting('homepage_select') .
                                                '.partials.category_menu')
                                    </div>
                                </div>
                                <!-- </div> -->
                            </div>




                        </div>



                        <!-- Search Icon for small device -->
                        <div class="d-lg-none ml-auto mr-0">
                            <a class="p-2 d-block text-reset" href="javascript:void(0);" data-toggle="class-toggle"
                                data-target=".front-header-search">
                                <i class="las la-search la-flip-horizontal la-2x"></i>
                            </a>
                        </div>
                        <!-- Search field -->
                        <div class="flex-grow-1 front-header-search d-flex align-items-center bg-white">
                            <div class="position-relative flex-grow-1 px-3 px-lg-0">
                                <form action="{{ route('search') }}" method="GET" class="stop-propagation">
                                    <div class="d-flex position-relative align-items-center">
                                        <div class="d-lg-none" data-toggle="class-toggle"
                                            data-target=".front-header-search">
                                            <button class="btn px-2" type="button"><i
                                                    class="la la-2x la-long-arrow-left"></i></button>
                                        </div>
                                        <div class="search-input-box d-flex rounded-2 search-wrapper gap-2">
                                            <!-- dropdown -->
                                            <div class="flex-grow-1 d-flex align-items-center bg-white rounded-search">
                                                <div class="dropdown mr-2">
                                                    <button
                                                        class="btn dropdown-toggle dropdown-btn px-1 py-1 accordion d-flex align-items-center"
                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        Tất cả
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="#">Sản phẩm</a>
                                                        <a class="dropdown-item" href="#">Dịch vụ</a>
                                                    </div>
                                                </div>
                                                <input type="text" class="fs-14 f-15 search-input rounded-3"
                                                    id="search" name="keyword"
                                                    @isset($query)
                                                    value="{{ $query }}"
                                                @endisset
                                                    placeholder="{{ translate('Tìm từ khóa...') }}"
                                                    autocomplete="off">
                                            </div>

                                            <div
                                                class="position-relative search-btn d-flex align-items-center justify-content-center">
                                                <svg id="Group_723" data-name="Group 723"
                                                    class="position-relative text-white"
                                                    xmlns="http://www.w3.org/2000/svg" width="20.001"
                                                    height="20"viewBox="0 0 20.001 20" fill="currentColor">
                                                    <path id="Path_3090" data-name="Path 3090"
                                                        d="M9.847,17.839a7.993,7.993,0,1,1,7.993-7.993A8,8,0,0,1,9.847,17.839Zm0-14.387a6.394,6.394,0,1,0,6.394,6.394A6.4,6.4,0,0,0,9.847,3.453Z"
                                                        transform="translate(-1.854 -1.854)" fill="currentColor" />
                                                    <path id="Path_3091" data-name="Path 3091"
                                                        d="M24.4,25.2a.8.8,0,0,1-.565-.234l-6.15-6.15a.8.8,0,0,1,1.13-1.13l6.15,6.15A.8.8,0,0,1,24.4,25.2Z"
                                                        transform="translate(-5.2 -5.2)" fill="currentColor" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100"
                                    style="min-height: 200px">
                                    <div class="search-preloader absolute-top-center">
                                        <div class="dot-loader">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                    <div class="search-nothing d-none p-3 text-center fs-16">

                                    </div>
                                    <div id="search-content" class="text-left">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Search box -->
                        <div class="d-none d-lg-none ml-3 mr-0">
                            <div class="nav-search-box">
                                <a href="#" class="nav-box-link">
                                    <i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>
                                </a>
                            </div>
                        </div>
                        {{-- <div class="d-none d-lg-block ml-3 mr-0">
                            <div class="" id="compare">
                                @include('frontend.' . get_setting('homepage_select') . '.partials.compare')
                            </div>
                        </div>
                        <div class="d-none d-lg-block mr-3" style="margin-left: 36px;">
                            <div class="" id="wishlist">
                                @include('frontend.' . get_setting('homepage_select') . '.partials.wishlist')
                            </div>
                        </div> --}}

                        <a href="{{ route('purchase_history.index') }}"
                            class="trackingOrder menuRightHeader d-flex flex-column justify-content-center align-items-center item-hover">
                            <img class="iconNavRight hidden-list-icon"
                                src="{{ static_asset('assets/img/iconDonHang.svg') }}" alt="">
                            <img class="iconNavRight red-list-icon"
                                src="{{ static_asset('assets/img/iconDonHangDo.svg') }}" alt="">
                            <span class="textNavRight text-nowrap">Đơn hàng</span>
                        </a>
                        @if (!isAdmin())
                            <!-- Notifications -->
                            <ul class="list-inline mb-0 h-100 d-none d-xl-flex justify-content-end align-items-center">
                                <li class="list-inline-item  pl-0 dropdown">
                                    <a class="notify menuRightHeader dropdown-toggle no-arrow  d-flex flex-column justify-content-center align-items-center"
                                        data-toggle="dropdown" href="javascript:void(0);" role="button"
                                        aria-haspopup="false" aria-expanded="false">

                                        <span class="position-relative d-inline-block">

                                            <img class="hidden-notify-icon"
                                                src="{{ static_asset('assets/img/iconThongBao.svg') }}"
                                                alt="">
                                            <img class="red-notify-icon"
                                                src="{{ static_asset('assets/img/iconThongBaoDo.svg') }}"
                                                alt="">
                                            @if (Auth::check() && count($user->unreadNotifications) > 0)
                                                <span
                                                    class="badge badge-primary badge-inline badge-pill absolute-top-right--10px">{{ count($user->unreadNotifications) }}</span>
                                            @endif
                                        </span>
                                        <span class="textNavRight">Thông báo</span>
                                    </a>

                                    @auth
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg py-0 rounded-0">
                                            <div class="p-3 bg-light border-bottom">
                                                <h6 class="mb-0">{{ translate('Notifications') }}</h6>
                                            </div>
                                            <div class="px-3 c-scrollbar-light overflow-auto " style="max-height:300px;">
                                                <ul class="list-group list-group-flush">
                                                    @forelse($user->unreadNotifications as $notification)
                                                        <li class="list-group-item">
                                                            @if ($notification->type == 'App\Notifications\OrderNotification')
                                                                @if ($user->user_type == 'customer')
                                                                    <a href="{{ route('purchase_history.details', encrypt($notification->data['order_id'])) }}"
                                                                        class="text-secondary fs-12">
                                                                        <span class="ml-2">
                                                                            {{ translate('Order code: ') }}
                                                                            {{ $notification->data['order_code'] }}
                                                                            {{ translate('has been ' . ucfirst(str_replace('_', ' ', $notification->data['status']))) }}
                                                                        </span>
                                                                    </a>
                                                                @elseif ($user->user_type == 'seller')
                                                                    <a href="{{ route('seller.orders.show', encrypt($notification->data['order_id'])) }}"
                                                                        class="text-secondary fs-12">
                                                                        <span class="ml-2">
                                                                            {{ translate('Order code: ') }}
                                                                            {{ $notification->data['order_code'] }}
                                                                            {{ translate('has been ' . ucfirst(str_replace('_', ' ', $notification->data['status']))) }}
                                                                        </span>
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        </li>
                                                    @empty
                                                        <li class="list-group-item">
                                                            <div class="py-4 text-center fs-16">
                                                                {{ translate('No notification found') }}
                                                            </div>
                                                        </li>
                                                    @endforelse
                                                </ul>
                                            </div>

                                            <div class="text-center border-top">
                                                <a href="{{ route('all-notifications') }}"
                                                    class="text-secondary fs-12 d-block py-2">
                                                    {{ translate('View All Notifications') }}
                                                </a>
                                            </div>
                                        </div>
                                    @endauth
                                </li>
                            </ul>
                        @endif


                        <!-- Cart -->
                        <div class="d-none d-xl-block  mr-0 has-transition mb-1 ml-2" data-hover="dropdown">
                            <div class="nav-cart-box dropdown h-100" id="cart_items" style="width: max-content;">
                                @include('frontend.' . get_setting('homepage_select') . '.partials.cart')
                            </div>
                        </div>
                        <div class="d-none d-xl-block ml-auto">
                            @auth
                                <span
                                    class="d-flex flex-column align-items-center justify-content-center nav-user-info py-20px @if (isAdmin()) ml-5 @endif"
                                    id="nav-user-info">
                                    <!-- Image -->
                                    <span
                                        class="size-30px rounded-circle overflow-hidden border border-transparent nav-user-img">
                                        @if ($user->avatar_original != null)
                                            <img src="{{ $user_avatar }}" class="img-fit h-100"
                                                style="object-fit:cover;object-position:center; "
                                                alt="{{ translate('avatar') }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                        @else
                                            <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image"
                                                alt="{{ translate('avatar') }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                        @endif
                                    </span>
                                    <!-- Name -->
                                    <h4 class="h5 fs-12 fw-700 text-dark ml-2 mb-0">{{ $user->name }}</h4>
                                </span>
                            @else
                                <!--Login & Registration -->
                                <a href="{{ route('user.login') }}" class="account-nav">


                                    <span
                                        class="menuRightHeader d-flex flex-column justify-content-center align-items-center nav-user-info">
                                        <!-- Image -->
                                        <span
                                            class="size-20px iconNavRight rounded-circle overflow-hidden  d-flex align-items-center justify-content-center nav-user-img">
                                            <!-- <svg xmlns="http://www.w3.org/2000/svg" width="19.902" height="20.012"
                                                    viewBox="0 0 19.902 20.012">
                                                    <path id="fe2df171891038b33e9624c27e96e367"
                                                        d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1.006,1.006,0,1,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1,10,10,0,0,0-6.25-8.19ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z"
                                                        transform="translate(-2.064 -1.995)" fill="#91919b" />
                                                </svg> -->
                                            <img id="fe2df171891038b33e9624c27e96e367" class="hidden-account-icon"
                                                src="{{ static_asset('assets/img/iconTaiKhoan.png') }}" alt="">
                                            <img id="fe2df171891038b33e9624c27e96e367" class="red-account-icon"
                                                src="{{ static_asset('assets/img/iconTaiKhoanDo.svg') }}" alt="">
                                        </span>
                                        <span class="textNavRight">Tài khoản</span>

                                        <!-- <a href="{{ route('user.login') }}"
                                                class="text-reset opacity-60 hov-opacity-100 hov-text-primary fs-12 d-inline-block border-right border-soft-light border-width-2 pr-2 ml-3">{{ translate('Login') }}</a> -->
                                        <!-- <a href="{{ route('user.registration') }}"
                                                class="text-reset opacity-60 hov-opacity-100 hov-text-primary fs-12 d-inline-block py-2 pl-2">{{ translate('Registration') }}</a> -->
                                    </span>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loged in user Menus -->
            <div class="hover-user-top-menu position-absolute top-100 left-0 right-0 z-3">
                <div class="container">
                    <div class="position-static float-right">
                        <div class="aiz-user-top-menu bg-white rounded-0 border-top shadow-sm" style="width:220px;">
                            <ul class="list-unstyled no-scrollbar mb-0 text-left">
                                @if (isAdmin())
                                    <li class="user-top-nav-element border border-top-0" data-id="1">
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 16 16">
                                                <path id="Path_2916" data-name="Path 2916"
                                                    d="M15.3,5.4,9.561.481A2,2,0,0,0,8.26,0H7.74a2,2,0,0,0-1.3.481L.7,5.4A2,2,0,0,0,0,6.92V14a2,2,0,0,0,2,2H14a2,2,0,0,0,2-2V6.92A2,2,0,0,0,15.3,5.4M10,15H6V9A1,1,0,0,1,7,8H9a1,1,0,0,1,1,1Zm5-1a1,1,0,0,1-1,1H11V9A2,2,0,0,0,9,7H7A2,2,0,0,0,5,9v6H2a1,1,0,0,1-1-1V6.92a1,1,0,0,1,.349-.76l5.74-4.92A1,1,0,0,1,7.74,1h.52a1,1,0,0,1,.651.24l5.74,4.92A1,1,0,0,1,15,6.92Z"
                                                    fill="#b5b5c0" />
                                            </svg>
                                            <span
                                                class="user-top-menu-name has-transition ml-3">{{ translate('Dashboard') }}</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="user-top-nav-element border border-top-0" data-id="1">
                                        <a href="{{ route('dashboard') }}"
                                            class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 16 16">
                                                <path id="Path_2916" data-name="Path 2916"
                                                    d="M15.3,5.4,9.561.481A2,2,0,0,0,8.26,0H7.74a2,2,0,0,0-1.3.481L.7,5.4A2,2,0,0,0,0,6.92V14a2,2,0,0,0,2,2H14a2,2,0,0,0,2-2V6.92A2,2,0,0,0,15.3,5.4M10,15H6V9A1,1,0,0,1,7,8H9a1,1,0,0,1,1,1Zm5-1a1,1,0,0,1-1,1H11V9A2,2,0,0,0,9,7H7A2,2,0,0,0,5,9v6H2a1,1,0,0,1-1-1V6.92a1,1,0,0,1,.349-.76l5.74-4.92A1,1,0,0,1,7.74,1h.52a1,1,0,0,1,.651.24l5.74,4.92A1,1,0,0,1,15,6.92Z"
                                                    fill="#b5b5c0" />
                                            </svg>
                                            <span
                                                class="user-top-menu-name has-transition ml-3">{{ translate('Dashboard') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (isCustomer())
                                    <li class="user-top-nav-element border border-top-0" data-id="1">
                                        <a href="{{ route('purchase_history.index') }}"
                                            class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 16 16">
                                                <g id="Group_25261" data-name="Group 25261"
                                                    transform="translate(-27.466 -542.963)">
                                                    <path id="Path_2953" data-name="Path 2953"
                                                        d="M14.5,5.963h-4a1.5,1.5,0,0,0,0,3h4a1.5,1.5,0,0,0,0-3m0,2h-4a.5.5,0,0,1,0-1h4a.5.5,0,0,1,0,1"
                                                        transform="translate(22.966 537)" fill="#b5b5bf" />
                                                    <path id="Path_2954" data-name="Path 2954"
                                                        d="M12.991,8.963a.5.5,0,0,1,0-1H13.5a2.5,2.5,0,0,1,2.5,2.5v10a2.5,2.5,0,0,1-2.5,2.5H2.5a2.5,2.5,0,0,1-2.5-2.5v-10a2.5,2.5,0,0,1,2.5-2.5h.509a.5.5,0,0,1,0,1H2.5a1.5,1.5,0,0,0-1.5,1.5v10a1.5,1.5,0,0,0,1.5,1.5h11a1.5,1.5,0,0,0,1.5-1.5v-10a1.5,1.5,0,0,0-1.5-1.5Z"
                                                        transform="translate(27.466 536)" fill="#b5b5bf" />
                                                    <path id="Path_2955" data-name="Path 2955"
                                                        d="M7.5,15.963h1a.5.5,0,0,1,.5.5v1a.5.5,0,0,1-.5.5h-1a.5.5,0,0,1-.5-.5v-1a.5.5,0,0,1,.5-.5"
                                                        transform="translate(23.966 532)" fill="#b5b5bf" />
                                                    <path id="Path_2956" data-name="Path 2956"
                                                        d="M7.5,21.963h1a.5.5,0,0,1,.5.5v1a.5.5,0,0,1-.5.5h-1a.5.5,0,0,1-.5-.5v-1a.5.5,0,0,1,.5-.5"
                                                        transform="translate(23.966 529)" fill="#b5b5bf" />
                                                    <path id="Path_2957" data-name="Path 2957"
                                                        d="M7.5,27.963h1a.5.5,0,0,1,.5.5v1a.5.5,0,0,1-.5.5h-1a.5.5,0,0,1-.5-.5v-1a.5.5,0,0,1,.5-.5"
                                                        transform="translate(23.966 526)" fill="#b5b5bf" />
                                                    <path id="Path_2958" data-name="Path 2958"
                                                        d="M13.5,16.963h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1"
                                                        transform="translate(20.966 531.5)" fill="#b5b5bf" />
                                                    <path id="Path_2959" data-name="Path 2959"
                                                        d="M13.5,22.963h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1"
                                                        transform="translate(20.966 528.5)" fill="#b5b5bf" />
                                                    <path id="Path_2960" data-name="Path 2960"
                                                        d="M13.5,28.963h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1"
                                                        transform="translate(20.966 525.5)" fill="#b5b5bf" />
                                                </g>
                                            </svg>
                                            <span
                                                class="user-top-menu-name has-transition ml-3">{{ translate('Purchase History') }}</span>
                                        </a>
                                    </li>
                                    <li class="user-top-nav-element border border-top-0" data-id="1">
                                        <a href="{{ route('digital_purchase_history.index') }}"
                                            class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16.001" height="16"
                                                viewBox="0 0 16.001 16">
                                                <g id="Group_25262" data-name="Group 25262"
                                                    transform="translate(-1388.154 -562.604)">
                                                    <path id="Path_2963" data-name="Path 2963"
                                                        d="M77.864,98.69V92.1a.5.5,0,1,0-1,0V98.69l-1.437-1.437a.5.5,0,0,0-.707.707l1.851,1.852a1,1,0,0,0,.707.293h.172a1,1,0,0,0,.707-.293l1.851-1.852a.5.5,0,0,0-.7-.713Z"
                                                        transform="translate(1318.79 478.5)" fill="#b5b5bf" />
                                                    <path id="Path_2964" data-name="Path 2964"
                                                        d="M67.155,88.6a3,3,0,0,1-.474-5.963q-.009-.089-.015-.179a5.5,5.5,0,0,1,10.977-.718,3.5,3.5,0,0,1-.989,6.859h-1.5a.5.5,0,0,1,0-1l1.5,0a2.5,2.5,0,0,0,.417-4.967.5.5,0,0,1-.417-.5,4.5,4.5,0,1,0-8.908.866.512.512,0,0,1,.009.121.5.5,0,0,1-.52.479,2,2,0,1,0-.162,4l.081,0h2a.5.5,0,0,1,0,1Z"
                                                        transform="translate(1324 486)" fill="#b5b5bf" />
                                                </g>
                                            </svg>
                                            <span
                                                class="user-top-menu-name has-transition ml-3">{{ translate('Downloads') }}</span>
                                        </a>
                                    </li>
                                    @if (get_setting('conversation_system') == 1)
                                        <li class="user-top-nav-element border border-top-0" data-id="1">
                                            <a href="{{ route('conversations.index') }}"
                                                class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 16 16">
                                                    <g id="Group_25263" data-name="Group 25263"
                                                        transform="translate(1053.151 256.688)">
                                                        <path id="Path_3012" data-name="Path 3012"
                                                            d="M134.849,88.312h-8a2,2,0,0,0-2,2v5a2,2,0,0,0,2,2v3l2.4-3h5.6a2,2,0,0,0,2-2v-5a2,2,0,0,0-2-2m1,7a1,1,0,0,1-1,1h-8a1,1,0,0,1-1-1v-5a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1Z"
                                                            transform="translate(-1178 -341)" fill="#b5b5bf" />
                                                        <path id="Path_3013" data-name="Path 3013"
                                                            d="M134.849,81.312h8a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h-.5a.5.5,0,0,0,0,1h.5a2,2,0,0,0,2-2v-5a2,2,0,0,0-2-2h-8a2,2,0,0,0-2,2v.5a.5.5,0,0,0,1,0v-.5a1,1,0,0,1,1-1"
                                                            transform="translate(-1182 -337)" fill="#b5b5bf" />
                                                        <path id="Path_3014" data-name="Path 3014"
                                                            d="M131.349,93.312h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1"
                                                            transform="translate(-1181 -343.5)" fill="#b5b5bf" />
                                                        <path id="Path_3015" data-name="Path 3015"
                                                            d="M131.349,99.312h5a.5.5,0,1,1,0,1h-5a.5.5,0,1,1,0-1"
                                                            transform="translate(-1181 -346.5)" fill="#b5b5bf" />
                                                    </g>
                                                </svg>
                                                <span
                                                    class="user-top-menu-name has-transition ml-3">{{ translate('Conversations') }}</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (get_setting('wallet_system') == 1)
                                        <li class="user-top-nav-element border border-top-0" data-id="1">
                                            <a href="{{ route('wallet.index') }}"
                                                class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="16"
                                                    height="16" viewBox="0 0 16 16">
                                                    <defs>
                                                        <clipPath id="clip-path1">
                                                            <rect id="Rectangle_1386" data-name="Rectangle 1386"
                                                                width="16" height="16" fill="#b5b5bf" />
                                                        </clipPath>
                                                    </defs>
                                                    <g id="Group_8102" data-name="Group 8102"
                                                        clip-path="url(#clip-path1)">
                                                        <path id="Path_2936" data-name="Path 2936"
                                                            d="M13.5,4H13V2.5A2.5,2.5,0,0,0,10.5,0h-8A2.5,2.5,0,0,0,0,2.5v11A2.5,2.5,0,0,0,2.5,16h11A2.5,2.5,0,0,0,16,13.5v-7A2.5,2.5,0,0,0,13.5,4M2.5,1h8A1.5,1.5,0,0,1,12,2.5V4H2.5a1.5,1.5,0,0,1,0-3M15,11H10a1,1,0,0,1,0-2h5Zm0-3H10a2,2,0,0,0,0,4h5v1.5A1.5,1.5,0,0,1,13.5,15H2.5A1.5,1.5,0,0,1,1,13.5v-9A2.5,2.5,0,0,0,2.5,5h11A1.5,1.5,0,0,1,15,6.5Z"
                                                            fill="#b5b5bf" />
                                                    </g>
                                                </svg>
                                                <span
                                                    class="user-top-menu-name has-transition ml-3">{{ translate('My Wallet') }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    <li class="user-top-nav-element border border-top-0" data-id="1">
                                        <a href="{{ route('support_ticket.index') }}"
                                            class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16.001"
                                                viewBox="0 0 16 16.001">
                                                <g id="Group_25259" data-name="Group 25259"
                                                    transform="translate(-316 -1066)">
                                                    <path id="Subtraction_184" data-name="Subtraction 184"
                                                        d="M16427.109,902H16420a8.015,8.015,0,1,1,8-8,8.278,8.278,0,0,1-1.422,4.535l1.244,2.132a.81.81,0,0,1,0,.891A.791.791,0,0,1,16427.109,902ZM16420,887a7,7,0,1,0,0,14h6.283c.275,0,.414,0,.549-.111s-.209-.574-.34-.748l0,0-.018-.022-1.064-1.6A6.829,6.829,0,0,0,16427,894a6.964,6.964,0,0,0-7-7Z"
                                                        transform="translate(-16096 180)" fill="#b5b5bf" />
                                                    <path id="Union_12" data-name="Union 12"
                                                        d="M16414,895a1,1,0,1,1,1,1A1,1,0,0,1,16414,895Zm.5-2.5V891h.5a2,2,0,1,0-2-2h-1a3,3,0,1,1,3.5,2.958v.54a.5.5,0,1,1-1,0Zm-2.5-3.5h1a.5.5,0,1,1-1,0Z"
                                                        transform="translate(-16090.998 183.001)" fill="#b5b5bf" />
                                                </g>
                                            </svg>
                                            <span
                                                class="user-top-menu-name has-transition ml-3">{{ translate('Support Ticket') }}</span>
                                        </a>
                                    </li>
                                @endif
                                <li class="user-top-nav-element border border-top-0" data-id="1">
                                    <a href="{{ route('logout') }}"
                                        class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15.999"
                                            viewBox="0 0 16 15.999">
                                            <g id="Group_25503" data-name="Group 25503"
                                                transform="translate(-24.002 -377)">
                                                <g id="Group_25265" data-name="Group 25265"
                                                    transform="translate(-216.534 -160)">
                                                    <path id="Subtraction_192" data-name="Subtraction 192"
                                                        d="M12052.535,2920a8,8,0,0,1-4.569-14.567l.721.72a7,7,0,1,0,7.7,0l.721-.72a8,8,0,0,1-4.567,14.567Z"
                                                        transform="translate(-11803.999 -2367)" fill="#d43533" />
                                                </g>
                                                <rect id="Rectangle_19022" data-name="Rectangle 19022" width="1"
                                                    height="8" rx="0.5" transform="translate(31.5 377)"
                                                    fill="#d43533" />
                                            </g>
                                        </svg>
                                        <span
                                            class="user-top-menu-name text-primary has-transition ml-3">{{ translate('Logout') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Bar -->
        <div class="d-none d-lg-block position-relative bg-white h-50px">
            <div class="container h-100 ">
                <div class="d-flex h-100">
                    <!-- <div class="d-flex h-100"> -->
                    <!-- Categoty Menu Button -->
                    <!-- <div class="d-none d-xl-block all-category has-transition bg-black-10" id="category-menu-bar">
                                <div class="px-3 h-100"
                                    style="padding-top: 12px;padding-bottom: 12px; width:270px; cursor: pointer;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="fw-700 fs-16 text-white mr-3">{{ translate('Categories') }}</span>
                                            <a href="{{ route('categories.all') }}" class="text-reset">
                                                <span
                                                    class="d-none d-lg-inline-block text-white hov-opacity-80">({{ translate('See All') }})</span>
                                            </a>
                                        </div>
                                        <i class="las la-angle-down text-white has-transition" id="category-menu-bar-icon"
                                            style="font-size: 1.2rem !important"></i>
                                    </div>
                                </div>
                            </div> -->
                    <!-- Categoty Menus -->
                    <!-- <div class="hover-category-menu position-absolute list-hidden-animation w-100 top-100 left-0 right-0 z-3 d-none"
                                id="click-category-menu">
                                <div class="container">
                                    <div class="d-flex position-relative">
                                        <div class="position-static">
                                            @include(
                                                'frontend.' .
                                                    get_setting('homepage_select') .
                                                    '.partials.category_menu')
                                        </div>
                                    </div>
                                </div>
                            </div>   -->
                    <!-- </div> -->
                    <!-- Header Menus -->
                    @php
                        $nav_txt_color =
                            get_setting('header_nav_menu_text') == 'light' ||
                            get_setting('header_nav_menu_text') == null
                                ? 'text-dark'
                                : 'text-white';
                    @endphp
                    <div class="w-100 overflow-hidden">
                        <div
                            class="d-flex align-items-center justify-content-center justify-content-xl-start h-100 border-bottom">
                            <ul
                                class="menuMainNav list-inline mb-0 pl-0 hor-swipe c-scrollbar-light w-100 d-flex justify-content-between ">
                                @if (get_setting('header_menu_labels') != null)
                                    @foreach (json_decode(get_setting('header_menu_labels'), true) as $key => $value)
                                        <li class="list-inline-item mr-0 animate-underline-white">
                                            <a href="{{ json_decode(get_setting('header_menu_links'), true)[$key] }}"
                                                class="fs-14 py-3 d-inline-block fw-500 {{ $nav_txt_color }} header_menu_links
                                            @if (url()->current() == json_decode(get_setting('header_menu_links'), true)[$key]) active @endif">
                                                {{ translate($value) }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </header>

    <!-- Top Menu Sidebar -->
    <div class="aiz-top-menu-sidebar collapse-sidebar-wrap sidebar-xl sidebar-left d-lg-none z-1035">
        <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle"
            data-target=".aiz-top-menu-sidebar" data-same=".hide-top-menu-bar"></div>
        <div class="collapse-sidebar c-scrollbar-light text-left">
            <button type="button" class="btn btn-sm p-4 hide-top-menu-bar" data-toggle="class-toggle"
                data-target=".aiz-top-menu-sidebar">
                <i class="las la-times la-2x text-primary"></i>
            </button>
            @auth
                <span class="d-flex align-items-center nav-user-info pl-4">
                    <!-- Image -->
                    <span class="size-40px rounded-circle overflow-hidden border border-transparent nav-user-img">
                        @if ($user->avatar_original != null)
                            <img src="{{ $user_avatar }}" class="img-fit h-100" alt="{{ translate('avatar') }}"
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                        @else
                            <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image"
                                alt="{{ translate('avatar') }}"
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                        @endif
                    </span>
                    <!-- Name -->
                    <h4 class="h5 fs-14 fw-700 text-dark ml-2 mb-0">{{ $user->name }}</h4>
                </span>
            @else
                <!--Login & Registration -->
                <span class="d-flex align-items-center nav-user-info pl-4">
                    <!-- Image -->
                    <span
                        class="size-40px rounded-circle overflow-hidden border d-flex align-items-center justify-content-center nav-user-img">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19.902" height="20.012"
                            viewBox="0 0 19.902 20.012">
                            <path id="fe2df171891038b33e9624c27e96e367"
                                d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1.006,1.006,0,1,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1,10,10,0,0,0-6.25-8.19ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z"
                                transform="translate(-2.064 -1.995)" fill="#91919b" />
                        </svg>
                    </span>
                    <a href="{{ route('user.login') }}"
                        class="text-reset opacity-60 hov-opacity-100 hov-text-primary fs-12 d-inline-block border-right border-soft-light border-width-2 pr-2 ml-3">{{ translate('Login') }}</a>
                    <a href="{{ route('user.registration') }}"
                        class="text-reset opacity-60 hov-opacity-100 hov-text-primary fs-12 d-inline-block py-2 pl-2">{{ translate('Registration') }}</a>
                </span>
            @endauth
            <hr>
            <ul class="mb-0 pl-3 pb-3 h-100">
                @if (get_setting('header_menu_labels') != null)
                    @foreach (json_decode(get_setting('header_menu_labels'), true) as $key => $value)
                        <li class="mr-0">
                            <a href="{{ json_decode(get_setting('header_menu_links'), true)[$key] }}"
                                class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links
                            @if (url()->current() == json_decode(get_setting('header_menu_links'), true)[$key]) active @endif">
                                {{ translate($value) }}
                            </a>
                        </li>
                    @endforeach
                @endif
                @auth
                    @if (isAdmin())
                        <hr>
                        <li class="mr-0">
                            <a href="{{ route('admin.dashboard') }}"
                                class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links">
                                {{ translate('My Account') }}
                            </a>
                        </li>
                    @else
                        <hr>
                        <li class="mr-0">
                            <a href="{{ route('dashboard') }}"
                                class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links
                                {{ areActiveRoutes(['dashboard'], ' active') }}">
                                {{ translate('My Account') }}
                            </a>
                        </li>
                    @endif
                    @if (isCustomer())
                        <li class="mr-0">
                            <a href="{{ route('all-notifications') }}"
                                class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links
                                {{ areActiveRoutes(['all-notifications'], ' active') }}">
                                {{ translate('Notifications') }}
                            </a>
                        </li>
                        <li class="mr-0">
                            <a href="{{ route('wishlists.index') }}"
                                class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links
                                {{ areActiveRoutes(['wishlists.index'], ' active') }}">
                                {{ translate('Wishlist') }}
                            </a>
                        </li>
                        <li class="mr-0">
                            <a href="{{ route('compare') }}"
                                class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links
                                {{ areActiveRoutes(['compare'], ' active') }}">
                                {{ translate('Compare') }}
                            </a>
                        </li>
                    @endif
                    <hr>
                    <li class="mr-0">
                        <a href="{{ route('logout') }}"
                            class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-primary header_menu_links">
                            {{ translate('Logout') }}
                        </a>
                    </li>
                @endauth
            </ul>
            <br>
            <br>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script type="text/javascript">
            function show_order_details(order_id) {
                $('#order-details-modal-body').html(null);

                if (!$('#modal-size').hasClass('modal-lg')) {
                    $('#modal-size').addClass('modal-lg');
                }

                $.post('{{ route('orders.details') }}', {
                    _token: AIZ.data.csrf,
                    order_id: order_id
                }, function(data) {
                    $('#order-details-modal-body').html(data);
                    $('#order_details').modal();
                    $('.c-preloader').hide();
                    AIZ.plugins.bootstrapSelect('refresh');
                });
            }
        </script>
    @endsection
