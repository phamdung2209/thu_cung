@extends('seller.layouts.app')

@section('panel_content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3">{{translate('Bids For').$product->name}}</h1>
        </div>
    </div>
</div>
<br>

<div class="card">
    <div class="card-header row gutters-5">
        <div class="col">
            <h5 class="mb-md-0 h6">{{ translate('All Bids') }}</h5>
        </div>
    </div>

    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{translate('Customer Name')}}</th>
                    <th>{{translate('Email')}}</th>
                    <th>{{translate('Phone')}}</th>
                    <th>{{translate('Bid Amount')}}</th>
                    <th>{{translate('Date')}}</th>
                    <th data-breakpoints="sm" class="text-right">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bids as $key => $bid)
                <tr>
                    <td>{{ ($key+1) + ($bids->currentPage() - 1)*$bids->perPage() }}</td>
                    <td>{{ $bid->user->name }}</td>
                    <td>{{ $bid->user->email }}</td>
                    <td>{{ $bid->user->phone }}</td>
                    <td>{{ single_price($bid->amount) }}</td>
                    <td>{{ date('d-m-Y', strtotime($bid->created_at)) }}</td>
                    <td class="text-right">
                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('product_bids_destroy.seller', $bid->id)}}" title="{{ translate('Delete') }}">
                            <i class="las la-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $bids->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
