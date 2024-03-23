@extends('seller.layouts.app')

@section('panel_content')
    <div class="card">
        <form class="" id=" sort_orders" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('Inhouse Orders') }}</h5>
                </div>
                <div class="col-lg-3 ml-auto">
                    <select class="form-control aiz-selectpicker" name="payment_type" id="payment_type"
                        onchange="sort_orders()">
                        <option value="">{{ translate('Filter by Payment Status') }}</option>
                        <option value="paid" @isset($payment_status) @if ($payment_status == 'paid') selected @endif @endisset>
                            {{ translate('Paid') }}</option>
                        <option value="unpaid" @isset($payment_status) @if ($payment_status == 'unpaid') selected @endif @endisset>
                            {{ translate('Un-Paid') }}</option>
                    </select>
                </div>

                <div class="col-lg-3 ml-auto">
                    <select class="form-control aiz-selectpicker" name="delivery_status" id="delivery_status"
                        onchange="sort_orders()">
                        <option value="">{{ translate('Filter by Deliver Status') }}</option>
                        <option value="pending" @isset($delivery_status) @if ($delivery_status == 'pending') selected @endif @endisset>
                            {{ translate('Pending') }}</option>
                        <option value="confirmed" @isset($delivery_status) @if ($delivery_status == 'confirmed') selected @endif @endisset>
                            {{ translate('Confirmed') }}</option>
                        <option value="on_delivery" @isset($delivery_status) @if ($delivery_status == 'on_delivery') selected @endif @endisset>
                            {{ translate('On delivery') }}</option>
                        <option value="delivered" @isset($delivery_status) @if ($delivery_status == 'delivered') selected @endif @endisset>
                            {{ translate('Delivered') }}</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="search" name="search" @isset($sort_search)
                            value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type Order code & hit Enter') }}">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Order Code') }}</th>
                        <th data-breakpoints="md">{{ translate('Customer') }}</th>
                        <th data-breakpoints="md">{{ translate('Amount') }}</th>
                        <th data-breakpoints="md">{{ translate('Delivery Status') }}</th>
                        <th data-breakpoints="md">{{ translate('Payment Method') }}</th>
                        <th data-breakpoints="md">{{ translate('Payment Status') }}</th>
                        @if (addon_is_activated('refund_request'))
                            <th>{{ translate('Refund') }}</th>
                        @endif
                        <th class="text-right" width="15%">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order_id)
                        @php
                            $order = \App\Models\Order::find($order_id->id);
                        @endphp
                        @if ($order != null)
                            <tr>
                                <td>
                                    {{ $key + 1 + ($orders->currentPage() - 1) * $orders->perPage() }}
                                </td>
                                <td>
                                    {{ $order->code }}@if ($order->viewed == 0) <span class="badge badge-inline badge-info">{{ translate('New') }}</span>@endif
                                </td>
                                <td>
                                    @if ($order->user != null)
                                        {{ $order->user->name }}
                                    @else
                                        Guest ({{ $order->guest_id }})
                                    @endif
                                </td>
                                <td>
                                    {{ single_price($order->grand_total) }}
                                </td>
                                <td>
                                    @php
                                        $status = $order->delivery_status;
                                    @endphp
                                    {{ translate(ucfirst(str_replace('_', ' ', $status))) }}
                                </td>
                                <td>
                                    {{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}
                                </td>
                                <td>
                                    @if ($order->payment_status == 'paid')
                                        <span class="badge badge-inline badge-success">{{ translate('Paid') }}</span>
                                    @else
                                        <span class="badge badge-inline badge-danger">{{ translate('Unpaid') }}</span>
                                    @endif
                                </td>
                                @if (addon_is_activated('refund_request'))
                                    <td>
                                        @if (count($order->refund_requests) > 0)
                                            {{ count($order->refund_requests) }} {{ translate('Refund') }}
                                        @else
                                            {{ translate('No Refund') }}
                                        @endif
                                    </td>
                                @endif

                                <td class="text-right">
                                    <a href="javascript:void(0)" class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                        onclick="show_order_details({{ $order->id }})"
                                        title="{{ translate('Order Details') }}">
                                        <i class="las la-eye"></i>
                                    </a>
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        href="{{ route('invoice.download', $order->id) }}"
                                        title="{{ translate('Download Invoice') }}">
                                        <i class="las la-download"></i>
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $orders->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')

    <div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function sort_orders(el) {
            $('#sort_orders').submit();
        }

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
