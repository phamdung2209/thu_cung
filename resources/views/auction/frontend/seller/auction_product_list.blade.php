@extends('seller.layouts.app')

@section('panel_content')
<div class="row gutters-10 justify-content-center">
    @if (addon_is_activated('seller_subscription'))
        <div class="col-md-4 mx-auto mb-3" >
            <div class="bg-grad-1 text-white rounded-lg overflow-hidden">
              <span class="size-30px rounded-circle mx-auto bg-soft-primary d-flex align-items-center justify-content-center mt-3">
                  <i class="las la-upload la-2x text-white"></i>
              </span>
              <div class="px-3 pt-3 pb-3">
                    <div class="h4 fw-700 text-center">
                        {{ Auth::user()->shop->seller_package != null ? Auth::user()->shop->seller_package->product_upload_limit - Auth::user()->products()->count() : 0 }}
                    </div>
                  <div class="opacity-50 text-center">{{  translate('Remaining Uploads') }}</div>
              </div>
            </div>
        </div>
    @endif

    <div class="col-md-4 mx-auto mb-3" >
        <a href="{{ route('auction_product_create.seller')}}">
          <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
              <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                  <i class="las la-plus la-3x text-white"></i>
              </span>
              <div class="fs-18 text-primary">{{ translate('Add New Auction Product') }}</div>
          </div>
        </a>
    </div>

    @if (addon_is_activated('seller_subscription'))
    @php
        $seller_package = \App\Models\SellerPackage::find(Auth::user()->shop->seller_package_id);
    @endphp
    <div class="col-md-4">
        <a href="{{ route('seller.seller_packages_list') }}" class="text-center bg-white shadow-sm hov-shadow-lg text-center d-block p-3 rounded">
            @if($seller_package != null)
                <img src="{{ uploaded_asset($seller_package->logo) }}" height="44" class="mw-100 mx-auto">
                <span class="d-block sub-title mb-2">{{ translate('Current Package')}}: {{ $seller_package->getTranslation('name') }}</span>
            @else
                <i class="la la-frown-o mb-2 la-3x"></i>
                <div class="d-block sub-title mb-2">{{ translate('No Package Found')}}</div>
            @endif
            <div class="btn btn-outline-primary py-1">{{ translate('Upgrade Package')}}</div>
        </a>
    </div>
    @endif

</div>
<div class="card">
    <form class="" id="sort_products" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">{{ translate('All Auction Product') }}</h5>
            </div>

            <div class="col-md-2">
                <div class="form-group mb-0">
                    <input type="text" class="form-control form-control-sm" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type & Enter') }}">
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{translate('Name')}}</th>
                        <th data-breakpoints="sm">{{translate('Bid Starting Amount')}}</th>
                        <th data-breakpoints="sm">{{translate('Auction Start Date')}}</th>
                        <th data-breakpoints="sm">{{translate('Auction End Date')}}</th>
                        <th data-breakpoints="sm">{{translate('Total Bids')}}</th>
                        <th data-breakpoints="sm" class="text-right" width="20%">{{translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $key => $product)
                    <tr>
                        <td>{{ ($key+1) + ($products->currentPage() - 1)*$products->perPage() }}</td>
                        <td>
                            <div class="row gutters-5 w-200px w-md-300px mw-100">
                                <div class="col-auto">
                                    <img src="{{ uploaded_asset($product->thumbnail_img)}}" alt="Image" class="size-50px img-fit">
                                </div>
                                <div class="col">
                                    <span class="text-muted text-truncate-2">{{ $product->getTranslation('name') }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ single_price($product->starting_bid) }}</td>
                        <td>{{ date('Y-m-d H:i:s', $product->auction_start_date) }}</td>
                        <td>{{ date('Y-m-d H:i:s', $product->auction_end_date) }}</td>
                        <td>{{ $product->bids->count() }}</td>
                        <td class="text-right">
                            @if($product->auction_start_date > strtotime("now"))
                                <a class="btn btn-soft-info btn-icon btn-circle btn-sm" href="{{route('auction_product_edit.seller', ['id'=>$product->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                            @endif
                            <a class="btn btn-soft-success btn-icon btn-circle btn-sm"  href="{{ route('auction-product', $product->slug) }}" target="_blank" title="{{ translate('View Products') }}">
                                <i class="las la-eye"></i>
                            </a>
                            <a class="btn btn-soft-info btn-icon btn-circle btn-sm"  href="{{ route('product_bids.seller', $product->id) }}" target="_blank" title="{{ translate('View All Bids') }}">
                                <i class="las la-gavel"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('auction_product_destroy.seller', $product->id)}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $products->appends(request()->input())->links() }}
            </div>
        </div>
    </form>
</div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection


@section('script')
    <script type="text/javascript">
        function sort_products(el){
            $('#sort_products').submit();
        }
    </script>
@endsection
