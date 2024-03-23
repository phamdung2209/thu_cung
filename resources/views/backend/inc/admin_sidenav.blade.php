<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <a href="{{ route('admin.dashboard') }}" class="d-block text-left">
                @if(get_setting('system_logo_white') != null)
                    <img class="mw-100" src="{{ uploaded_asset(get_setting('system_logo_white')) }}" class="brand-icon" alt="{{ get_setting('site_name') }}">
                @else
                    <img class="mw-100" src="{{ static_asset('assets/img/logo.png') }}" class="brand-icon" alt="{{ get_setting('site_name') }}">
                @endif
            </a>
        </div>
        <div class="aiz-side-nav-wrap">
            <div class="px-3 mb-3 position-relative">
                <input class="form-control bg-transparent rounded-2 form-control-sm text-white fs-14" type="text" name="" placeholder="{{ translate('Search in menu') }}" id="menu-search" onkeyup="menuSearch()">
                <span class="absolute-top-right pr-3 mr-3" style="margin-top: 10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path id="search_FILL0_wght200_GRAD0_opsz20" d="M176.921-769.231l6.255-6.255a5.99,5.99,0,0,0,1.733.949,5.687,5.687,0,0,0,1.885.329,5.317,5.317,0,0,0,3.9-1.608,5.31,5.31,0,0,0,1.609-3.9,5.322,5.322,0,0,0-1.608-3.9,5.306,5.306,0,0,0-3.9-1.611,5.321,5.321,0,0,0-3.9,1.609,5.312,5.312,0,0,0-1.611,3.9,5.554,5.554,0,0,0,.35,1.946,6.043,6.043,0,0,0,.929,1.672l-6.255,6.255Zm9.874-5.82a4.51,4.51,0,0,1-3.317-1.352,4.51,4.51,0,0,1-1.352-3.317,4.51,4.51,0,0,1,1.352-3.317,4.51,4.51,0,0,1,3.317-1.352,4.51,4.51,0,0,1,3.317,1.352,4.51,4.51,0,0,1,1.352,3.317,4.51,4.51,0,0,1-1.352,3.317A4.51,4.51,0,0,1,186.8-775.051Z" transform="translate(-176.307 785.231)" fill="#4e5767"/>
                    </svg>
                </span>
            </div>
            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                
                {{-- Dashboard --}}
                @can('admin_dashboard')
                    <li class="aiz-side-nav-item">
                        <a href="{{route('admin.dashboard')}}" class="aiz-side-nav-link">
                            <div class="aiz-side-nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path id="_3d6902ec768df53cd9e274ca8a57e401" data-name="3d6902ec768df53cd9e274ca8a57e401" d="M18,12.286a1.715,1.715,0,0,0-1.714-1.714h-4a1.715,1.715,0,0,0-1.714,1.714v4A1.715,1.715,0,0,0,12.286,18h4A1.715,1.715,0,0,0,18,16.286Zm-8.571,0a1.715,1.715,0,0,0-1.714-1.714h-4A1.715,1.715,0,0,0,2,12.286v4A1.715,1.715,0,0,0,3.714,18h4a1.715,1.715,0,0,0,1.714-1.714Zm7.429,0v4a.57.57,0,0,1-.571.571h-4a.57.57,0,0,1-.571-.571v-4a.57.57,0,0,1,.571-.571h4a.57.57,0,0,1,.571.571Zm-8.571,0v4a.57.57,0,0,1-.571.571h-4a.57.57,0,0,1-.571-.571v-4a.57.57,0,0,1,.571-.571h4a.57.57,0,0,1,.571.571ZM9.429,3.714A1.715,1.715,0,0,0,7.714,2h-4A1.715,1.715,0,0,0,2,3.714v4A1.715,1.715,0,0,0,3.714,9.429h4A1.715,1.715,0,0,0,9.429,7.714Zm8.571,0A1.715,1.715,0,0,0,16.286,2h-4a1.715,1.715,0,0,0-1.714,1.714v4a1.715,1.715,0,0,0,1.714,1.714h4A1.715,1.715,0,0,0,18,7.714Zm-9.714,0v4a.57.57,0,0,1-.571.571h-4a.57.57,0,0,1-.571-.571v-4a.57.57,0,0,1,.571-.571h4a.57.57,0,0,1,.571.571Zm8.571,0v4a.57.57,0,0,1-.571.571h-4a.57.57,0,0,1-.571-.571v-4a.57.57,0,0,1,.571-.571h4a.57.57,0,0,1,.571.571Z" transform="translate(-2 -2)" fill="#575b6a" fill-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="aiz-side-nav-text">{{translate('Dashboard')}}</span>
                        </a>
                    </li>
                @endcan

                <!-- POS Addon-->
                @if (addon_is_activated('pos_system') && (auth()->user()->can('pos_manager') || auth()->user()->can('pos_configuration')))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <div class="aiz-side-nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13.79" height="16" viewBox="0 0 13.79 16">
                                    <g id="_371925cdd3f531725a9fa8f3ebf8fe9e" data-name="371925cdd3f531725a9fa8f3ebf8fe9e" transform="translate(-2.26 0)">
                                      <path id="Path_40673" data-name="Path 40673" d="M10.69,7H3.26a1.025,1.025,0,0,0-1,1V18.45a1.03,1.03,0,0,0,1,1.05h7.43a1.03,1.03,0,0,0,1.03-1.03V8A1.025,1.025,0,0,0,10.69,7ZM4.94,17.86H3.995v-.95H4.94Zm0-2.355H3.995v-.95H4.94Zm0-2.355H3.995V12.2H4.94Zm2.5,4.71H6.5v-.95h.955Zm0-2.355H6.5v-.95h.955Zm0-2.355H6.5V12.2h.955Zm2.5,4.71H8.99v-.95h.95Zm0-2.355H8.99v-.95h.95Zm0-2.355H8.99V12.2h.95Zm.325-3a.17.17,0,0,1-.165.17H3.835a.17.17,0,0,1-.165-.17V8.795a.165.165,0,0,1,.165-.165H10.13a.165.165,0,0,1,.165.165Zm5.09-1.45H15.13v9.09h.25a.67.67,0,0,0,.67-.67V9.375a.67.67,0,0,0-.695-.675Z" transform="translate(0 -3.5)" fill="#4e5767"/>
                                      <rect id="Rectangle_20842" data-name="Rectangle 20842" width="1.465" height="9.095" transform="translate(12.185 5.2)" fill="#4e5767"/>
                                      <rect id="Rectangle_20843" data-name="Rectangle 20843" width="0.63" height="9.095" transform="translate(14.06 5.2)" fill="#4e5767"/>
                                      <path id="Path_40674" data-name="Path 40674" d="M13.895.895a.89.89,0,0,0-.26-.635A.91.91,0,0,0,13,0a.895.895,0,0,0-.91.895v.53h1.79Zm-2.2,0a.76.76,0,0,1,0-.145.68.68,0,0,1,0-.1h.01A.5.5,0,0,1,11.755.5.43.43,0,0,1,11.79.4a1.2,1.2,0,0,1,.145-.26.5.5,0,0,1,.04-.055L12.045,0H7.995A.815.815,0,0,0,7.18.81V3.03h4.5Z" transform="translate(-2.46)" fill="#4e5767"/>
                                    </g>
                                </svg>
                            </div>
                            <span class="aiz-side-nav-text">{{translate('POS System')}}</span>
                            @if (env("DEMO_MODE") == "On")
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.001" viewBox="0 0 16 14.001" class="mx-2">
                                    <path id="Union_49" data-name="Union 49" d="M-19322,3342.5v-5a2.007,2.007,0,0,0-2-2v1.5a3,3,0,0,1-3,3h-4v-10h4a3,3,0,0,1,3,3v1.5a3,3,0,0,1,3,3v5a.506.506,0,0,1-.5.5A.5.5,0,0,1-19322,3342.5Zm-11-2V3339h-3a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v-7.5a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v11a.5.5,0,0,1-.5.5A.506.506,0,0,1-19333,3340.5Zm-3-7.5a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v2Z" transform="translate(19337 -3329)" fill="#f51350"/>
                                </svg>
                            @endif
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('pos_manager')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('poin-of-sales.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['poin-of-sales.index', 'poin-of-sales.create'])}}">
                                        <span class="aiz-side-nav-text">{{translate('POS Manager')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('pos_configuration')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('poin-of-sales.activation')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('POS Configuration')}}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                <!-- Product -->
                @canany(['add_new_product', 'show_all_products','show_in_house_products','show_seller_products','show_digital_products','product_bulk_import','product_bulk_export','view_product_categories', 'view_all_brands','view_product_attributes','view_colors','view_product_reviews'])
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <div class="aiz-side-nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="13.714" viewBox="0 0 16 13.714">
                                    <g id="Layer_2" data-name="Layer 2" transform="translate(-2 -4)">
                                      <path id="Path_40719" data-name="Path 40719" d="M17.429,4H2.571A.571.571,0,0,0,2,4.571V8a.571.571,0,0,0,.571.571h.571v8.571a.571.571,0,0,0,.571.571H16.286a.571.571,0,0,0,.571-.571V8.571h.571A.571.571,0,0,0,18,8V4.571A.571.571,0,0,0,17.429,4ZM15.714,16.571H4.286v-8H15.714Zm1.143-9.143H3.143V5.143H16.857Z" fill="#575b6a"/>
                                      <path id="Path_40720" data-name="Path 40720" d="M12.571,15.143H16A.571.571,0,0,0,16,14H12.571a.571.571,0,0,0,0,1.143Z" transform="translate(-4.286 -4.286)" fill="#575b6a"/>
                                    </g>
                                </svg>
                            </div>
                            <span class="aiz-side-nav-text">{{translate('Products')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <!--Submenu-->
                        <ul class="aiz-side-nav-list level-2">
                            @can('add_new_product')
                                <li class="aiz-side-nav-item">
                                    <a class="aiz-side-nav-link" href="{{route('products.create')}}">
                                        <span class="aiz-side-nav-text">{{translate('Add New product')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('show_all_products')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('products.all')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('All Products') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('show_in_house_products')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('products.admin')}}" class="aiz-side-nav-link {{ areActiveRoutes(['products.admin', 'products.admin.edit']) }}" >
                                        <span class="aiz-side-nav-text">{{ translate('In House Products') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('show_digital_products')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('digitalproducts.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['digitalproducts.index', 'digitalproducts.create', 'digitalproducts.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Digital Products') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @if(get_setting('vendor_system_activation') == 1)
                                @can('show_seller_products')
                                    {{-- <li class="aiz-side-nav-item">
                                        <a href="{{route('products.seller')}}" class="aiz-side-nav-link {{ areActiveRoutes(['products.seller', 'products.seller.edit']) }}">
                                            <span class="aiz-side-nav-text">{{ translate('Seller Products') }}</span>
                                        </a>
                                    </li> --}}
                                    <li class="aiz-side-nav-item">
                                        <a href="javascript:void(0);" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Seller Product')}}</span>
                                            <span class="aiz-side-nav-arrow"></span>
                                        </a>
                                        <ul class="aiz-side-nav-list level-3">
                                            <li class="aiz-side-nav-item">
                                                <a href="{{ route('products.seller','physical') }}" class="aiz-side-nav-link">
                                                    <span class="aiz-side-nav-text">{{translate('Physical Products')}}</span>
                                                </a>
                                            </li>
                                            <li class="aiz-side-nav-item">
                                                <a href="{{ route('products.seller','digital') }}" class="aiz-side-nav-link">
                                                    <span class="aiz-side-nav-text">{{translate('Digital Products')}}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endcan
                            @endif
                            
                            @can('product_bulk_import')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('product_bulk_upload.index') }}" class="aiz-side-nav-link" >
                                        <span class="aiz-side-nav-text">{{ translate('Bulk Import') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('product_bulk_export')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('product_bulk_export.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Bulk Export')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('view_product_categories')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('categories.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['categories.index', 'categories.create', 'categories.edit'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Category')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('view_all_brands')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('brands.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['brands.index', 'brands.create', 'brands.edit'])}}" >
                                        <span class="aiz-side-nav-text">{{translate('Brand')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('view_product_attributes')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('attributes.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['attributes.index','attributes.create','attributes.edit','attributes.show','edit-attribute-value'.''])}}">
                                        <span class="aiz-side-nav-text">{{translate('Attribute')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('view_colors')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('colors')}}" class="aiz-side-nav-link {{ areActiveRoutes(['colors','colors.edit'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Colors')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @canany(['view_size_charts', 'view_measurement_points'])
                                <li class="aiz-side-nav-item">
                                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Size Guide')}}</span>
                                        <span class="aiz-side-nav-arrow"></span>
                                    </a>
                                    <ul class="aiz-side-nav-list level-3">
                                        @can('view_size_charts')
                                        <li class="aiz-side-nav-item">
                                            <a href="{{ route('size-charts.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['size-charts.index', 'size-charts.create', 'size-charts.edit'])}}">
                                                <span class="aiz-side-nav-text">{{translate('Size Chart')}}</span>
                                            </a>
                                        </li>
                                        @endcan
                                        @can('view_measurement_points')
                                        <li class="aiz-side-nav-item">
                                            <a href="{{ route('measurement-points.index') }}" class="aiz-side-nav-link">
                                                <span class="aiz-side-nav-text">{{translate('Measurement Points')}}</span>
                                            </a>
                                        </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                            @can('view_product_reviews')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('reviews.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Product Reviews')}}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                <!-- Auction Product -->
                @if(addon_is_activated('auction'))
                    @canany(['add_auction_product','view_all_auction_products','view_inhouse_auction_products','view_seller_auction_products','view_auction_product_orders'])
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <div class="aiz-side-nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15.964" height="16" viewBox="0 0 15.964 16">
                                        <path id="_608087065a4e8d47000761280c315020" data-name="608087065a4e8d47000761280c315020" d="M4.993,20.456a.456.456,0,0,0,.456.456h8.389a.456.456,0,0,0,.456-.456V19.009a1.256,1.256,0,0,0-1.254-1.254h-.2V16.32a.456.456,0,0,0-.456-.456H6.9a.456.456,0,0,0-.456.456v1.435h-.2a1.255,1.255,0,0,0-1.254,1.254Zm2.363-3.68H11.93v.979H7.356ZM5.905,19.009a.342.342,0,0,1,.342-.342H13.04a.342.342,0,0,1,.342.342V20H5.905Zm13.717-1.79a1.405,1.405,0,0,0,1.334-1.4,1.411,1.411,0,0,0-.461-1.042l-4.466-4.009L17.6,9.031a.831.831,0,0,0-.06-1.172L14.513,5.127a.816.816,0,0,0-.6-.213.824.824,0,0,0-.574.272L8.27,10.8a.83.83,0,0,0,.059,1.173L11.354,14.7a.83.83,0,0,0,1.172-.06l1.622-1.795,4.464,4.008a1.392,1.392,0,0,0,1.011.361ZM13.779,11.9l0,0,0,0L11.9,13.972,9,11.35l4.961-5.492,2.9,2.622L13.779,11.9Zm.981.275.658-.728,4.466,4.008a.492.492,0,1,1-.661.728Z" transform="translate(-4.993 -4.912)" fill="#575b6a"/>
                                    </svg>
                                </div>
                                <span class="aiz-side-nav-text">{{translate('Auction Products')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.001" viewBox="0 0 16 14.001" class="mx-2">
                                        <path id="Union_49" data-name="Union 49" d="M-19322,3342.5v-5a2.007,2.007,0,0,0-2-2v1.5a3,3,0,0,1-3,3h-4v-10h4a3,3,0,0,1,3,3v1.5a3,3,0,0,1,3,3v5a.506.506,0,0,1-.5.5A.5.5,0,0,1-19322,3342.5Zm-11-2V3339h-3a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v-7.5a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v11a.5.5,0,0,1-.5.5A.506.506,0,0,1-19333,3340.5Zm-3-7.5a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v2Z" transform="translate(19337 -3329)" fill="#f51350"/>
                                    </svg>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <!--Submenu-->
                            <ul class="aiz-side-nav-list level-2">
                                @can('add_auction_product')
                                    <li class="aiz-side-nav-item">
                                        <a class="aiz-side-nav-link" href="{{route('auction_product_create.admin')}}">
                                            <span class="aiz-side-nav-text">{{translate('Add New auction product')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('view_all_auction_products')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('auction.all_products')}}" class="aiz-side-nav-link {{ areActiveRoutes(['auction_product_edit.admin','product_bids.admin']) }}">
                                            <span class="aiz-side-nav-text">{{ translate('All Auction Products') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('view_inhouse_auction_products')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('auction.inhouse_products')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{ translate('Inhouse Auction Products') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @if (get_setting('vendor_system_activation') == 1)
                                    @can('view_seller_auction_products')
                                        <li class="aiz-side-nav-item">
                                            <a href="{{route('auction.seller_products')}}" class="aiz-side-nav-link">
                                                <span class="aiz-side-nav-text">{{ translate('Seller Auction Products') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                @endif
                                @can('view_auction_product_orders')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('auction_products_orders')}}" class="aiz-side-nav-link {{ areActiveRoutes(['auction_products_orders.index']) }}">
                                            <span class="aiz-side-nav-text">{{ translate('Auction Products Orders') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                @endif

                <!-- Wholesale Product -->
                @if(addon_is_activated('wholesale'))
                    @canany(['add_wholesale_product','view_all_wholesale_products','view_inhouse_wholesale_products','view_sellers_wholesale_products'])
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <div class="aiz-side-nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <path id="Union_48" data-name="Union 48" d="M1.2,14.236a1.762,1.762,0,0,1,1.2-1.657V2c0-.325-.268-.823-.6-.823H.6C.268,1.176,0,1.031,0,.7V.647A.645.645,0,0,1,.6,0H2.4A1.407,1.407,0,0,1,3.6,1.41v9.65h10a1.4,1.4,0,0,1,1.2,1.518,1.757,1.757,0,0,1,1.165,2.01,1.8,1.8,0,0,1-3.566-.353,1.761,1.761,0,0,1,1.2-1.656v-.342H3.6v.342a1.754,1.754,0,0,1,1.165,2.01A1.784,1.784,0,0,1,3.338,15.97,1.927,1.927,0,0,1,3,16,1.782,1.782,0,0,1,1.2,14.236Zm12.4,0a.594.594,0,0,0,.6.588h0a.6.6,0,0,0,.6-.589c0-.389-.272-.5-.6-.617C13.872,13.732,13.6,13.846,13.6,14.235Zm-11.2,0a.6.6,0,0,0,.6.588H3a.6.6,0,0,0,.6-.589c0-.389-.272-.5-.6-.617C2.671,13.732,2.4,13.846,2.4,14.235Zm4.216-4.158A1.615,1.615,0,0,1,5,8.462V6.692A1.615,1.615,0,0,1,6.615,5.077h5.77A1.616,1.616,0,0,1,14,6.692V8.462a1.616,1.616,0,0,1-1.616,1.615ZM6.234,6.311a.542.542,0,0,0-.157.382V8.462A.538.538,0,0,0,6.615,9h5.77a.538.538,0,0,0,.538-.538V6.692a.536.536,0,0,0-.538-.538H6.612A.535.535,0,0,0,6.234,6.311ZM5.473,3.527A1.617,1.617,0,0,1,5,2.385V1.616A1.615,1.615,0,0,1,6.615,0H9.384A1.616,1.616,0,0,1,11,1.616v.769A1.615,1.615,0,0,1,9.384,4H6.612A1.614,1.614,0,0,1,5.473,3.527Zm.761-2.293a.542.542,0,0,0-.157.382v.769a.538.538,0,0,0,.538.538H9.384a.538.538,0,0,0,.539-.538V1.616a.542.542,0,0,0-.157-.382.536.536,0,0,0-.382-.157H6.612A.535.535,0,0,0,6.234,1.234Z" fill="#575b6a"/>
                                    </svg>
                                </div>
                                <span class="aiz-side-nav-text">{{translate('Wholesale Products')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.001" viewBox="0 0 16 14.001" class="mx-2">
                                        <path id="Union_49" data-name="Union 49" d="M-19322,3342.5v-5a2.007,2.007,0,0,0-2-2v1.5a3,3,0,0,1-3,3h-4v-10h4a3,3,0,0,1,3,3v1.5a3,3,0,0,1,3,3v5a.506.506,0,0,1-.5.5A.5.5,0,0,1-19322,3342.5Zm-11-2V3339h-3a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v-7.5a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v11a.5.5,0,0,1-.5.5A.506.506,0,0,1-19333,3340.5Zm-3-7.5a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v2Z" transform="translate(19337 -3329)" fill="#f51350"/>
                                    </svg>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                @can('add_wholesale_product')
                                    <li class="aiz-side-nav-item">
                                        <a class="aiz-side-nav-link" href="{{route('wholesale_product_create.admin')}}">
                                            <span class="aiz-side-nav-text">{{translate('Add New Wholesale Product')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('view_all_wholesale_products')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('wholesale_products.all')}}" class="aiz-side-nav-link {{ areActiveRoutes(['wholesale_product_edit.admin']) }}">
                                            <span class="aiz-side-nav-text">{{ translate('All Wholesale Products') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('view_inhouse_wholesale_products')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('wholesale_products.in_house')}}" class="aiz-side-nav-link {{ areActiveRoutes(['wholesale_product_edit.admin']) }}">
                                            <span class="aiz-side-nav-text">{{ translate('In House Wholesale Products') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @if (get_setting('vendor_system_activation') == 1)
                                    @can('view_sellers_wholesale_products')
                                        <li class="aiz-side-nav-item">
                                            <a href="{{route('wholesale_products.seller')}}" class="aiz-side-nav-link {{ areActiveRoutes(['wholesale_product_edit.admin']) }}">
                                                <span class="aiz-side-nav-text">{{ translate('Seller Wholesale Products') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                @endif
                            </ul>
                        </li>
                    @endcanany
                @endif

                <!-- Sale -->
                @canany(['view_all_orders', 'view_inhouse_orders','view_seller_orders','view_pickup_point_orders'])
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <div class="aiz-side-nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15.997" height="16" viewBox="0 0 15.997 16">
                                    <g id="Layer_2" data-name="Layer 2" transform="translate(-2 -1.994)">
                                      <path id="Path_40726" data-name="Path 40726" d="M4.857,12.571H3.714A1.714,1.714,0,0,0,2,14.285V20.57a1.714,1.714,0,0,0,1.714,1.714H4.857A1.714,1.714,0,0,0,6.571,20.57V14.285a1.714,1.714,0,0,0-1.714-1.714Zm.571,8a.571.571,0,0,1-.571.571H3.714a.571.571,0,0,1-.571-.571V14.285a.571.571,0,0,1,.571-.571H4.857a.571.571,0,0,1,.571.571Zm5.142-6.284H9.427A1.714,1.714,0,0,0,7.713,16V20.57a1.714,1.714,0,0,0,1.714,1.714H10.57a1.714,1.714,0,0,0,1.714-1.714V16A1.714,1.714,0,0,0,10.57,14.285Zm.571,6.284a.571.571,0,0,1-.571.571H9.427a.571.571,0,0,1-.571-.571V16a.571.571,0,0,1,.571-.571H10.57a.571.571,0,0,1,.571.571ZM16.283,12H15.14a1.714,1.714,0,0,0-1.714,1.714V20.57a1.714,1.714,0,0,0,1.714,1.714h1.143A1.714,1.714,0,0,0,18,20.57V13.714A1.714,1.714,0,0,0,16.283,12Zm.571,8.57a.571.571,0,0,1-.571.571H15.14a.571.571,0,0,1-.571-.571V13.714a.571.571,0,0,1,.571-.571h1.143a.571.571,0,0,1,.571.571Z" transform="translate(0 -4.289)" fill="#575b6a"/>
                                      <path id="Path_40727" data-name="Path 40727" d="M17.947,2.548a.571.571,0,0,0-.366-.24l-1.588-.3a.571.571,0,1,0-.213,1.122l.093.018L11.233,5.932l-5.45-2.18a.572.572,0,1,0-.424,1.062L11.072,7.1a.571.571,0,0,0,.506-.041L16.68,4l-.067.354a.571.571,0,0,0,.457.668.579.579,0,0,0,.107.01.571.571,0,0,0,.56-.465l.3-1.588A.568.568,0,0,0,17.947,2.548Z" transform="translate(-1.286)" fill="#575b6a"/>
                                    </g>
                                </svg>
                            </div>
                            <span class="aiz-side-nav-text">{{translate('Sales')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <!--Submenu-->
                        <ul class="aiz-side-nav-list level-2">
                            @can('view_all_orders')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('all_orders.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['all_orders.index', 'all_orders.show'])}}">
                                        <span class="aiz-side-nav-text">{{translate('All Orders')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('view_inhouse_orders')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('inhouse_orders.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['inhouse_orders.index', 'inhouse_orders.show'])}}" >
                                        <span class="aiz-side-nav-text">{{translate('Inhouse orders')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @if (get_setting('vendor_system_activation') == 1)
                                @can('view_seller_orders')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('seller_orders.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['seller_orders.index', 'seller_orders.show'])}}">
                                            <span class="aiz-side-nav-text">{{translate('Seller Orders')}}</span>
                                        </a>
                                    </li>
                                @endcan
                            @endif
                            
                            @can('view_pickup_point_orders')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('pick_up_point.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['pick_up_point.index','pick_up_point.order_show'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Pick-up Point Order')}}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                <!-- Deliver Boy Addon-->
                @if (addon_is_activated('delivery_boy'))
                    @canany(['view_all_delivery_boy','add_delivery_boy','delivery_boy_payment_history','collected_histories_from_delivery_boy','order_cancle_request_by_delivery_boy','delivery_boy_configuration'])
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <div class="aiz-side-nav-icon">
                                    <svg id="Group_28285" data-name="Group 28285" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <path id="Path_40728" data-name="Path 40728" d="M12.406,9.375h-.625v-.84a3.28,3.28,0,0,0,1.406-2.691V4.375h2.344a.469.469,0,0,0,0-.937H13.5a3.594,3.594,0,0,0-7.184.156v.313a.469.469,0,0,0,.313.442v1.5A3.28,3.28,0,0,0,8.031,8.535v.84H7.406a3.605,3.605,0,0,0-2.113.688H1.406a.469.469,0,0,0-.419.259L.049,12.2h0a.466.466,0,0,0-.05.209v3.125A.469.469,0,0,0,.469,16H15.531A.469.469,0,0,0,16,15.531V12.969A3.6,3.6,0,0,0,12.406,9.375ZM9.906.938a2.66,2.66,0,0,1,2.652,2.5h-5.3A2.66,2.66,0,0,1,9.906.938ZM7.562,5.844V4.375H12.25V5.844a2.344,2.344,0,0,1-4.688,0ZM9.906,9.125a3.271,3.271,0,0,0,.938-.137V10a.938.938,0,0,1-1.875,0V8.988A3.27,3.27,0,0,0,9.906,9.125ZM1.7,11H5.554l.469.938h-4.8ZM.937,12.875H6.312v2.188H.937Zm14.125,2.188H7.25V12.406A.466.466,0,0,0,7.2,12.2h0l-.836-1.672a2.638,2.638,0,0,1,1.042-.212h.652a1.875,1.875,0,0,0,3.7,0h.652a2.659,2.659,0,0,1,2.656,2.656Z" fill="#575b6a"/>
                                        <path id="Path_40729" data-name="Path 40729" d="M376.719,405h-1.25a.469.469,0,0,0,0,.938h1.25a.469.469,0,0,0,0-.937Z" transform="translate(-363.281 -392.344)" fill="#575b6a"/>
                                    </svg>
                                </div>
                                <span class="aiz-side-nav-text">{{translate('Delivery Boy')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.001" viewBox="0 0 16 14.001" class="mx-2">
                                        <path id="Union_49" data-name="Union 49" d="M-19322,3342.5v-5a2.007,2.007,0,0,0-2-2v1.5a3,3,0,0,1-3,3h-4v-10h4a3,3,0,0,1,3,3v1.5a3,3,0,0,1,3,3v5a.506.506,0,0,1-.5.5A.5.5,0,0,1-19322,3342.5Zm-11-2V3339h-3a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v-7.5a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v11a.5.5,0,0,1-.5.5A.506.506,0,0,1-19333,3340.5Zm-3-7.5a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v2Z" transform="translate(19337 -3329)" fill="#f51350"/>
                                    </svg>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                @can('view_all_delivery_boy')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('delivery-boys.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('All Delivery Boy')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('add_delivery_boy')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('delivery-boys.create')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Add Delivery Boy')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('delivery_boy_payment_history')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('delivery-boys-payment-histories')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Payment Histories')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('collected_histories_from_delivery_boy')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('delivery-boys-collection-histories')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Collected Histories')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('order_cancle_request_by_delivery_boy')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('delivery-boy.cancel-request')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Cancel Request')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('delivery_boy_configuration')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('delivery-boy-configuration')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Configuration')}}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                @endif

                <!-- Refund addon -->
                @if (addon_is_activated('refund_request'))
                    @canany(['view_refund_requests','view_approved_refund_requests','view_rejected_refund_requests','refund_request_configuration'])
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <div class="aiz-side-nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <path id="_4436b8ef9250481406399210799cb7f1" data-name="4436b8ef9250481406399210799cb7f1" d="M19.25,11.25a8.031,8.031,0,0,1-15.995,1,.688.688,0,0,1,1.365-.169A6.643,6.643,0,1,0,7.112,6.039h.866a.686.686,0,1,1,0,1.371H5.384A.687.687,0,0,1,4.7,6.724V4.138a.688.688,0,0,1,1.376,0v.987A8.024,8.024,0,0,1,19.25,11.25ZM11.278,6.907a.687.687,0,0,0-.688.686v.253a2.053,2.053,0,0,0-1.824,2.247,2.146,2.146,0,0,0,2.175,1.842h.8a.686.686,0,1,1,0,1.371h-1.6a.686.686,0,1,0,0,1.371h.458v.229a.688.688,0,0,0,1.376,0v-.26a2.113,2.113,0,0,0,1.824-1.811,2.062,2.062,0,0,0-2.053-2.272h-.917a.686.686,0,1,1,0-1.371h1.609a.686.686,0,1,0,0-1.371h-.462V7.593A.687.687,0,0,0,11.278,6.907Z" transform="translate(-3.25 -3.25)" fill="#575b6a"/>
                                    </svg>
                                </div>
                                <span class="aiz-side-nav-text">{{ translate('Refunds') }}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.001" viewBox="0 0 16 14.001" class="mx-2">
                                        <path id="Union_49" data-name="Union 49" d="M-19322,3342.5v-5a2.007,2.007,0,0,0-2-2v1.5a3,3,0,0,1-3,3h-4v-10h4a3,3,0,0,1,3,3v1.5a3,3,0,0,1,3,3v5a.506.506,0,0,1-.5.5A.5.5,0,0,1-19322,3342.5Zm-11-2V3339h-3a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v-7.5a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v11a.5.5,0,0,1-.5.5A.506.506,0,0,1-19333,3340.5Zm-3-7.5a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v2Z" transform="translate(19337 -3329)" fill="#f51350"/>
                                    </svg>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                @can('view_refund_requests')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('refund_requests_all')}}" class="aiz-side-nav-link {{ areActiveRoutes(['refund_requests_all', 'reason_show'])}}">
                                            <span class="aiz-side-nav-text">{{translate('Refund Requests')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('view_approved_refund_requests')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('paid_refund')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Approved Refunds')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('view_rejected_refund_requests')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('rejected_refund')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Rejected Refunds')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('refund_request_configuration')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('refund_time_config')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Refund Configuration')}}</span>
                                        </a>
                                    </li>
                                @endcan  
                            </ul>
                        </li>
                    @endcanany
                @endif

                <!-- Customers -->
                @canany(['view_all_customers','view_classified_products','view_classified_packages'])
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <div class="aiz-side-nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path id="Path_40769" data-name="Path 40769" d="M8,10.667A2.667,2.667,0,1,1,10.667,8,2.667,2.667,0,0,1,8,10.667Zm0-4A1.333,1.333,0,1,0,9.333,8,1.333,1.333,0,0,0,8,6.667Zm4,8.667a4,4,0,1,0-8,0,.667.667,0,0,0,1.333,0,2.667,2.667,0,1,1,5.333,0,.667.667,0,0,0,1.333,0Zm0-10a2.667,2.667,0,1,1,2.667-2.667A2.667,2.667,0,0,1,12,5.333Zm0-4a1.333,1.333,0,1,0,1.333,1.333A1.333,1.333,0,0,0,12,1.333ZM16,10a4,4,0,0,0-4-4,.667.667,0,0,0,0,1.333A2.667,2.667,0,0,1,14.667,10,.667.667,0,1,0,16,10ZM4,5.333A2.667,2.667,0,1,1,6.667,2.667,2.667,2.667,0,0,1,4,5.333Zm0-4A1.333,1.333,0,1,0,5.333,2.667,1.333,1.333,0,0,0,4,1.333ZM1.333,10A2.667,2.667,0,0,1,4,7.333.667.667,0,0,0,4,6a4,4,0,0,0-4,4,.667.667,0,0,0,1.333,0Z" fill="#575b6a"/>
                                </svg>
                            </div>
                            <span class="aiz-side-nav-text">{{ translate('Customers') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('view_all_customers')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('customers.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Customer list') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @if(get_setting('classified_product') == 1)
                                @can('view_classified_products')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('classified_products')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Classified Products')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('view_classified_packages')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('customer_packages.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['customer_packages.index', 'customer_packages.create', 'customer_packages.edit'])}}">
                                            <span class="aiz-side-nav-text">{{ translate('Classified Packages') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            @endif
                        </ul>
                    </li>
                @endcanany

                <!-- Sellers -->
                @if (get_setting('vendor_system_activation') == 1)
                    @canany(['view_all_seller','seller_payment_history','view_seller_payout_requests','seller_commission_configuration','view_all_seller_packages','seller_verification_form_configuration'])
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <div class="aiz-side-nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <path id="ef567a7fa3ca8f4541f8ab7b62352aa6" d="M19,9.625a.638.638,0,0,0-.079-.307l-2.779-5A.614.614,0,0,0,15.606,4H6.394a.614.614,0,0,0-.536.318l-2.779,5A.638.638,0,0,0,3,9.625a2.5,2.5,0,0,0,1.231,2.153V18.75A1.24,1.24,0,0,0,5.462,20H9.08a1.24,1.24,0,0,0,1.231-1.25V16.058a.759.759,0,0,1,.615-.773.684.684,0,0,1,.534.176.706.706,0,0,1,.229.521V18.75A1.24,1.24,0,0,0,12.92,20h3.618a1.24,1.24,0,0,0,1.231-1.25V11.777A2.5,2.5,0,0,0,19,9.625Zm-1.239.149a1.23,1.23,0,0,1-2.453-.149.578.578,0,0,0-.017-.086.548.548,0,0,0-.006-.084L14.114,5.25h1.132ZM9.164,5.25h1.22V9.625a1.23,1.23,0,0,1-2.455.063Zm2.451,0h1.22l1.235,4.437a1.23,1.23,0,0,1-2.455-.062Zm-4.862,0H7.886l-1.169,4.2a.548.548,0,0,0-.006.084.578.578,0,0,0-.018.086,1.23,1.23,0,0,1-2.453.149Zm9.785,13.5H12.92V15.981a1.964,1.964,0,0,0-.635-1.446,1.9,1.9,0,0,0-1.482-.491A2,2,0,0,0,9.08,16.061V18.75H5.462V12.125a2.439,2.439,0,0,0,1.846-.848A2.419,2.419,0,0,0,11,11.261a2.419,2.419,0,0,0,3.692.016,2.439,2.439,0,0,0,1.846.848Z" transform="translate(-3 -4)" fill="#575b6a"/>
                                    </svg>
                                </div>
                                <span class="aiz-side-nav-text">{{ translate('Sellers') }}</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                @can('view_all_seller')
                                    <li class="aiz-side-nav-item">
                                        @php
                                            $sellers = \App\Models\Shop::where('verification_status', 0)->where('verification_info', '!=', null)->count();
                                        @endphp
                                        <a href="{{ route('sellers.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['sellers.index', 'sellers.create', 'sellers.edit', 'sellers.payment_history','sellers.approved','sellers.profile_modal','sellers.show_verification_request'])}}">
                                            <span class="aiz-side-nav-text">{{ translate('All Seller') }}</span>
                                            @if($sellers > 0)<span class="badge badge-info">{{ $sellers }}</span> @endif
                                        </a>
                                    </li>
                                @endcan
                                @can('seller_payment_history')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('sellers.payment_histories') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{ translate('Payouts') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('view_seller_payout_requests')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('withdraw_requests_all') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{ translate('Payout Requests') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('seller_commission_configuration')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('business_settings.vendor_commission') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{ translate('Seller Commission') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @if (addon_is_activated('seller_subscription'))
                                    @can('view_all_seller_packages')
                                        <li class="aiz-side-nav-item">
                                            <a href="{{ route('seller_packages.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['seller_packages.index', 'seller_packages.create', 'seller_packages.edit'])}}">
                                                <span class="aiz-side-nav-text">{{ translate('Seller Packages') }}</span>
                                                @if (env("DEMO_MODE") == "On")
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.001" viewBox="0 0 16 14.001" class="mx-2">
                                                        <path id="Union_49" data-name="Union 49" d="M-19322,3342.5v-5a2.007,2.007,0,0,0-2-2v1.5a3,3,0,0,1-3,3h-4v-10h4a3,3,0,0,1,3,3v1.5a3,3,0,0,1,3,3v5a.506.506,0,0,1-.5.5A.5.5,0,0,1-19322,3342.5Zm-11-2V3339h-3a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v-7.5a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v11a.5.5,0,0,1-.5.5A.506.506,0,0,1-19333,3340.5Zm-3-7.5a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v2Z" transform="translate(19337 -3329)" fill="#f51350"/>
                                                    </svg>
                                                @endif
                                            </a>
                                        </li>
                                    @endcan
                                @endif
                                @can('seller_verification_form_configuration')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('seller_verification_form.index') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{ translate('Seller Verification Form') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                @endif

                {{-- Uploads Files --}}
                <li class="aiz-side-nav-item">
                    <a href="{{ route('uploaded-files.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['uploaded-files.create'])}}">
                        <div class="aiz-side-nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                <g id="layer1" transform="translate(-0.53 -0.53)">
                                  <path id="path3159" d="M3.386.53A2.862,2.862,0,0,0,.53,3.386V13.67a2.865,2.865,0,0,0,2.856,2.86H13.67a2.869,2.869,0,0,0,2.86-2.86V3.386A2.865,2.865,0,0,0,13.67.53Zm0,1.143H13.67a1.7,1.7,0,0,1,1.718,1.713V13.67a1.7,1.7,0,0,1-1.718,1.718H3.386A1.7,1.7,0,0,1,1.673,13.67V3.386A1.7,1.7,0,0,1,3.386,1.673ZM8.12,3.557,5.34,6.37a.572.572,0,0,0,0,.809.564.564,0,0,0,.81,0l1.8-1.824V10.8a.571.571,0,0,0,1.143,0V5.347l1.8,1.829a.571.571,0,0,0,.81-.806L8.935,3.557a.511.511,0,0,0-.815,0Zm-4.156,8.97a.571.571,0,0,0,0,1.143h9.128a.571.571,0,0,0,0-1.143Z" fill="#575b6a"/>
                                </g>
                            </svg>
                        </div>
                        <span class="aiz-side-nav-text">{{ translate('Uploaded Files') }}</span>
                    </a>
                </li>

                <!-- Reports -->
                @canany(['in_house_product_sale_report','seller_products_sale_report','products_stock_report','product_wishlist_report','user_search_report','commission_history_report','wallet_transaction_report'])
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <div class="aiz-side-nav-icon">
                                <svg id="stats_3916778" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path id="Path_40739" data-name="Path 40739" d="M16,16H2a2,2,0,0,1-2-2V0H1.333V14A.667.667,0,0,0,2,14.667H16Z" fill="#575b6a"/>
                                    <rect id="Rectangle_21340" data-name="Rectangle 21340" width="1.333" height="6" transform="translate(9.333 7.333)" fill="#575b6a"/>
                                    <rect id="Rectangle_21341" data-name="Rectangle 21341" width="1.333" height="6" transform="translate(4 7.333)" fill="#575b6a"/>
                                    <rect id="Rectangle_21342" data-name="Rectangle 21342" width="1.333" height="9.333" transform="translate(12 4)" fill="#575b6a"/>
                                    <rect id="Rectangle_21343" data-name="Rectangle 21343" width="1.333" height="9.333" transform="translate(6.667 4)" fill="#575b6a"/>
                                </svg>
                            </div>
                            <span class="aiz-side-nav-text">{{ translate('Reports') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('in_house_product_sale_report')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('in_house_sale_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['in_house_sale_report.index'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('In House Product Sale') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('seller_products_sale_report')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('seller_sale_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['seller_sale_report.index'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('Seller Products Sale') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('products_stock_report')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('stock_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['stock_report.index'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('Products Stock') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('product_wishlist_report')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('wish_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['wish_report.index'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('Products wishlist') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('user_search_report')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('user_search_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['user_search_report.index'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('User Searches') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('commission_history_report')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('commission-log.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Commission History') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('wallet_transaction_report')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('wallet-history.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Wallet Recharge History') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                
                <!--Blog System-->
                @canany(['view_blogs','view_blog_categories'])
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <div class="aiz-side-nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path id="Path_40771" data-name="Path 40771" d="M9.688,16H3.75A3.754,3.754,0,0,1,0,12.25V3.75A3.754,3.754,0,0,1,3.75,0h8.5A3.754,3.754,0,0,1,16,3.75V9.734a.625.625,0,0,1-1.25,0V3.75a2.5,2.5,0,0,0-2.5-2.5H3.75a2.5,2.5,0,0,0-2.5,2.5v8.5a2.5,2.5,0,0,0,2.5,2.5H9.688a.625.625,0,0,1,0,1.25ZM12.875,3.938a.625.625,0,0,0-.625-.625H6.531a.625.625,0,0,0,0,1.25H12.25A.625.625,0,0,0,12.875,3.938Zm0,2.5a.625.625,0,0,0-.625-.625H3.75a.625.625,0,0,0,0,1.25h8.5A.625.625,0,0,0,12.875,6.438Zm-6.25,2.5A.625.625,0,0,0,6,8.313H3.75a.625.625,0,0,0,0,1.25H6A.625.625,0,0,0,6.625,8.938Zm-3.5-5.062a.781.781,0,1,0,.781-.781A.781.781,0,0,0,3.125,3.875ZM15.332,15.332a2.284,2.284,0,0,0,0-3.226L13.141,9.915a4.506,4.506,0,0,0-2.31-1.236L9.06,8.325a.625.625,0,0,0-.735.735l.354,1.771a4.506,4.506,0,0,0,1.236,2.31l2.191,2.191a2.281,2.281,0,0,0,3.226,0ZM10.586,9.9a3.259,3.259,0,0,1,1.671.894l2.191,2.191a1.031,1.031,0,1,1-1.458,1.458L10.8,12.257A3.26,3.26,0,0,1,9.9,10.586l-.17-.852Z" fill="#575b6a"/>
                                </svg>
                            </div>
                            <span class="aiz-side-nav-text">{{ translate('Blog System') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('view_blogs')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('blog.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['blog.create', 'blog.edit'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('All Posts') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('view_blog_categories')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('blog-category.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['blog-category.create', 'blog-category.edit'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('Categories') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                <!-- marketing -->
                @canany(['view_all_flash_deals','send_newsletter','send_bulk_sms','view_all_subscribers','view_all_coupons'])
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <div class="aiz-side-nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <g id="_8dbc7a38f7bdee3f0be2c44d010760a2" data-name="8dbc7a38f7bdee3f0be2c44d010760a2" transform="translate(0 -4.027)">
                                      <path id="Path_40740" data-name="Path 40740" d="M38.286,16.393a.555.555,0,0,1-.344-.119L34.032,13.2a.557.557,0,0,1-.213-.438v-5.1a.556.556,0,0,1,.212-.438l3.91-3.074a.557.557,0,0,1,.9.438V15.836a.556.556,0,0,1-.556.557Zm-3.354-3.9,2.8,2.2V5.73l-2.8,2.2Z" transform="translate(-25.364 0)" fill="#575b6a"/>
                                      <path id="Path_40741" data-name="Path 40741" d="M9.011,22.556H3.093a3.1,3.1,0,0,1,0-6.192H9.011a.557.557,0,0,1,.557.557V22A.557.557,0,0,1,9.011,22.556ZM3.093,17.478a1.982,1.982,0,0,0,0,3.964H8.455V17.478Z" transform="translate(0 -9.25)" fill="#575b6a"/>
                                      <path id="Path_40742" data-name="Path 40742" d="M10.2,31.9a1.895,1.895,0,0,1-1.847-1.5l-.974-5.455a.557.557,0,1,1,1.089-.229l.975,5.455a.777.777,0,1,0,1.521-.32l-.824-4.74a.557.557,0,1,1,1.089-.229l.824,4.74A1.894,1.894,0,0,1,10.2,31.9Zm8.487-7.6h-.862a.557.557,0,0,1,0-1.114h.862a1.105,1.105,0,0,0,1.1-1.105,1.106,1.106,0,0,0-1.1-1.105h-.862a.557.557,0,0,1,0-1.114h.862a2.22,2.22,0,0,1,1.566,3.79A2.2,2.2,0,0,1,18.683,24.3Z" transform="translate(-4.9 -11.875)" fill="#575b6a"/>
                                    </g>
                                </svg>
                            </div>
                            <span class="aiz-side-nav-text">{{ translate('Marketing') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('view_all_flash_deals')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('flash_deals.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['flash_deals.index', 'flash_deals.create', 'flash_deals.edit'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('Flash deals') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('send_newsletter')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('newsletters.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Newsletters') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @if (addon_is_activated('otp_system') && auth()->user()->can('send_bulk_sms'))
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('sms.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Bulk SMS') }}</span>
                                        @if (env("DEMO_MODE") == "On")
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.001" viewBox="0 0 16 14.001" class="mx-2">
                                                <path id="Union_49" data-name="Union 49" d="M-19322,3342.5v-5a2.007,2.007,0,0,0-2-2v1.5a3,3,0,0,1-3,3h-4v-10h4a3,3,0,0,1,3,3v1.5a3,3,0,0,1,3,3v5a.506.506,0,0,1-.5.5A.5.5,0,0,1-19322,3342.5Zm-11-2V3339h-3a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v-7.5a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v11a.5.5,0,0,1-.5.5A.506.506,0,0,1-19333,3340.5Zm-3-7.5a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v2Z" transform="translate(19337 -3329)" fill="#f51350"/>
                                            </svg>
                                        @endif
                                    </a>
                                </li>
                            @endif
                            @can('view_all_subscribers')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('subscribers.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Subscribers') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @if (get_setting('coupon_system') == 1 && auth()->user()->can('view_all_coupons') )
                            <li class="aiz-side-nav-item">
                                <a href="{{route('coupon.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['coupon.index','coupon.create','coupon.edit'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Coupon') }}</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endcanany

                <!-- Support -->
                @canany(['view_all_support_tickets','view_all_product_conversations','view_all_product_queries'])
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <div class="aiz-side-nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <g id="Group_28286" data-name="Group 28286" transform="translate(0)">
                                      <path id="Path_40743" data-name="Path 40743" d="M16,9.125a3.122,3.122,0,0,0-1.255-2.5,6.9,6.9,0,0,0-1.94-4.6,6.725,6.725,0,0,0-9.61,0,6.9,6.9,0,0,0-1.94,4.6,3.124,3.124,0,0,0,1.87,5.627h1.25A.625.625,0,0,0,5,11.625v-5A.625.625,0,0,0,4.375,6H3.125a3.129,3.129,0,0,0-.569.052,5.487,5.487,0,0,1,10.887,0A3.129,3.129,0,0,0,12.875,6h-1.25A.625.625,0,0,0,11,6.625v5a.625.625,0,0,0,.625.625h.625v.625a1.877,1.877,0,0,1-1.875,1.875H8A.625.625,0,0,0,8,16h2.375A3.129,3.129,0,0,0,13.5,12.875v-.688A3.13,3.13,0,0,0,16,9.125ZM3.75,7.25V11H3.125a1.875,1.875,0,0,1,0-3.75ZM12.875,11H12.25V7.25h.625a1.875,1.875,0,1,1,0,3.75Z" fill="#575b6a"/>
                                      <path id="Path_40744" data-name="Path 40744" d="M197.875,113.25a.626.626,0,0,1,.625.625.618.618,0,0,1-.137.391,4.365,4.365,0,0,0-1.113,2.746v.613a.625.625,0,0,0,1.25,0v-.613a3.186,3.186,0,0,1,.838-1.964A1.875,1.875,0,1,0,196,113.875a.625.625,0,0,0,1.25,0A.626.626,0,0,1,197.875,113.25Z" transform="translate(-189.875 -108.5)" fill="#575b6a"/>
                                      <circle id="Ellipse_891" data-name="Ellipse 891" cx="0.625" cy="0.625" r="0.625" transform="translate(7.375 11)" fill="#575b6a"/>
                                    </g>
                                </svg>
                            </div>
                            <span class="aiz-side-nav-text">{{translate('Support')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('view_all_support_tickets')
                                @php
                                    $support_ticket = DB::table('tickets')
                                                ->where('viewed', 0)
                                                ->select('id')
                                                ->count();
                                @endphp
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('support_ticket.admin_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['support_ticket.admin_index', 'support_ticket.admin_show'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Ticket')}}</span>
                                        @if($support_ticket > 0)<span class="badge badge-info">{{ $support_ticket }}</span>@endif
                                    </a>
                                </li>
                            @endcan
                            
                            @can('view_all_product_conversations')
                                @php
                                    $conversation = \App\Models\Conversation::where('receiver_id', Auth::user()->id)->where('receiver_viewed', '0')->get();
                                @endphp
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('conversations.admin_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['conversations.admin_index', 'conversations.admin_show'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Product Conversations')}}</span>
                                        @if (count($conversation) > 0)
                                            <span class="badge badge-info">{{ count($conversation) }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endcan
                            @if (get_setting('product_query_activation') == 1)
                                @can('view_all_product_queries')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('product_query.index') }}"
                                            class="aiz-side-nav-link {{ areActiveRoutes(['product_query.index','product_query.show']) }}">
                                            <span class="aiz-side-nav-text">{{ translate('Product Queries') }}</span>                           
                                        </a>
                                    </li>
                                @endcan
                            @endif
                        </ul>
                    </li>
                @endcanany

                <!-- Affiliate Addon -->
                @if (addon_is_activated('affiliate_system'))
                    @canany(['affiliate_registration_form_config','affiliate_configurations','view_affiliate_users','view_all_referral_users','view_affiliate_withdraw_requests','view_affiliate_logs'])
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <div class="aiz-side-nav-icon">
                                    <svg id="Group_28297" data-name="Group 28297" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <path id="Path_40762" data-name="Path 40762" d="M43.75,273.875a1.875,1.875,0,1,0-1.875,1.875A1.877,1.877,0,0,0,43.75,273.875Zm-1.875.625a.625.625,0,1,1,.625-.625A.626.626,0,0,1,41.875,274.5Z" transform="translate(-38.75 -263.5)" fill="#575b6a"/>
                                        <path id="Path_40763" data-name="Path 40763" d="M3.125,392A3.129,3.129,0,0,0,0,395.125a.625.625,0,0,0,.625.625h5a.625.625,0,0,0,.625-.625A3.129,3.129,0,0,0,3.125,392Zm-1.768,2.5a1.875,1.875,0,0,1,3.536,0Z" transform="translate(0 -379.75)" fill="#575b6a"/>
                                        <path id="Path_40764" data-name="Path 40764" d="M355.75,273.875a1.875,1.875,0,1,0-1.875,1.875A1.877,1.877,0,0,0,355.75,273.875Zm-1.875.625a.625.625,0,1,1,.625-.625A.626.626,0,0,1,353.875,274.5Z" transform="translate(-341 -263.5)" fill="#575b6a"/>
                                        <path id="Path_40765" data-name="Path 40765" d="M315.125,392A3.129,3.129,0,0,0,312,395.125a.625.625,0,0,0,.625.625h5a.625.625,0,0,0,.625-.625A3.129,3.129,0,0,0,315.125,392Zm-1.768,2.5a1.875,1.875,0,0,1,3.536,0Z" transform="translate(-302.25 -379.75)" fill="#575b6a"/>
                                        <path id="Path_40766" data-name="Path 40766" d="M199.75,1.875a1.875,1.875,0,1,0-1.875,1.875A1.877,1.877,0,0,0,199.75,1.875Zm-1.875.625a.625.625,0,1,1,.625-.625A.626.626,0,0,1,197.875,2.5Z" transform="translate(-189.875)" fill="#575b6a"/>
                                        <path id="Path_40767" data-name="Path 40767" d="M156.625,123.75h5a.625.625,0,0,0,.625-.625,3.125,3.125,0,0,0-6.25,0A.625.625,0,0,0,156.625,123.75Zm2.5-2.5a1.878,1.878,0,0,1,1.768,1.25h-3.536A1.878,1.878,0,0,1,159.125,121.25Z" transform="translate(-151.125 -116.25)" fill="#575b6a"/>
                                        <path id="Path_40768" data-name="Path 40768" d="M180.893,279.472a.625.625,0,0,0-.173-.867l-1.6-1.064v-.915a.625.625,0,0,0-1.25,0v.915l-1.6,1.064a.625.625,0,1,0,.693,1.04l1.528-1.019,1.528,1.019A.625.625,0,0,0,180.893,279.472Z" transform="translate(-170.498 -267.375)" fill="#575b6a"/>
                                    </svg>
                                </div>
                                <span class="aiz-side-nav-text">{{translate('Affiliate System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.001" viewBox="0 0 16 14.001" class="mx-2">
                                        <path id="Union_49" data-name="Union 49" d="M-19322,3342.5v-5a2.007,2.007,0,0,0-2-2v1.5a3,3,0,0,1-3,3h-4v-10h4a3,3,0,0,1,3,3v1.5a3,3,0,0,1,3,3v5a.506.506,0,0,1-.5.5A.5.5,0,0,1-19322,3342.5Zm-11-2V3339h-3a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v-7.5a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v11a.5.5,0,0,1-.5.5A.506.506,0,0,1-19333,3340.5Zm-3-7.5a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v2Z" transform="translate(19337 -3329)" fill="#f51350"/>
                                    </svg>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                @can('affiliate_registration_form_config')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('affiliate.configs')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Affiliate Registration Form')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('affiliate_configurations')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('affiliate.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Affiliate Configurations')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('view_affiliate_users')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('affiliate.users')}}" class="aiz-side-nav-link {{ areActiveRoutes(['affiliate.users', 'affiliate_users.show_verification_request', 'affiliate_user.payment_history'])}}">
                                            <span class="aiz-side-nav-text">{{translate('Affiliate Users')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('view_all_referral_users')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('refferals.users')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Referral Users')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('view_affiliate_withdraw_requests')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('affiliate.withdraw_requests')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Affiliate Withdraw Requests')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('view_affiliate_logs')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('affiliate.logs.admin')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Affiliate Logs')}}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                @endif

                <!-- Offline Payment Addon-->
                @if (addon_is_activated('offline_payment'))
                    @canany(['view_all_manual_payment_methods','view_all_offline_wallet_recharges','view_all_offline_customer_package_payments','view_all_offline_seller_package_payments'])
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <div class="aiz-side-nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <g id="Group_28292" data-name="Group 28292" transform="translate(-1.25 -1.25)">
                                          <g id="Group_28290" data-name="Group 28290" transform="translate(1.25 9.644)">
                                            <path id="Path_40747" data-name="Path 40747" d="M10.706,20.168a3.576,3.576,0,0,1-1.517-.335L6.6,18.613a4.249,4.249,0,0,0-1.784-.4.562.562,0,0,1-.558-.558v-3.8a.562.562,0,0,1,.372-.528l1.286-.447a4.2,4.2,0,0,1,2.424-.089l4.238,1.139A1.419,1.419,0,0,1,13.6,14.973a1.2,1.2,0,0,1,.045.357v.134l1.941-.484a2.775,2.775,0,0,1,1.7.112,1.152,1.152,0,0,1,.1,2.106l-5.048,2.59a3.618,3.618,0,0,1-1.613.38ZM5.368,17.124a5.238,5.238,0,0,1,1.7.476l2.587,1.22a2.489,2.489,0,0,0,2.156-.03L16.87,16.2a1.3,1.3,0,0,0-1.033-.134l-3.688.923h-.022l-.223.06a.522.522,0,0,1-.216.007l-2.32-.342a.557.557,0,0,1,.164-1.1l2.208.327.059-.015.565-.32a.332.332,0,0,0,.164-.275c0-.007-.015-.082-.015-.089a.319.319,0,0,0-.23-.223L8.052,13.88a3.051,3.051,0,0,0-1.77.06l-.907.313v2.873Z" transform="translate(-2.022 -12.562)" fill="#575b6a"/>
                                            <path id="Path_40748" data-name="Path 40748" d="M4.038,18.856H1.808A.562.562,0,0,1,1.25,18.3V13.088a.562.562,0,0,1,.558-.558h2.23a.562.562,0,0,1,.558.558V18.3A.562.562,0,0,1,4.038,18.856ZM2.365,17.739H3.48V13.646H2.365Z" transform="translate(-1.25 -12.53)" fill="#575b6a"/>
                                          </g>
                                          <path id="Path_40749" data-name="Path 40749" d="M12.986,9.064H7.038A2.79,2.79,0,0,1,4.25,6.273V4.041A2.79,2.79,0,0,1,7.038,1.25h5.948a2.79,2.79,0,0,1,2.788,2.791V6.273A2.79,2.79,0,0,1,12.986,9.064Zm-5.948-6.7A1.676,1.676,0,0,0,5.365,4.041V6.273A1.676,1.676,0,0,0,7.038,7.948h5.948a1.676,1.676,0,0,0,1.673-1.674V4.041a1.676,1.676,0,0,0-1.673-1.674Z" transform="translate(-0.77)" fill="#575b6a"/>
                                          <g id="Group_28291" data-name="Group 28291" transform="translate(5.042 2.545)">
                                            <path id="Path_40750" data-name="Path 40750" d="M16.592,6.746A.445.445,0,0,1,16.15,6.3V5.542a.442.442,0,1,1,.884,0V6.3A.445.445,0,0,1,16.592,6.746Z" transform="translate(-8.748 -3.315)" fill="#575b6a"/>
                                            <path id="Path_40751" data-name="Path 40751" d="M6.792,6.745A.445.445,0,0,1,6.35,6.3V5.542a.442.442,0,1,1,.884,0V6.3A.445.445,0,0,1,6.792,6.745Z" transform="translate(-6.234 -3.314)" fill="#575b6a"/>
                                            <path id="Path_40752" data-name="Path 40752" d="M11.535,4.673H10.316c-.085,0-.152-.055-.152-.1s.067-.1.152-.1h1.219a.457.457,0,0,0,0-.915h-.152v-.1a.457.457,0,1,0-.914,0v.1h-.152A1.047,1.047,0,0,0,9.25,4.57a1.043,1.043,0,0,0,1.066,1.018h1.219c.085,0,.152.055.152.1s-.067.1-.152.1H10.316a.457.457,0,0,0,0,.915h.152v.1a.457.457,0,1,0,.914,0v-.1h.152a1.02,1.02,0,1,0,0-2.037Z" transform="translate(-6.725 -2.519)" fill="#575b6a"/>
                                          </g>
                                        </g>
                                    </svg>
                                </div>
                                <span class="aiz-side-nav-text">{{translate('Offline Payment System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.001" viewBox="0 0 16 14.001" class="mx-2">
                                        <path id="Union_49" data-name="Union 49" d="M-19322,3342.5v-5a2.007,2.007,0,0,0-2-2v1.5a3,3,0,0,1-3,3h-4v-10h4a3,3,0,0,1,3,3v1.5a3,3,0,0,1,3,3v5a.506.506,0,0,1-.5.5A.5.5,0,0,1-19322,3342.5Zm-11-2V3339h-3a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v-7.5a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v11a.5.5,0,0,1-.5.5A.506.506,0,0,1-19333,3340.5Zm-3-7.5a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v2Z" transform="translate(19337 -3329)" fill="#f51350"/>
                                    </svg>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                @can('view_all_manual_payment_methods')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('manual_payment_methods.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['manual_payment_methods.index', 'manual_payment_methods.create', 'manual_payment_methods.edit'])}}">
                                            <span class="aiz-side-nav-text">{{translate('Manual Payment Methods')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('view_all_offline_wallet_recharges')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('offline_wallet_recharge_request.index') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Offline Wallet Recharge')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                
                                @if(get_setting('classified_product') == 1 && auth()->user()->can('view_all_offline_customer_package_payments'))
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('offline_customer_package_payment_request.index') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Offline Customer Package Payments')}}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (addon_is_activated('seller_subscription') && auth()->user()->can('view_all_offline_seller_package_payments'))
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('offline_seller_package_payment_request.index') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Offline Seller Package Payments')}}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endcanany
                @endif

                <!-- Paytm Addon -->
                @if (addon_is_activated('paytm') && auth()->user()->can('asian_payment_gateway_configuration'))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <div class="aiz-side-nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <g id="Payment_1_" transform="translate(0 -16)">
                                      <path id="Path_40758" data-name="Path 40758" d="M316.375,220h-2.5a.668.668,0,0,1,0-1.333h3.75a.668.668,0,0,0,0-1.333H315.75v-.667a.626.626,0,1,0-1.25,0v.667h-.625a2,2,0,0,0,0,4h2.5a.668.668,0,0,1,0,1.333h-3.75a.668.668,0,0,0,0,1.333H314.5v.667a.626.626,0,1,0,1.25,0V224h.625a2,2,0,0,0,0-4Z" transform="translate(-302.25 -193.333)" fill="#575b6a"/>
                                      <g id="Group_28296" data-name="Group 28296" transform="translate(0 16)">
                                        <path id="Path_40759" data-name="Path 40759" d="M13.5,16H2.5A2.59,2.59,0,0,0,0,18.667v6.667A2.59,2.59,0,0,0,2.5,28H7.875a.668.668,0,0,0,0-1.333H2.5a1.3,1.3,0,0,1-1.25-1.333v-4h13.5V22A.626.626,0,1,0,16,22V18.667A2.59,2.59,0,0,0,13.5,16ZM1.25,20V18.667A1.3,1.3,0,0,1,2.5,17.333h11a1.3,1.3,0,0,1,1.25,1.333V20Z" transform="translate(0 -16)" fill="#575b6a"/>
                                        <path id="Path_40760" data-name="Path 40760" d="M80.625,256a.668.668,0,0,0,0,1.333H81.75a.668.668,0,0,0,0-1.333Z" transform="translate(-77.5 -248)" fill="#575b6a"/>
                                        <path id="Path_40761" data-name="Path 40761" d="M196.625,256a.668.668,0,0,0,0,1.333h1.125a.668.668,0,0,0,0-1.333Z" transform="translate(-189.875 -248)" fill="#575b6a"/>
                                      </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="aiz-side-nav-text">{{translate('Asian Payment Gateway')}}</span>
                            @if (env("DEMO_MODE") == "On")
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.001" viewBox="0 0 16 14.001" class="mx-2">
                                    <path id="Union_49" data-name="Union 49" d="M-19322,3342.5v-5a2.007,2.007,0,0,0-2-2v1.5a3,3,0,0,1-3,3h-4v-10h4a3,3,0,0,1,3,3v1.5a3,3,0,0,1,3,3v5a.506.506,0,0,1-.5.5A.5.5,0,0,1-19322,3342.5Zm-11-2V3339h-3a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v-7.5a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v11a.5.5,0,0,1-.5.5A.506.506,0,0,1-19333,3340.5Zm-3-7.5a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v2Z" transform="translate(19337 -3329)" fill="#f51350"/>
                                </svg>
                            @endif
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('paytm.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Set Asian PG Credentials')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Club Point Addon-->
                @if (addon_is_activated('club_point'))
                    @canany(['club_point_configurations','set_club_points','view_users_club_points'])
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <div class="aiz-side-nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <g id="Group_28289" data-name="Group 28289" transform="translate(-24 -896)">
                                          <g id="Group_28287" data-name="Group 28287" transform="translate(28 900)">
                                            <path id="Path_40745" data-name="Path 40745" d="M6,0a6,6,0,1,0,6,6A6.007,6.007,0,0,0,6,0ZM6,10.909A4.909,4.909,0,1,1,10.909,6,4.915,4.915,0,0,1,6,10.909Z" fill="#575b6a"/>
                                            <path id="Path_40746" data-name="Path 40746" d="M76.442,72.034l-1.726-.251-.772-1.564a.545.545,0,0,0-.978,0l-.772,1.564-1.726.251a.545.545,0,0,0-.3.93l1.249,1.218L71.119,75.9a.545.545,0,0,0,.791.575l1.544-.812L75,76.477a.545.545,0,0,0,.254.063h0a.546.546,0,0,0,.531-.667l-.29-1.69,1.249-1.218a.545.545,0,0,0-.3-.93ZM74.528,73.6a.545.545,0,0,0-.157.483l.157.913-.82-.431a.545.545,0,0,0-.508,0l-.82.431.157-.913a.545.545,0,0,0-.157-.483l-.663-.646.916-.133a.545.545,0,0,0,.411-.3l.41-.83.41.83a.545.545,0,0,0,.411.3l.916.133Z" transform="translate(-67.454 -67.373)" fill="#575b6a"/>
                                          </g>
                                          <path id="Subtraction_228" data-name="Subtraction 228" d="M-19334.447,3339.91h0A6.017,6.017,0,0,1-19337,3335a6.005,6.005,0,0,1,6-6,6.018,6.018,0,0,1,4.91,2.554,7.579,7.579,0,0,0-.906-.054c-.182,0-.365.007-.545.02a4.882,4.882,0,0,0-3.459-1.427,4.912,4.912,0,0,0-4.906,4.906,4.872,4.872,0,0,0,1.428,3.458c-.014.183-.02.361-.02.545a8.1,8.1,0,0,0,.053.905Zm.908-4.586h0l-.754-.732a.547.547,0,0,1-.135-.558.534.534,0,0,1,.441-.369l1.723-.252.771-1.568a.551.551,0,0,1,.49-.3.546.546,0,0,1,.49.3l.207.421a7.491,7.491,0,0,0-3.234,3.057Z" transform="translate(19361 -2433)" fill="#575b6a"/>
                                        </g>
                                    </svg>
                                </div>
                                <span class="aiz-side-nav-text">{{translate('Club Point System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.001" viewBox="0 0 16 14.001" class="mx-2">
                                        <path id="Union_49" data-name="Union 49" d="M-19322,3342.5v-5a2.007,2.007,0,0,0-2-2v1.5a3,3,0,0,1-3,3h-4v-10h4a3,3,0,0,1,3,3v1.5a3,3,0,0,1,3,3v5a.506.506,0,0,1-.5.5A.5.5,0,0,1-19322,3342.5Zm-11-2V3339h-3a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v-7.5a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v11a.5.5,0,0,1-.5.5A.506.506,0,0,1-19333,3340.5Zm-3-7.5a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v2Z" transform="translate(19337 -3329)" fill="#f51350"/>
                                    </svg>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                @can('club_point_configurations')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('club_points.configs') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Club Point Configurations')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('set_club_points')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('set_product_points')}}" class="aiz-side-nav-link {{ areActiveRoutes(['set_product_points', 'product_club_point.edit'])}}">
                                            <span class="aiz-side-nav-text">{{translate('Set Product Point')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('view_users_club_points')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('club_points.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['club_points.index', 'club_point.details'])}}">
                                            <span class="aiz-side-nav-text">{{translate('User Points')}}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                @endif

                <!--OTP addon -->
                @if (addon_is_activated('otp_system'))
                    @canany(['otp_configurations','sms_templates','sms_providers_configurations','send_bulk_sms'])
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <div class="aiz-side-nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <path id="pin-code" d="M4.25,12.25a.625.625,0,0,1,.625.625h0a.625.625,0,1,1-1.25,0h0A.625.625,0,0,1,4.25,12.25Zm1.875.625h0a.625.625,0,1,0,1.25,0h0a.625.625,0,1,0-1.25,0Zm2.5,0h0a.625.625,0,1,0,1.25,0h0a.625.625,0,1,0-1.25,0Zm2.5,0h0a.625.625,0,1,0,1.25,0h0a.625.625,0,0,0-1.25,0Zm3-3.046a.625.625,0,0,0-.312,1.211,1.249,1.249,0,0,1,.937,1.211V13.5a1.251,1.251,0,0,1-1.25,1.25H2.5A1.251,1.251,0,0,1,1.25,13.5V12.25a1.257,1.257,0,0,1,.9-1.2.625.625,0,1,0-.354-1.2,2.518,2.518,0,0,0-1.284.888A2.478,2.478,0,0,0,0,12.25V13.5A2.5,2.5,0,0,0,2.5,16h11A2.5,2.5,0,0,0,16,13.5V12.25A2.5,2.5,0,0,0,14.125,9.829Zm-10.562-.7V5.749A1.877,1.877,0,0,1,5.437,3.874h.124V2.387a2.438,2.438,0,0,1,4.875,0V3.874h.126a1.877,1.877,0,0,1,1.875,1.875V9.124A1.877,1.877,0,0,1,10.562,11H5.437A1.877,1.877,0,0,1,3.562,9.124Zm3.249-5.25H9.187V2.387a1.189,1.189,0,0,0-2.375,0V3.874Zm-2,5.25a.626.626,0,0,0,.625.625h5.125a.626.626,0,0,0,.625-.625V5.749a.626.626,0,0,0-.625-.625H5.437a.626.626,0,0,0-.625.625ZM8,8.125A.625.625,0,0,0,8.625,7.5h0a.625.625,0,0,0-1.25,0h0A.625.625,0,0,0,8,8.125Z" transform="translate(0)" fill="#575b6a"/>
                                    </svg>
                                </div>
                                <span class="aiz-side-nav-text">{{translate('OTP System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.001" viewBox="0 0 16 14.001" class="mx-2">
                                        <path id="Union_49" data-name="Union 49" d="M-19322,3342.5v-5a2.007,2.007,0,0,0-2-2v1.5a3,3,0,0,1-3,3h-4v-10h4a3,3,0,0,1,3,3v1.5a3,3,0,0,1,3,3v5a.506.506,0,0,1-.5.5A.5.5,0,0,1-19322,3342.5Zm-11-2V3339h-3a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v-7.5a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v11a.5.5,0,0,1-.5.5A.506.506,0,0,1-19333,3340.5Zm-3-7.5a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v2Z" transform="translate(19337 -3329)" fill="#f51350"/>
                                    </svg>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                @can('otp_configurations')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('otp.configconfiguration') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('OTP Configurations')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('sms_templates')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('sms-templates.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('SMS Templates')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('sms_providers_configurations')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('otp_credentials.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Set OTP Credentials')}}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                @endif

                <!-- African Payment Gateway -->
                @if(addon_is_activated('african_pg'))
                    @canany(['african_pg_configuration','african_pg_credentials_configuration'])
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <div class="aiz-side-nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <g id="Group_28295" data-name="Group 28295" transform="translate(-19275 2615)">
                                          <path id="Subtraction_229" data-name="Subtraction 229" d="M15,12H13V10.667h2A.667.667,0,0,0,15.666,10V4H2.334V8H1V2A2,2,0,0,1,3,0H15a2,2,0,0,1,2,2v8A2,2,0,0,1,15,12ZM3,1.333A.667.667,0,0,0,2.334,2v.667H15.666V2A.667.667,0,0,0,15,1.333Z" transform="translate(19274 -2615)" fill="#575b6a"/>
                                          <path id="Path_40756" data-name="Path 40756" d="M4.966.425H2.217L1.694,1.983H.027L2.86-5.579H4.312L7.16,1.983H5.493ZM2.64-.837h1.9L3.586-3.668Zm5.544,2.82V-2.535H7.343v-1.1h.841v-.478a1.933,1.933,0,0,1,.546-1.467A4.613,4.613,0,0,1,11.027-6l-.016,1.163a1.937,1.937,0,0,0-.46-.047q-.852,0-.852.795v.452h1.124v1.1H9.7V1.983Z" transform="translate(19274.973 -2600.983)" fill="#575b6a"/>
                                          <path id="Path_40757" data-name="Path 40757" d="M7.333,13H4.667a.667.667,0,0,0,0,1.333H7.333a.667.667,0,0,0,0-1.333Z" transform="translate(19273.207 -2621.667)" fill="#575b6a"/>
                                        </g>
                                    </svg>
                                </div>
                                <span class="aiz-side-nav-text">{{translate('African Payment Gateway')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.001" viewBox="0 0 16 14.001" class="mx-2">
                                        <path id="Union_49" data-name="Union 49" d="M-19322,3342.5v-5a2.007,2.007,0,0,0-2-2v1.5a3,3,0,0,1-3,3h-4v-10h4a3,3,0,0,1,3,3v1.5a3,3,0,0,1,3,3v5a.506.506,0,0,1-.5.5A.5.5,0,0,1-19322,3342.5Zm-11-2V3339h-3a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v-7.5a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v11a.5.5,0,0,1-.5.5A.506.506,0,0,1-19333,3340.5Zm-3-7.5a1,1,0,0,1-1-1,1,1,0,0,1,1-1h3v2Z" transform="translate(19337 -3329)" fill="#f51350"/>
                                    </svg>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                @can('african_pg_configuration')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('african.configuration') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('African PG Configurations')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('african_pg_credentials_configuration')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('african_credentials.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Set African PG Credentials')}}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                @endif

                <!-- Website Setup -->
                @canany(['header_setup','footer_setup','view_all_website_pages','website_appearance','authentication_layout_settings'])
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link {{ areActiveRoutes(['website.footer', 'website.header'])}}" >
                            <div class="aiz-side-nav-icon">
                                <svg id="Group_28315" data-name="Group 28315" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <circle id="Ellipse_893" data-name="Ellipse 893" cx="0.625" cy="0.625" r="0.625" transform="translate(7.375 6.125)" fill="#575b6a"/>
                                    <path id="Path_40777" data-name="Path 40777" d="M13.5,0H2.5A2.5,2.5,0,0,0,0,2.5V11a2.5,2.5,0,0,0,2.5,2.5H7.375v1.25H5.5A.625.625,0,0,0,5.5,16h5a.625.625,0,0,0,0-1.25H8.625V12.875A.625.625,0,0,0,8,12.25H2.5A1.251,1.251,0,0,1,1.25,11V2.5A1.251,1.251,0,0,1,2.5,1.25h11A1.251,1.251,0,0,1,14.75,2.5V11a1.251,1.251,0,0,1-1.25,1.25h-3a.625.625,0,0,0,0,1.25h3A2.5,2.5,0,0,0,16,11V2.5A2.5,2.5,0,0,0,13.5,0Z" fill="#575b6a"/>
                                    <path id="Path_40778" data-name="Path 40778" d="M120.375,84.75a.625.625,0,0,0,.625-.625v-.688a3.107,3.107,0,0,0,1.1-.456l.487.487a.625.625,0,0,0,.884-.884l-.487-.487a3.108,3.108,0,0,0,.456-1.1h.688a.625.625,0,1,0,0-1.25h-.688a3.108,3.108,0,0,0-.456-1.1l.487-.487a.625.625,0,0,0-.884-.884l-.487.487a3.107,3.107,0,0,0-1.1-.456v-.688a.625.625,0,0,0-1.25,0v.688a3.108,3.108,0,0,0-1.1.456l-.487-.487a.625.625,0,0,0-.884.884l.487.487a3.108,3.108,0,0,0-.456,1.1h-.688a.625.625,0,0,0,0,1.25h.688a3.108,3.108,0,0,0,.456,1.1l-.487.487a.625.625,0,0,0,.884.884l.487-.487a3.107,3.107,0,0,0,1.1.456v.688A.625.625,0,0,0,120.375,84.75ZM118.5,80.375a1.875,1.875,0,1,1,1.875,1.875A1.877,1.877,0,0,1,118.5,80.375Z" transform="translate(-112.375 -73.625)" fill="#575b6a"/>
                                </svg>
                            </div>
                            <span class="aiz-side-nav-text">{{translate('Website Setup')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('select_homepage')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('website.select-homepage') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Select Homepage')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('edit_website_page')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('custom-pages.edit', ['id'=>'home', 'lang'=>env('DEFAULT_LANGUAGE'), 'page'=>'home']) }}" 
                                        class="aiz-side-nav-link {{ (url()->current() == url('/admin/website/custom-pages/edit/home')) ? 'active' : '' }}">
                                        <span class="aiz-side-nav-text">{{translate('Homepage Settings')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('authentication_layout_settings')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('website.authentication-layout-settings') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Authentication Layout & Settings')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('header_setup')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('website.header') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Header')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('footer_setup')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('website.footer', ['lang'=>  App::getLocale()] ) }}" class="aiz-side-nav-link {{ areActiveRoutes(['website.footer'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Footer')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('view_all_website_pages')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('website.pages') }}" class="aiz-side-nav-link {{ areActiveRoutes(['website.pages', 'custom-pages.create' ,'custom-pages.edit'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Pages')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('website_appearance')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('website.appearance') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Appearance')}}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                <!-- Setup & Configurations -->
                @canany(['general_settings','features_activation','language_setup','currency_setup','vat_&_tax_setup',
                        'pickup_point_setup','smtp_settings','payment_methods_configurations','order_configuration','file_system_&_cache_configuration',
                        'social_media_logins','facebook_chat','facebook_comment','analytics_tools_configuration','google_recaptcha_configuration','google_map_setting',
                        'google_firebase_setting','shipping_configuration','shipping_country_setting','manage_shipping_states','manage_shipping_cities','manage_zones','manage_carriers'])
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <div class="aiz-side-nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path id="Path_40779" data-name="Path 40779" d="M7.688,16h.625a1.877,1.877,0,0,0,1.875-1.875V13.81a.209.209,0,0,1,.133-.191l.011,0a.209.209,0,0,1,.23.041l.223.223a1.875,1.875,0,0,0,2.652,0l.442-.442a1.875,1.875,0,0,0,0-2.652l-.223-.223a.209.209,0,0,1-.041-.23l0-.012a.209.209,0,0,1,.191-.133h.315A1.877,1.877,0,0,0,16,8.313V7.688a1.877,1.877,0,0,0-1.875-1.875H13.81a.209.209,0,0,1-.191-.133l0-.011a.209.209,0,0,1,.041-.23l.223-.223a1.875,1.875,0,0,0,0-2.652l-.442-.442a1.875,1.875,0,0,0-2.652,0l-.223.223a.21.21,0,0,1-.23.041l-.012,0a.209.209,0,0,1-.133-.191V1.875A1.877,1.877,0,0,0,8.312,0H7.687A1.877,1.877,0,0,0,5.812,1.875V2.19a.209.209,0,0,1-.133.191l-.012,0a.209.209,0,0,1-.23-.041l-.223-.223a1.875,1.875,0,0,0-2.652,0l-.442.442a1.875,1.875,0,0,0,0,2.652l.223.223a.209.209,0,0,1,.041.23l0,.011a.209.209,0,0,1-.191.133H1.875A1.877,1.877,0,0,0,0,7.687v.625a1.874,1.874,0,0,0,1.407,1.816.625.625,0,1,0,.312-1.211.624.624,0,0,1-.468-.605V7.688a.626.626,0,0,1,.625-.625H2.19a1.455,1.455,0,0,0,1.347-.906l0-.011a1.455,1.455,0,0,0-.312-1.591l-.223-.223a.625.625,0,0,1,0-.884l.442-.442a.625.625,0,0,1,.884,0l.223.223a1.456,1.456,0,0,0,1.593.311l.009,0A1.455,1.455,0,0,0,7.063,2.19V1.875a.626.626,0,0,1,.625-.625h.625a.626.626,0,0,1,.625.625V2.19a1.455,1.455,0,0,0,.906,1.347l.009,0a1.455,1.455,0,0,0,1.593-.311l.223-.223a.625.625,0,0,1,.884,0l.442.442a.625.625,0,0,1,0,.884l-.223.223a1.455,1.455,0,0,0-.311,1.593l0,.009a1.455,1.455,0,0,0,1.347.906h.315a.626.626,0,0,1,.625.625v.625a.626.626,0,0,1-.625.625H13.81a1.455,1.455,0,0,0-1.347.906l0,.009a1.455,1.455,0,0,0,.311,1.593l.223.223a.625.625,0,0,1,0,.884l-.442.442a.625.625,0,0,1-.884,0l-.223-.223a1.456,1.456,0,0,0-1.593-.311l-.009,0a1.455,1.455,0,0,0-.906,1.347v.315a.626.626,0,0,1-.625.625H7.688a.622.622,0,0,1-.6-.437.625.625,0,1,0-1.193.375A1.867,1.867,0,0,0,7.688,16ZM.536,15.433a1.829,1.829,0,0,1,0-2.586h0L4.589,8.811a3.234,3.234,0,0,1-.308-1.259,2.97,2.97,0,0,1,.9-2.141A4.228,4.228,0,0,1,8.13,4.255h.007a3.322,3.322,0,0,1,1.086.188A.625.625,0,0,1,9.47,5.473L7.964,7.01l.188.811L8.95,8,10.479,6.47a.625.625,0,0,1,1.034.24,3.472,3.472,0,0,1,.2,1.121,4.373,4.373,0,0,1-.8,2.556,3.047,3.047,0,0,1-2.49,1.3H8.417A3.414,3.414,0,0,1,7.159,11.4L3.122,15.433a1.829,1.829,0,0,1-2.586,0Zm6.876-5.311a2.1,2.1,0,0,0,1.007.316,1.818,1.818,0,0,0,1.487-.792,2.988,2.988,0,0,0,.528-1.361l-.843.845A.625.625,0,0,1,9.01,9.3L7.494,8.953a.625.625,0,0,1-.471-.468L6.669,6.959a.625.625,0,0,1,.162-.579l.823-.84A2.844,2.844,0,0,0,6.067,6.3,1.723,1.723,0,0,0,5.531,7.55a2.123,2.123,0,0,0,.342,1,.625.625,0,0,1-.065.809L1.419,13.731a.579.579,0,1,0,.819.818l4.368-4.361a.625.625,0,0,1,.806-.066Z" fill="#575b6a"/>
                                </svg>
                            </div>
                            <span class="aiz-side-nav-text">{{translate('Setup & Configurations')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            {{-- @can('general_settings')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('general_setting.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('General Settings')}}</span>
                                    </a>
                                </li>
                            @endcan --}}
                            @can('features_activation')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('activation.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Features activation')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('language_setup')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('languages.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['languages.index', 'languages.create', 'languages.store', 'languages.show', 'languages.edit'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Languages')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('currency_setup')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('currency.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Currency')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('vat_&_tax_setup')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('tax.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['tax.index', 'tax.create', 'tax.store', 'tax.show', 'tax.edit'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Vat & TAX')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('pickup_point_setup')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('pick_up_points.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['pick_up_points.index','pick_up_points.create','pick_up_points.edit'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Pickup point')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('smtp_settings')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('smtp_settings.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('SMTP Settings')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('payment_methods_configurations')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('payment_method.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Payment Methods')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('order_configuration')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('order_configuration.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Order Configuration')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('file_system_&_cache_configuration')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('file_system.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('File System & Cache Configuration')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('social_media_logins')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('social_login.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Social media Logins')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @canany(['facebook_chat','facebook_comment'])
                                <li class="aiz-side-nav-item">
                                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Facebook')}}</span>
                                        <span class="aiz-side-nav-arrow"></span>
                                    </a>
                                    <ul class="aiz-side-nav-list level-3">
                                        @can('facebook_chat')
                                            <li class="aiz-side-nav-item">
                                                <a href="{{ route('facebook_chat.index') }}" class="aiz-side-nav-link">
                                                    <span class="aiz-side-nav-text">{{translate('Facebook Chat')}}</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('facebook_comment')
                                            <li class="aiz-side-nav-item">
                                                <a href="{{ route('facebook-comment') }}" class="aiz-side-nav-link">
                                                    <span class="aiz-side-nav-text">{{translate('Facebook Comment')}}</span>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany
                            @canany(['analytics_tools_configuration','google_recaptcha_configuration','google_map_setting','google_firebase_setting'])
                                <li class="aiz-side-nav-item">
                                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Google')}}</span>
                                        <span class="aiz-side-nav-arrow"></span>
                                    </a>
                                    <ul class="aiz-side-nav-list level-3">
                                        @can('analytics_tools_configuration')
                                            <li class="aiz-side-nav-item">
                                                <a href="{{ route('google_analytics.index') }}" class="aiz-side-nav-link">
                                                    <span class="aiz-side-nav-text">{{translate('Analytics Tools')}}</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('google_recaptcha_configuration')
                                            <li class="aiz-side-nav-item">
                                                <a href="{{ route('google_recaptcha.index') }}" class="aiz-side-nav-link">
                                                    <span class="aiz-side-nav-text">{{translate('Google reCAPTCHA')}}</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('google_map_setting')
                                            <li class="aiz-side-nav-item">
                                                <a href="{{ route('google-map.index') }}" class="aiz-side-nav-link">
                                                    <span class="aiz-side-nav-text">{{translate('Google Map')}}</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('google_firebase_setting')
                                            <li class="aiz-side-nav-item">
                                                <a href="{{ route('google-firebase.index') }}" class="aiz-side-nav-link">
                                                    <span class="aiz-side-nav-text">{{translate('Google Firebase')}}</span>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany
                            @canany(['shipping_configuration','shipping_country_setting','manage_shipping_states','manage_shipping_cities','manage_zones','manage_carriers'])
                                <li class="aiz-side-nav-item">
                                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Shipping')}}</span>
                                        <span class="aiz-side-nav-arrow"></span>
                                    </a>
                                    <ul class="aiz-side-nav-list level-3">
                                        @can('shipping_configuration')
                                            <li class="aiz-side-nav-item">
                                                <a href="{{route('shipping_configuration.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['shipping_configuration.index','shipping_configuration.edit','shipping_configuration.update'])}}">
                                                    <span class="aiz-side-nav-text">{{translate('Shipping Configuration')}}</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('shipping_country_setting')
                                            <li class="aiz-side-nav-item">
                                                <a href="{{route('countries.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['countries.index','countries.edit','countries.update'])}}">
                                                    <span class="aiz-side-nav-text">{{translate('Shipping Countries')}}</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('manage_shipping_states')
                                            <li class="aiz-side-nav-item">
                                                <a href="{{route('states.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['states.index','states.edit','states.update'])}}">
                                                    <span class="aiz-side-nav-text">{{translate('Shipping States')}}</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('manage_shipping_cities')
                                            <li class="aiz-side-nav-item">
                                                <a href="{{route('cities.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['cities.index','cities.edit','cities.update'])}}">
                                                    <span class="aiz-side-nav-text">{{translate('Shipping Cities')}}</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('manage_zones')
                                            <li class="aiz-side-nav-item">
                                                <a href="{{route('zones.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['zones.index','zones.create','zones.edit'])}}">
                                                    <span class="aiz-side-nav-text">{{translate('Shipping Zones')}}</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('manage_carriers')
                                            <li class="aiz-side-nav-item">
                                                <a href="{{route('carriers.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['carriers.index','carriers.create','carriers.edit'])}}">
                                                    <span class="aiz-side-nav-text">{{translate('Shipping Carrier')}}</span>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endcanany

                <!-- Staffs -->
                @canany(['view_all_staffs','view_staff_roles'])
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <div class="aiz-side-nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <g id="Group_28314" data-name="Group 28314" transform="translate(-19299 2175)">
                                      <path id="Path_40774" data-name="Path 40774" d="M87.867,3.07H84.133V1.72A.716.716,0,0,0,83.422,1H80.578a.716.716,0,0,0-.711.72V3.07H76.133A2.149,2.149,0,0,0,74,5.229V14.84A2.149,2.149,0,0,0,76.133,17H87.867A2.149,2.149,0,0,0,90,14.84V5.229A2.149,2.149,0,0,0,87.867,3.07Zm-6.578-.63h1.422V3.79a.711.711,0,1,1-1.422,0Zm7.289,12.4a.716.716,0,0,1-.711.72H76.133a.716.716,0,0,1-.711-.72V5.229a.716.716,0,0,1,.711-.72h3.856a2.124,2.124,0,0,0,4.022,0h3.856a.716.716,0,0,1,.711.72Z" transform="translate(19225 -2176)" fill="#575b6a"/>
                                      <g id="Group_28312" data-name="Group 28312" transform="translate(19305.07 -2169.197)">
                                        <path id="Path_40775" data-name="Path 40775" d="M199.864,197.932a1.932,1.932,0,1,0-1.932,1.932A1.934,1.934,0,0,0,199.864,197.932Zm-1.932.644a.644.644,0,1,1,.644-.644A.645.645,0,0,1,197.932,198.576Z" transform="translate(-196 -196)" fill="#575b6a"/>
                                      </g>
                                      <g id="Group_28313" data-name="Group 28313" transform="translate(19303.779 -2165)">
                                        <path id="Path_40776" data-name="Path 40776" d="M160.508,316h-2.576A1.934,1.934,0,0,0,156,317.932v1.288a.644.644,0,1,0,1.288,0v-1.288a.645.645,0,0,1,.644-.644h2.576a.645.645,0,0,1,.644.644v1.288a.644.644,0,1,0,1.288,0v-1.288A1.934,1.934,0,0,0,160.508,316Z" transform="translate(-156 -316)" fill="#575b6a"/>
                                      </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="aiz-side-nav-text">{{translate('Staffs')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('view_all_staffs')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('staffs.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['staffs.index', 'staffs.create', 'staffs.edit'])}}">
                                        <span class="aiz-side-nav-text">{{translate('All staffs')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('view_staff_roles')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('roles.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['roles.index', 'roles.create', 'roles.edit'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Staff permissions')}}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                <!-- System Update & Server Status -->
                @canany(['system_update','server_status'])
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <div class="aiz-side-nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <g id="Group_28317" data-name="Group 28317" transform="translate(-19315.001 1976)">
                                      <g id="layer1" transform="translate(19314.471 -1976.53)">
                                        <path id="path3159" d="M3.386.53A2.862,2.862,0,0,0,.53,3.386V13.67a2.865,2.865,0,0,0,2.856,2.86H13.67a2.869,2.869,0,0,0,2.86-2.86V3.386A2.865,2.865,0,0,0,13.67.53Zm0,1.143H13.67a1.7,1.7,0,0,1,1.718,1.713V13.67a1.7,1.7,0,0,1-1.718,1.718H3.386A1.7,1.7,0,0,1,1.673,13.67V3.386A1.7,1.7,0,0,1,3.386,1.673Z" fill="#575b6a"/>
                                      </g>
                                      <g id="Group_28316" data-name="Group 28316" transform="translate(19317.551 -1973.449)">
                                        <g id="LWPOLYLINE" transform="translate(0 3.708)">
                                          <path id="Path_25666" data-name="Path 25666" d="M194.061,143.129a.436.436,0,0,0,0,.873h1.527a.436.436,0,0,0,0-.873Z" transform="translate(-193.625 -143.129)" fill="#575b6a"/>
                                        </g>
                                        <g id="LWPOLYLINE-2" data-name="LWPOLYLINE" transform="translate(3.663)">
                                          <path id="Path_25667" data-name="Path 25667" d="M199.926,137.186a.436.436,0,0,1,.872,0v1.527a.436.436,0,0,1-.872,0Z" transform="translate(-199.926 -136.75)" fill="#575b6a"/>
                                        </g>
                                        <g id="LWPOLYLINE-3" data-name="LWPOLYLINE" transform="translate(5.239 1.075)">
                                          <path id="Path_25668" data-name="Path 25668" d="M204.463,139.345a.436.436,0,1,0-.617-.617l-1.079,1.079a.436.436,0,1,0,.617.617Z" transform="translate(-202.638 -138.6)" fill="#575b6a"/>
                                        </g>
                                        <g id="LWPOLYLINE-4" data-name="LWPOLYLINE" transform="translate(1.097 1.075)">
                                          <path id="Path_25669" data-name="Path 25669" d="M195.64,139.345a.436.436,0,1,1,.617-.617l1.079,1.079a.436.436,0,1,1-.617.617Z" transform="translate(-195.512 -138.6)" fill="#575b6a"/>
                                        </g>
                                        <g id="LWPOLYLINE-5" data-name="LWPOLYLINE" transform="translate(1.097 5.261)">
                                          <path id="Path_25670" data-name="Path 25670" d="M195.64,147.008a.436.436,0,0,0,.617.617l1.079-1.079a.436.436,0,1,0-.617-.617Z" transform="translate(-195.512 -145.8)" fill="#575b6a"/>
                                        </g>
                                        <path id="Path_25671" data-name="Path 25671" d="M206.87,148.144,205,146.269l.864-.471a.436.436,0,0,0-.044-.786l-5.682-2.322a.436.436,0,0,0-.569.568l2.322,5.682a.436.436,0,0,0,.786.044l.471-.864,1.875,1.875a.437.437,0,0,0,.617,0l1.233-1.233A.437.437,0,0,0,206.87,148.144Zm-1.544.913-1.977-1.977a.436.436,0,0,0-.691.1l-.311.57-1.58-3.868,3.868,1.58-.57.311a.436.436,0,0,0-.174.591.467.467,0,0,0,.074.1l1.977,1.977Z" transform="translate(-196.099 -139.223)" fill="#575b6a"/>
                                      </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="aiz-side-nav-text">{{translate('System')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('system_update')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('system_update') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Update')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('server_status')
                            <li class="aiz-side-nav-item">
                                <a href="{{route('system_server')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Server status')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('server_status')
                            <li class="aiz-side-nav-item">
                                <a href="{{route('import_demo_data')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Import Demo Data')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                <!-- Addon Manager -->
                @can('manage_addons')
                    <li class="aiz-side-nav-item">
                        <a href="{{route('addons.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['addons.index', 'addons.create'])}}">
                            <div class="aiz-side-nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path id="_0339d7f72e6ebf7daea77d00de6c6177" data-name="0339d7f72e6ebf7daea77d00de6c6177" d="M12.2,17H9a.533.533,0,0,1-.533-.533v-1.6a1.067,1.067,0,1,0-2.133,0v1.6A.533.533,0,0,1,5.8,17H2.6A1.6,1.6,0,0,1,1,15.4V12.2a.533.533,0,0,1,.533-.533h1.6a1.067,1.067,0,1,0,0-2.133h-1.6A.533.533,0,0,1,1,9V5.8A1.6,1.6,0,0,1,2.6,4.2H5.267V3.133a2.133,2.133,0,1,1,4.267,0V4.2H12.2a1.6,1.6,0,0,1,1.6,1.6V8.467h1.067a2.133,2.133,0,1,1,0,4.267H13.8V15.4A1.6,1.6,0,0,1,12.2,17ZM9.533,15.933H12.2a.533.533,0,0,0,.533-.533V12.2a.533.533,0,0,1,.533-.533h1.6a1.067,1.067,0,1,0,0-2.133h-1.6A.533.533,0,0,1,12.733,9V5.8a.533.533,0,0,0-.533-.533H9a.533.533,0,0,1-.533-.533v-1.6a1.067,1.067,0,1,0-2.133,0v1.6a.533.533,0,0,1-.533.533H2.6a.533.533,0,0,0-.533.533V8.467H3.133a2.133,2.133,0,0,1,0,4.267H2.067V15.4a.533.533,0,0,0,.533.533H5.267V14.867a2.133,2.133,0,0,1,4.267,0Z" transform="translate(-1 -1)" fill="#575b6a"/>
                                </svg>
                            </div>
                            <span class="aiz-side-nav-text">{{translate('Addon Manager')}}</span>
                        </a>
                    </li>
                @endcan
            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div><!-- .aiz-sidebar -->
