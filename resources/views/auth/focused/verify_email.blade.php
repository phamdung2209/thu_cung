@extends('auth.layouts.authentication')

@section('content')
    <!-- aiz-main-wrapper -->
    <div class="aiz-main-wrapper d-flex flex-column justify-content-center bg-white">
        <section class="bg-white overflow-hidden" style="min-height:100vh;">
            <div class="row no-gutters" style="min-height: 100vh;">
                <!-- Left Side -->
                <div class="col-xxl-9 col-lg-8">
                    <div class="h-100" style="max-height: 100vh">
                        <img src="{{ uploaded_asset(get_setting('password_reset_page_image')) }}" alt="{{ translate('Password Reset Page Image') }}" class="img-fit h-100">
                    </div>
                </div>
                
                <!-- Right Side Image -->
                <div class="col-xxl-3 col-lg-4">
                    <div class="d-flex align-items-center right-content">
                        <div class="py-3 py-lg-4 px-3 px-xl-5 flex-grow-1">
                            <!-- Site Icon -->
                            <div class="size-48px mb-3 mx-auto mx-lg-0">
                                <img src="{{ uploaded_asset(get_setting('site_icon')) }}" alt="{{ translate('Site Icon')}}" class="img-fit h-100">
                            </div>

                            <!-- Titles -->
                            <div class="text-center text-lg-left">
                                <h1 class="fs-20 fs-md-20 fw-700 text-primary" style="text-transform: uppercase;">{{ translate('Verify Your Email Address') }}</h1>
                                <h5 class="fs-14 fw-400 text-dark">
                                    {{ translate('Before proceeding, please check your email for a verification link. If you did not receive the email.') }}
                                </h5>
                            </div>

                            <!-- Reset password form -->
                            <div class="pt-3 pt-lg-4">
                                <div class="">
                                    <a href="{{ route('verification.resend') }}" class="btn btn-primary btn-block">{{ translate('Click here to request another') }}</a>
                                    @if (session('resent'))
                                        <div class="alert alert-success mt-2 mb-0" role="alert">
                                            {{ translate('A fresh verification link has been sent to your email address.') }}
                                        </div>
                                    @endif
                                </div>
                                <!-- Go Back -->
                                <a href="{{ url()->previous() }}" class="mt-3 fs-14 fw-700 d-flex align-items-center text-primary" style="max-width: fit-content;">
                                    <i class="las la-arrow-left fs-20 mr-1"></i>
                                    {{ translate('Back to Previous Page')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection