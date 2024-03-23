@extends('frontend.layouts.app')

@section('content')
    <section class="py-8 bg-primary text-white">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 mx-auto text-center">
                    <h1 class="mb-0 fw-700">{{ translate('Premium Packages for Customers') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4 py-lg-5">
        <div class="container">
            <div class="row row-cols-xxl-4 row-cols-lg-3 row-cols-md-2 row-cols-1 gutters-10 justify-content-center">
                @foreach ($customer_packages as $key => $customer_package)
                    <div class="col">
                        <div class="card overflow-hidden rounded-0 shadow-none border">
                            <div class="card-body">
                                <!-- Package name -->
                                <div class="text-center mb-4 mt-3">
                                    <img class="mw-100 mx-auto mb-4" src="{{ uploaded_asset($customer_package->logo) }}"
                                        height="100">
                                    <h5 class="mb-3 h5 fw-600">{{ $customer_package->getTranslation('name') }}</h5>
                                </div>
                                <!-- No. of product upload -->
                                <ul class="list-group list-group-raw fs-20 mb-5">
                                    <li class="list-group-item py-2">
                                        <i class="las la-check text-success mr-2"></i>
                                        {{ $customer_package->product_upload }} {{ translate('Product Upload') }}
                                    </li>
                                </ul>
                                <!-- Amount -->
                                <div class="mb-5 d-flex align-items-center justify-content-center">
                                    @if ($customer_package->amount == 0)
                                        <span class="display-4 fw-600 lh-1 mb-0">{{ translate('Free') }}</span>
                                    @else
                                        <span
                                            class="display-4 fw-600 lh-1 mb-0">{{ single_price($customer_package->amount) }}</span>
                                    @endif

                                </div>
                                <!-- Purchase Button -->
                                <div class="text-center">
                                    @if ($customer_package->amount == 0)
                                        <button class="btn btn-primary rounded-0"
                                            onclick="get_free_package({{ $customer_package->id }})">{{ translate('Free Package') }}</button>
                                    @else
                                        @if (addon_is_activated('offline_payment'))
                                            <button class="btn btn-primary rounded-0"
                                                onclick="select_payment_type({{ $customer_package->id }})">{{ translate('Purchase Package') }}</button>
                                        @else
                                            <button class="btn btn-primary rounded-0"
                                                onclick="show_price_modal({{ $customer_package->id }})">{{ translate('Purchase Package') }}</button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('modal')

    <!-- Select Payment Type Modal -->
    <div class="modal fade" id="select_payment_type_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Select Payment Type') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="package_id" name="package_id" value="">
                    <div class="row">
                        <div class="col-md-2">
                            <label>{{ translate('Payment Type') }}</label>
                        </div>
                        <div class="col-md-10">
                            <div class="mb-3">
                                <select class="form-control aiz-selectpicker rounded-0" onchange="payment_type(this.value)"
                                    data-minimum-results-for-search="Infinity">
                                    <option value="">{{ translate('Select One') }}</option>
                                    <option value="online">{{ translate('Online payment') }}</option>
                                    <option value="offline">{{ translate('Offline payment') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-sm btn-primary rounded-0 transition-3d-hover mr-1"
                            id="select_type_cancel" data-dismiss="modal">{{ translate('Cancel') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Online payment Modal -->
    <div class="modal fade" id="price_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Purchase Your Package') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body gry-bg px-3 pt-3" style="overflow-y: inherit;">
                    <form class="" id="package_payment_form" action="{{ route('customer_packages.purchase') }}"
                        method="post">
                        @csrf
                        <input type="hidden" name="customer_package_id" value="">
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Payment Method') }}</label>
                            </div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <select class="form-control selectpicker rounded-0" data-live-search="true"
                                        name="payment_option">
                                        @if (get_setting('paypal_payment') == 1)
                                            <option value="paypal">{{ translate('Paypal') }}</option>
                                        @endif
                                        @if (get_setting('stripe_payment') == 1)
                                            <option value="stripe">{{ translate('Stripe') }}</option>
                                        @endif
                                        @if (get_setting('mercadopago_payment') == 1)
                                            <option value="mercadopago">{{ translate('Mercadopago') }}</option>
                                        @endif
                                        @if (get_setting('toyyibpay_payment') == 1)
                                            <option value="toyyibpay">{{ translate('ToyyibPay') }}</option>
                                        @endif
                                        @if (get_setting('sslcommerz_payment') == 1)
                                            <option value="sslcommerz">{{ translate('sslcommerz') }}</option>
                                        @endif
                                        @if (get_setting('instamojo_payment') == 1)
                                            <option value="instamojo">{{ translate('Instamojo') }}</option>
                                        @endif
                                        @if (get_setting('razorpay') == 1)
                                            <option value="razorpay">{{ translate('RazorPay') }}</option>
                                        @endif
                                        @if (get_setting('paystack') == 1)
                                            <option value="paystack">{{ translate('PayStack') }}</option>
                                        @endif
                                        @if (get_setting('voguepay') == 1)
                                            <option value="voguepay">{{ translate('Voguepay') }}</option>
                                        @endif
                                        @if (get_setting('payhere') == 1)
                                            <option value="payhere">{{ translate('Payhere') }}</option>
                                        @endif
                                        @if (get_setting('ngenius') == 1)
                                            <option value="ngenius">{{ translate('Ngenius') }}</option>
                                        @endif
                                        @if (get_setting('iyzico') == 1)
                                            <option value="iyzico">{{ translate('Iyzico') }}</option>
                                        @endif
                                        @if (get_setting('nagad') == 1)
                                            <option value="nagad">{{ translate('Nagad') }}</option>
                                        @endif
                                        @if (get_setting('bkash') == 1)
                                            <option value="bkash">{{ translate('Bkash') }}</option>
                                        @endif
                                        @if (get_setting('aamarpay') == 1)
                                            <option value="aamarpay">{{ translate('Amarpay') }}</option>
                                        @endif
                                        @if (get_setting('payku') == 1)
                                            <option value="payku">{{ translate('Payku') }}</option>
                                        @endif
                                        @if (addon_is_activated('paytm') && get_setting('myfatoorah') == 1)
                                            <option value="myfatoorah">{{ translate('MyFatoorah') }}</option>
                                        @endif
                                        @if (addon_is_activated('paytm') && get_setting('khalti_payment') == 1)
                                            <option value="khalti">{{ translate('Khalti') }}</option>
                                        @endif

                                        {{-- african payment gateways  --}}
                                        @if (addon_is_activated('african_pg'))
                                            @if (get_setting('mpesa') == 1)
                                                <option value="mpesa">{{ translate('Mpesa') }}</option>
                                            @endif
                                            @if (get_setting('flutterwave') == 1)
                                                <option value="flutterwave">{{ translate('Flutterwave') }}</option>
                                            @endif
                                            @if (get_setting('payfast') == 1)
                                                <option value="payfast">{{ translate('PayFast') }}</option>
                                            @endif
                                        @endif

                                        {{-- Asian payment gateways  --}}
                                        @if (addon_is_activated('paytm'))
                                            @if (get_setting('myfatoorah') == 1)
                                                <option value="myfatoorah">{{ translate('MyFatoorah') }}</option>
                                            @endif
                                            @if (get_setting('khalti_payment') == 1)
                                                <option value="khalti">{{ translate('Khalti') }}</option>
                                            @endif
                                            @if (get_setting('phonepe_payment') == 1)
                                                <option value="phonepe">{{ translate('Phonepe') }}</option>
                                            @endif
                                        @endif

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="button" class="btn btn-sm btn-secondary rounded-0 transition-3d-hover mr-1"
                                data-dismiss="modal">{{ translate('cancel') }}</button>
                            <button type="submit"
                                class="btn btn-sm btn-primary rounded-0 transition-3d-hover mr-1">{{ translate('Confirm') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- offline payment Modal -->
    <div class="modal fade" id="offline_customer_package_purchase_modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Offline Package Purchase ') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="offline_customer_package_purchase_modal_body"></div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function select_payment_type(id) {
            $('input[name=package_id]').val(id);
            $('#select_payment_type_modal').modal('show');
        }

        function payment_type(type) {
            var package_id = $('#package_id').val();
            if (type == 'online') {
                $("#select_type_cancel").click();
                show_price_modal(package_id);
            } else if (type == 'offline') {
                $("#select_type_cancel").click();
                $.post('{{ route('offline_customer_package_purchase_modal') }}', {
                    _token: '{{ csrf_token() }}',
                    package_id: package_id
                }, function(data) {
                    $('#offline_customer_package_purchase_modal_body').html(data);
                    $('#offline_customer_package_purchase_modal').modal('show');
                });
            }
        }

        function show_price_modal(id) {
            $('input[name=customer_package_id]').val(id);
            $('#price_modal').modal('show');
        }

        function get_free_package(id) {
            $('input[name=customer_package_id]').val(id);
            $('#package_payment_form').submit();
        }
    </script>
@endsection
