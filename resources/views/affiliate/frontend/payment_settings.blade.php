@extends('frontend.layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')

                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="fs-20 fw-700 text-dark">{{ translate('Affiliate') }}</h1>
                            </div>
                        </div>
                    </div>

                    <div class="card rounded-0 shadow-none border">
                        <div class="card-header border-bottom-0">
                            <h5 class="mb-0 fs-18 fw-700 text-dark">{{ translate('Payment Settings')}}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('affiliate.payment_settings_store') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">{{translate('Paypal Email')}}</label>
                                    <div class="col-md-10">
                                        <input type="email" class="form-control rounded-0" placeholder="{{ translate('Paypal Email')}}" name="paypal_email" value="{{ $affiliate_user->paypal_email }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">{{translate('Bank Informations')}}</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control rounded-0" placeholder="{{ translate('Acc. No, Bank Name etc')}}" name="bank_information" value="{{ $affiliate_user->bank_information }}">
                                    </div>
                                </div>
                                <div class="form-group mb-0 text-right">
                                    <button type="submit" class="btn btn-primary rounded-0">{{translate('Update Payment Settings')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
