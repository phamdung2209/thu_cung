<div class="aiz-topbar px-15px px-lg-25px d-flex align-items-stretch justify-content-between">
    <div class="d-flex">
        <!-- Mobile toggler -->
        <div class="aiz-topbar-nav-toggler d-flex align-items-center justify-content-start ml-0 mr-2" data-toggle="aiz-mobile-nav">
            <a class="btn btn-topbar has-transition btn-icon p-0 d-flex align-items-center" href="javascript:void(0)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <g id="Group_28009" data-name="Group 28009" transform="translate(0 16) rotate(-90)">
                      <rect id="Rectangle_18283" data-name="Rectangle 18283" width="2" height="7" rx="1" fill="#9da3ae"/>
                      <rect id="Rectangle_16236" data-name="Rectangle 16236" width="2" height="11" rx="1" transform="translate(14)" fill="#9da3ae"/>
                      <rect id="Rectangle_18284" data-name="Rectangle 18284" width="2" height="16" rx="1" transform="translate(7)" fill="#9da3ae"/>
                    </g>
                </svg>
            </a>
        </div>
        
    </div>
    <div class="d-flex justify-content-between align-items-stretch flex-grow-1">
        <div class="d-flex justify-content-around align-items-center align-items-stretch">
            <!-- Browse Website -->
            <div class="aiz-topbar-item mr-3">
                <div class="d-flex align-items-center">
                    <a class="btn btn-topbar has-transition btn-icon btn-circle btn-light p-0 hov-bg-primary hov-svg-white d-flex align-items-center justify-content-center"
                        href="{{ route('home') }}" target="_blank" data-toggle="tooltip" data-title="{{ translate('Browse Website') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path id="_754bac7463b8b1afad8e10a2355d1700" data-name="754bac7463b8b1afad8e10a2355d1700" d="M56,48a8,8,0,1,0,8,8A8,8,0,0,0,56,48Zm-.829,14.808a6.858,6.858,0,0,1-4.39-11.256,7.6,7.6,0,0,1,.077.93,2.966,2.966,0,0,0,.382,2.26,3.729,3.729,0,0,1,.362,1.08c.1.341.5.519.77.729.552.423,1.081.916,1.666,1.288.387.246.628.368.515.84a2.98,2.98,0,0,1-.313.951,1.927,1.927,0,0,0,.321.861c.288.288.575.553.889.813C55.938,61.706,55.4,62.229,55.171,62.808Zm5.678-1.959a6.808,6.808,0,0,1-3.56,1.888,2.844,2.844,0,0,1,.842-1.129,2.865,2.865,0,0,0,.757-.937,6.506,6.506,0,0,1,.522-.893c.272-.419-.67-1.051-.975-1.184a10.052,10.052,0,0,1-1.814-1.13c-.435-.306-1.318.16-1.808-.054A9.462,9.462,0,0,1,53,56.166c-.6-.454-.574-.984-.574-1.654.472.017,1.144-.131,1.458.249.1.12.439.655.667.465.186-.155-.138-.779-.2-.925-.193-.451.439-.626.762-.932.422-.4,1.326-1.024,1.254-1.309s-.9-1.1-1.394-.969c-.073.019-.719.7-.844.8q0-.332.01-.663c0-.14-.26-.283-.248-.373.031-.227.664-.64.821-.821-.11-.069-.487-.392-.6-.345-.276.115-.588.194-.863.309a1.756,1.756,0,0,0-.025-.274,6.792,6.792,0,0,1,1.743-.506l.542.218.382.454.382.394.334.108.53-.5L57,49.536v-.321a6.782,6.782,0,0,1,2.9,1.146c-.155.014-.326.037-.518.061a1.723,1.723,0,0,0-.268-.1c.251.54.513,1.073.779,1.606.284.569.915,1.18,1.026,1.781.131.708.04,1.352.111,2.185a3.732,3.732,0,0,0,.9,1.714,1.812,1.812,0,0,0,.707.086A6.815,6.815,0,0,1,60.849,60.849Z" transform="translate(-48 -48)" fill="#717580"/>
                        </svg>
                    </a>
                </div>
            </div>
            @if (addon_is_activated('pos_system') && auth()->user()->can('pos_manager'))
            <!-- POS -->
            <div class="aiz-topbar-item mr-3">
                <div class="d-flex align-items-center">
                    <a class="btn btn-topbar has-transition btn-icon btn-circle btn-light p-0 hov-bg-primary hov-svg-white d-flex align-items-center justify-content-center" 
                        href="{{ route('poin-of-sales.index') }}" target="_blank" data-toggle="tooltip" data-title="{{ translate('POS') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13.79" height="16" viewBox="0 0 13.79 16">
                            <g id="_371925cdd3f531725a9fa8f3ebf8fe9e" data-name="371925cdd3f531725a9fa8f3ebf8fe9e" transform="translate(-2.26 0)">
                            <path id="Path_40673" data-name="Path 40673" d="M10.69,7H3.26a1.025,1.025,0,0,0-1,1V18.45a1.03,1.03,0,0,0,1,1.05h7.43a1.03,1.03,0,0,0,1.03-1.03V8A1.025,1.025,0,0,0,10.69,7ZM4.94,17.86H3.995v-.95H4.94Zm0-2.355H3.995v-.95H4.94Zm0-2.355H3.995V12.2H4.94Zm2.5,4.71H6.5v-.95h.955Zm0-2.355H6.5v-.95h.955Zm0-2.355H6.5V12.2h.955Zm2.5,4.71H8.99v-.95h.95Zm0-2.355H8.99v-.95h.95Zm0-2.355H8.99V12.2h.95Zm.325-3a.17.17,0,0,1-.165.17H3.835a.17.17,0,0,1-.165-.17V8.795a.165.165,0,0,1,.165-.165H10.13a.165.165,0,0,1,.165.165Zm5.09-1.45H15.13v9.09h.25a.67.67,0,0,0,.67-.67V9.375a.67.67,0,0,0-.695-.675Z" transform="translate(0 -3.5)" fill="#717580"/>
                            <rect id="Rectangle_20842" data-name="Rectangle 20842" width="1.465" height="9.095" transform="translate(12.185 5.2)" fill="#717580"/>
                            <rect id="Rectangle_20843" data-name="Rectangle 20843" width="0.63" height="9.095" transform="translate(14.06 5.2)" fill="#717580"/>
                            <path id="Path_40674" data-name="Path 40674" d="M13.895.895a.89.89,0,0,0-.26-.635A.91.91,0,0,0,13,0a.895.895,0,0,0-.91.895v.53h1.79Zm-2.2,0a.76.76,0,0,1,0-.145.68.68,0,0,1,0-.1h.01A.5.5,0,0,1,11.755.5.43.43,0,0,1,11.79.4a1.2,1.2,0,0,1,.145-.26.5.5,0,0,1,.04-.055L12.045,0H7.995A.815.815,0,0,0,7.18.81V3.03h4.5Z" transform="translate(-2.46)" fill="#717580"/>
                            </g>
                        </svg>
                    </a>
                </div>
            </div>
            @endif
            <!-- Clear Cache -->
            <div class="aiz-topbar-item mr-3">
                <div class="d-flex align-items-center">
                    <a class="btn btn-topbar has-transition btn-icon btn-circle btn-light p-0 hov-bg-primary hov-svg-white d-flex align-items-center justify-content-center" 
                        href="{{ route('cache.clear') }}" data-toggle="tooltip" data-title="{{ translate('Clear Cache') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path id="_74846e5be5db5b666d3893933be03656" data-name="74846e5be5db5b666d3893933be03656" d="M7.719,8.911H8.9V10.1H7.719v1.185H6.539V10.1H5.36V8.911h1.18V7.726h1.18ZM5.36,13.652h1.18v1.185H5.36v1.185H4.18V14.837H3V13.652H4.18V12.467H5.36Zm13.626-2.763H10.138V10.3a1.182,1.182,0,0,1,1.18-1.185h2.36V2h1.77V9.111h2.36a1.182,1.182,0,0,1,1.18,1.185ZM18.4,18H16.044a9.259,9.259,0,0,0,.582-2.963.59.59,0,1,0-1.18,0A7.69,7.69,0,0,1,14.755,18H12.5a9.259,9.259,0,0,0,.582-2.963.59.59,0,1,0-1.18,0A7.69,7.69,0,0,1,11.216,18H8.958a22.825,22.825,0,0,0,1.163-5.926H18.99A19.124,19.124,0,0,1,18.4,18Z" transform="translate(-3 -2)" fill="#717580"/>
                        </svg>
                    </a>
                </div>
            </div>
            <!-- Topbar menus -->
            <div class="aiz-topbar-item mr-2 d-none d-xl-block">
                <div class="d-flex align-items-center h-100">
                    <a class="aiz-topbar-menu fs-13 fw-600 d-flex align-items-center justify-content-center {{ areActiveRoutes(['admin.dashboard']) }}" 
                        href="{{ route('admin.dashboard') }}">{{ translate('Dashboard') }}</a>
                    <a class="aiz-topbar-menu fs-13 fw-600 d-flex align-items-center justify-content-center {{ areActiveRoutes(['all_orders.index']) }}" 
                        href="{{ route('all_orders.index') }}">{{ translate('Orders') }}</a>
                    {{-- <a class="aiz-topbar-menu fs-13 fw-600 d-flex align-items-center justify-content-center {{ areActiveRoutes(['admin.dashboard']) }}" 
                        href="{{ route('admin.dashboard') }}">{{ translate('Earnings') }}</a> --}}
                    <a class="aiz-topbar-menu fs-13 fw-600 d-flex align-items-center justify-content-center {{ (url()->current() == url('/admin/website/custom-pages/edit/home')) ? 'active' : '' }}" 
                        href="{{ route('custom-pages.edit', ['id'=>'home', 'lang'=>env('DEFAULT_LANGUAGE'), 'page'=>'home']) }}">{{ translate('Homepage Settings') }}</a>
                </div>
            </div>
            <!-- Add New product -->
            <div class="d-flex justify-content-around align-items-center align-items-stretch">
                <div class="aiz-topbar-item d-none d-sm-block">
                    <div class="d-flex align-items-center h-100">
                        <a class="btn btn-soft-blue btn-sm d-flex align-items-center rounded-2 hov-svg-white"
                            href="{{ route('products.create') }}">
                            <span class="fw-500 mx-2 mr-0 d-none d-md-block">{{ translate('Add New') }}</span>
                            <i class="las fs-18 la-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-around align-items-center align-items-stretch">
            <!-- Notifications -->
            <div class="aiz-topbar-item mr-3">
                <div class="align-items-stretch d-flex dropdown">
                    <a class="dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button"
                        aria-haspopup="false" aria-expanded="false">
                        <span class="btn btn-topbar btn-circle btn-light p-0 d-flex justify-content-center align-items-center" data-toggle="tooltip" data-title="{{ translate('Notification') }}">
                            <span class="d-flex align-items-center position-relative">
                                <div class="px-2 hov-svg-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16">
                                        <g id="Group_23884" data-name="Group 23884" transform="translate(-677 5110)">
                                          <path id="Union_38" data-name="Union 38" d="M5.5,16a.5.5,0,0,1,0-1h3a.5.5,0,1,1,0,1Zm-5-2a.5.5,0,0,1,0-1H2V7A5.008,5.008,0,0,1,6.5,2.025V.5a.5.5,0,1,1,1,0V2.025A5.007,5.007,0,0,1,12,7H11A4,4,0,1,0,3,7v6h8V7h1v6h1.5a.5.5,0,1,1,0,1Z" transform="translate(677 -5110)" fill="#9da3ae"/>
                                        </g>
                                    </svg>
                                </div>
                                @if (Auth::user()->unreadNotifications->count() > 0)
                                    <span class="badge badge-sm badge-dot badge-circle badge-danger position-absolute absolute-top-right"></span>
                                @endif
                            </span>
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-xl py-0">
                        <div class="notifications">
                            <ul class="nav nav-tabs nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link text-dark active" data-toggle="tab" data-type="order" href="javascript:void(0);"
                                        data-target="#orders-notifications" role="tab" id="orders-tab">{{ translate('Orders') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" data-toggle="tab" data-type="seller" href="javascript:void(0);"
                                        data-target="#sellers-notifications" role="tab" id="sellers-tab">{{ translate('Sellers') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" data-toggle="tab" data-type="seller" href="javascript:void(0);"
                                        data-target="#payouts-notifications" role="tab" id="sellers-tab">{{ translate('Payouts') }}</a>
                                </li>
                            </ul>
                            <div class="tab-content c-scrollbar-light overflow-auto" style="height: 75vh; max-height: 400px; overflow-y: auto;">
                                @php
                                    $unreadNotifications = auth()->user()->unreadNotifications();
                                @endphp
                                <div class="tab-pane active" id="orders-notifications" role="tabpanel">
                                    <x-notification :notifications="$unreadNotifications->where('type', 'App\Notifications\OrderNotification')->take(20)->get()" />
                                </div>
                                <div class="tab-pane" id="sellers-notifications" role="tabpanel">
                                    <x-notification :notifications="$unreadNotifications->where('type', 'like', '%shop%')->take(20)->get()" />
                                </div>
                                <div class="tab-pane" id="payouts-notifications" role="tabpanel">
                                    <x-notification :notifications="$unreadNotifications->where('type', 'App\Notifications\PayoutNotification')->take(20)->get()" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center border-top">
                            <a href="{{ route('admin.all-notification') }}" class="text-reset d-block py-2">
                                {{ translate('View All Notifications') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- language -->
            @php
                if (Session::has('locale')) {
                    $locale = Session::get('locale', Config::get('app.locale'));
                } else {
                    $locale = env('DEFAULT_LANGUAGE');
                }
            @endphp
            <div class="aiz-topbar-item mr-3">
                <div class="align-items-stretch d-flex dropdown" id="lang-change">
                    <a class="dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="btn btn-topbar btn-circle btn-light p-0 d-flex justify-content-center align-items-center" data-toggle="tooltip" data-title="{{ translate('Language') }}">
                            <img src="{{ static_asset('assets/img/flags/' . $locale . '.png') }}" height="11">
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-xs">

                        @foreach (\App\Models\Language::where('status', 1)->get() as $key => $language)
                            <li>
                                <a href="javascript:void(0)" data-flag="{{ $language->code }}"
                                    class="dropdown-item @if ($locale == $language->code) active @endif">
                                    <img src="{{ static_asset('assets/img/flags/' . $language->code . '.png') }}"
                                        class="mr-2">
                                    <span class="language">{{ $language->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- User -->
            <div class="aiz-topbar-item">
                <div class="align-items-stretch d-flex dropdown">
                    <!-- Image & Name -->
                    <a class="dropdown-toggle no-arrow text-dark" data-toggle="dropdown" href="javascript:void(0);"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <span class="d-none d-md-block">
                                <span class="d-block fw-500">{{ Auth::user()->name }}</span>
                                <span class="d-block small opacity-60 text-right">{{ Auth::user()->user_type }}</span>
                            </span>
                            <span class="size-40px rounded-content overflow-hidden ml-md-2">
                                <img src="{{ uploaded_asset(Auth::user()->avatar_original) }}" class="img-fit"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                            </span>
                        </span>
                    </a>
                    <!-- User dropdown Menus -->
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-md">
                        <a href="{{ route('profile.index') }}" class="dropdown-item">
                            <i class="las la-user-circle"></i>
                            <span>{{ translate('Profile') }}</span>
                        </a>

                        <a href="{{ route('logout') }}" class="dropdown-item">
                            <i class="las la-sign-out-alt"></i>
                            <span>{{ translate('Logout') }}</span>
                        </a>
                    </div>
                </div>
            </div><!-- .aiz-topbar-item -->
        </div>
    </div>
</div><!-- .aiz-topbar -->
