<!DOCTYPE html>

@php
    $rtl = get_session_language()->rtl;
@endphp

@if ($rtl == 1)
    <html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endif

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="description" content="@yield('meta_description', get_setting('meta_description'))" />
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords'))">
    <title>@yield('meta_title', get_setting('website_name') . ' | ' . get_setting('site_motto'))</title>

    <!-- Favicon -->
    @php
        $site_icon = uploaded_asset(get_setting('site_icon'));
    @endphp
    <link rel="icon" href="{{ $site_icon }}">
    <link rel="apple-touch-icon" href="{{ $site_icon }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
    @if ($rtl == 1)
        <link rel="stylesheet" href="{{ static_asset('assets/css/bootstrap-rtl.min.css') }}">
    @endif
    <link rel="stylesheet" href="{{ static_asset('assets/css/aiz-core.css?v=') }}{{ rand(1000, 9999) }}">
    
    <style>
        :root {
            --primary: #1b84ff;
            --soft-primary: #e9f3ff;
            --hov-primary: #146bce;
            --success: #12814c;
            --soft-success: #dfffe8;
            --info: #7339ea;
            --soft-info: #f1e8ff;
            --warning: #f6ba41;
            --soft-warning: #fff6e6;
        }
        body{
            font-family: 'Public Sans', sans-serif;
            font-weight: 400;
        }
        .demo-admin-links{
            max-width: 780px;
        }
    </style>
