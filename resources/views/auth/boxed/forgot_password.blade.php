<!-- aiz-main-wrapper -->
<div class="aiz-main-wrapper d-flex flex-column justify-content-md-center bg-white">
    <section class="bg-white overflow-hidden">
        <div class="row">
            <div class="col-xxl-6 col-xl-9 col-lg-10 col-md-7 mx-auto py-lg-4">
                <div class="card shadow-none rounded-0 border-0">
                    <div class="row no-gutters">
                        <!-- Left Side Image-->
                        <div class="col-lg-6">
                            <img src="{{ uploaded_asset(get_setting('forgot_password_page_image')) }}" alt="{{ translate('Forgot Password Page Image') }}" class="img-fit h-100">
                        </div>

                        <div class="col-lg-6 p-4 p-lg-5 d-flex flex-column justify-content-center border right-content" style="height: auto;">
                            <!-- Site Icon -->
                            <div class="size-48px mb-3 mx-auto mx-lg-0">
                                <img src="{{ uploaded_asset(get_setting('site_icon')) }}" alt="{{ translate('Site Icon')}}" class="img-fit h-100">
                            </div>

                            <!-- Titles -->
                            <div class="text-center text-lg-left">
                                <h1 class="fs-20 fs-md-20 fw-700 text-primary" style="text-transform: uppercase;">{{ translate('Forgot password?') }}</h1>
                                <h5 class="fs-14 fw-400 text-dark">
                                    {{ addon_is_activated('otp_system') ? 
                                        translate('Enter your email address or phone number to recover your password.') :
                                            translate('Enter your email address to recover your password.') }}
                                </h5>
                            </div>

                            <!-- Send password reset link or code form -->
                            <div class="pt-3">
                                <div class="">
                                    <form class="form-default" role="form" action="{{ route('password.email') }}" method="POST">
                                        @csrf
                                        
                                        <!-- Email or Phone -->
                                        @if (addon_is_activated('otp_system'))
                                            <div class="form-group phone-form-group mb-1">
                                                <label for="phone" class="fs-12 fw-700 text-soft-dark">{{  translate('Phone') }}</label>
                                                <input type="tel" id="phone-code" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }} rounded-0" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                                            </div>

                                            <input type="hidden" name="country_code" value="">
                                            
                                            <div class="form-group email-form-group mb-1 d-none">
                                                <label for="email" class="fs-12 fw-700 text-soft-dark">{{  translate('Email') }}</label>
                                                <input type="email" class="form-control rounded-0 {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('johndoe@example.com') }}" name="email" id="email" autocomplete="off">
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <div class="form-group text-right">
                                                <button class="btn btn-link p-0 text-primary" type="button" onclick="toggleEmailPhone(this)"><i>*{{ translate('Use Email Instead') }}</i></button>
                                            </div>
                                        @else
                                            <div class="form-group">
                                                <label for="email" class="fs-12 fw-700 text-soft-dark">{{  translate('Email') }}</label>
                                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} rounded-0" value="{{ old('email') }}" placeholder="{{  translate('johndoe@example.com') }}" name="email" id="email" autocomplete="off">
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Submit Button -->
                                        <div class="mb-4 mt-4">
                                            <button type="submit" class="btn btn-primary btn-block fw-700 fs-14 rounded-0">{{ translate('Send Password Reset Link') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Go Back -->
                    <div class="mt-3 mr-4 mr-md-0">
                        <a href="{{ url()->previous() }}" class="ml-auto fs-14 fw-700 d-flex align-items-center text-primary" style="max-width: fit-content;">
                            <i class="las la-arrow-left fs-20 mr-1"></i>
                            {{ translate('Back to Previous Page')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>