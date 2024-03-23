@extends('frontend.layouts.app')

@section('content')
@php
    $seller_package = get_single_seller_package(Session::get('payment_data')['seller_package_id']);
@endphp
   

@endsection

@section('script')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "{{ env('RAZOR_KEY') }}", // Enter the Key ID generated from the Dashboard
        "amount": "{{ $seller_package->amount*100}}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
        "currency": "INR",
        "name": "{{ env('APP_NAME') }}", //your business name
        "description": "{{ Session::get('payment_type') }}",
        "image": "{{ uploaded_asset(get_setting('header_logo')) }}",
        "order_id": "{{ $res->id }}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
        "callback_url": "{{ route('payment.rozer') }}",
        "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
            "name": "{{ Auth::user()->name }}", //your customer's name
            "email": "{{ Auth::user()->email ?? '' }}",
            // "contact": "9000090000" //Provide the customer's phone number for better conversion rates 
        },
        "notes": {
            "user_id": "{{ auth()->id() }}"
        },
        "theme": {
            "color": "#ff7529"
        }
    };
    var rzp1 = new Razorpay(options);   

    $(document).ready(function() {
        rzp1.open();
        e.preventDefault();
    });
    $('#modal-close').click(function(){
        window.location = "{{ route('wallet.index') }}";
    });
</script>
@endsection