</head>
<body>
    <!-- aiz-main-wrapper -->
    <div class="aiz-main-wrapper d-flex flex-column justify-content-center bg-white">
        <section class="bg-white">
            <div class="container">
                <div class="demo-admin-links w-100 py-5 my-lg-5 px-4 mx-auto">
                    <div class="row overflow-hidden rounded-3" style="border: 1px solid #f2f2f2;">
                        <div class="col-md-6 px-0 d-none d-md-block"  style="border-right: 1px solid #f2f2f2;">
                            <img class="img-fit h-100" src="{{ my_asset('assets/img/demo/link/link.png') }}" alt="Active eCommerce CMS">
                        </div>
                        <div class="col-md-6 px-2rem py-5 d-flex flex-column justify-content-center">
                            <div class="mb-4 text-center">
                                <img class="h-40px" src="{{ my_asset('assets/img/demo/link/logo.svg') }}" alt="Active eCommerce CMS">
                            </div>
                            <a href="https://demo.activeitzone.com/ecommerce/users/login" class="btn btn-block btn-lg btn-soft-primary fs-14 fw-700 mb-3 rounded-2">Login as Customer</a>
                            <a href="https://demo.activeitzone.com/ecommerce/login" class="btn btn-block btn-lg btn-soft-info fs-14 fw-700 mb-3 rounded-2">Login as Admin</a>
                            <a href="https://demo.activeitzone.com/ecommerce/seller/login" class="btn btn-block btn-lg btn-soft-success fs-14 fw-700 mb-3 rounded-2">Login as Seller</a>
                            <a href="https://demo.activeitzone.com/ecommerce/deliveryboy/login" class="btn btn-block btn-lg btn-soft-warning fs-14 fw-700 mb-3 rounded-2">Login as Delivery Boy</a>
                            <small class="d-block fs-10 text-center" style="color: #78829d;">* The above links of Login will forward you to main demo.</small>
                        </div>
                    </div>
                    <div class="text-center" style="margin-top: 40px;">
                        <small class="d-block fs-12 text-center mb-3" style="color: #78829d;">Mobile Apps for Active eCommerce CMS</small>
                        <div class="d-flex flex-wrap justify-content-center mb-3">
                            <a href="https://codecanyon.net/item/active-ecommerce-flutter-app/31466365" target="_blank" class="fs-14 fw-700 text-primary mx-3 animate-underline-primary">Customer Mobile App</a>
                            <a href="https://codecanyon.net/item/active-ecommerce-seller-app/38842276" target="_blank" class="fs-14 fw-700 text-primary mx-3 animate-underline-primary">Seller’s Mobile App</a>
                            <a href="https://codecanyon.net/item/active-ecommerce-delivery-boy-flutter-app/32173746" target="_blank" class="fs-14 fw-700 text-primary mx-3 animate-underline-primary">Delivery Boy Mobile App</a>
                        </div>
                        <div class="mb-5">
                            <a href="https://codecanyon.net/user/activeitzone/portfolio" target="_blank" class="fs-12 fw-500 hov-text-primary" style="text-decoration: underline; text-transform: uppercase;color: #78829d;">View all Add-ons for Active eCommerce CMS</a>
                        </div>
                        <div class="d-flex flex-wrap justify-content-center mb-2">
                            <a href="https://activeitzone.com/docs/active-ecommerce-cms/" target="_blank" class="fs-14 fw-700 text-primary mx-4 d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16" viewBox="0 0 12 16">
                                    <path id="Google_Docs" data-name="Google Docs" d="M14.9,3.433,11.567.1a.333.333,0,0,0-.233-.1h-7A1.333,1.333,0,0,0,3,1.333V14.667A1.333,1.333,0,0,0,4.333,16h9.333A1.333,1.333,0,0,0,15,14.667v-11a.333.333,0,0,0-.1-.233ZM9.333,12H6a.333.333,0,0,1,0-.667H9.333a.333.333,0,0,1,0,.667ZM12,10.667H6A.333.333,0,0,1,6,10h6a.333.333,0,1,1,0,.667Zm0-1.333H6a.333.333,0,0,1,0-.667h6a.333.333,0,1,1,0,.667ZM12,8H6a.333.333,0,0,1,0-.667h6A.333.333,0,1,1,12,8Zm.333-4.667a.667.667,0,0,1-.667-.667V1.14L13.86,3.333Z" transform="translate(-3)" fill="#1b84ff"/>
                                </svg>
                                <span class="ml-2 animate-underline-primary">Docs</span>
                            </a>
                            <a href="https://www.youtube.com/watch?v=FFjausSYe3M" target="_blank" class="fs-14 fw-700 text-primary mx-4 d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <g id="Group_28098" data-name="Group 28098" transform="translate(4437 -9778)">
                                      <path id="Subtraction_193" data-name="Subtraction 193" d="M15.332,16H.666a.667.667,0,0,1,0-1.334H15.332a.667.667,0,0,1,0,1.334ZM13,13.333H3a3,3,0,0,1-3-3V3A3,3,0,0,1,3,0H13a3,3,0,0,1,3,3v7.333A3,3,0,0,1,13,13.333Zm-9.666-12a2,2,0,0,0-2,2V10a2,2,0,0,0,2,2h9.333a2,2,0,0,0,2-2V3.333a2,2,0,0,0-2-2Z" transform="translate(-4436.999 9778.001)" fill="#1b84ff"/>
                                      <path id="Polygon_6" data-name="Polygon 6" d="M3.333,0,6.667,5.333H0Z" transform="translate(-4425.667 9781.334) rotate(90)" fill="#1b84ff"/>
                                    </g>
                                </svg>
                                <span class="ml-2 animate-underline-primary">Tutorial</span>
                            </a>
                            <a href="https://www.youtube.com/watch?v=zW6FwRsaxDk" target="_blank" class="fs-14 fw-700 text-primary mx-4 d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12">
                                    <path id="_17d8c74bcbdc9c556fab58cca92da0f6" data-name="17d8c74bcbdc9c556fab58cca92da0f6" d="M15.84,6.586A3.845,3.845,0,0,0,15.2,4.892a2.208,2.208,0,0,0-1.6-.721C11.363,4,8,4,8,4H8S4.638,4,2.4,4.17a2.2,2.2,0,0,0-1.6.721A3.849,3.849,0,0,0,.16,6.586,27.488,27.488,0,0,0,0,9.347v1.294A27.478,27.478,0,0,0,.16,13.4,3.838,3.838,0,0,0,.8,15.1a2.617,2.617,0,0,0,1.764.729C3.84,15.957,8,16,8,16s3.362-.006,5.6-.177a2.216,2.216,0,0,0,1.6-.723A3.844,3.844,0,0,0,15.84,13.4,27.491,27.491,0,0,0,16,10.642V9.347a27.488,27.488,0,0,0-.16-2.761ZM6,13V7l5,3Z" transform="translate(0 -3.997)" fill="#1b84ff"/>
                                </svg>
                                <span class="ml-2 animate-underline-primary">Promo</span>
                            </a>
                        </div>
                        <div class="">
                            <a href="https://activeitzone.com/" target="_blank" class="fs-12 hov-text-primary" style="color: #78829d;">www.activeitzone.com</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>