@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3">{{translate('All Auction products')}}</h1>
        </div>
        <div class="col text-right">
            <a href="{{ route('auction_product_create.admin') }}" class="btn btn-circle btn-info">
                <span>{{translate('Add New Auction Product')}}</span>
            </a>
        </div>
    </div>
</div>
<br>

<div class="card">
    <form class="" id="sort_products" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">{{ translate('All Auction Product') }}</h5>
            </div>

            @if($type == 'seller')
            <div class="col-md-2 ml-auto">
                <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" id="user_id" name="user_id" onchange="sort_products()">
                    <option value="">{{ translate('All Sellers') }}</option>
                    @foreach (App\Models\Seller::all() as $key => $seller)
                        @if ($seller->user != null && $seller->user->shop != null)
                            <option value="{{ $seller->user->id }}" @if ($seller->user->id == $seller_id) selected @endif>{{ $seller->user->shop->name }} ({{ $seller->user->name }})</option>
                        @endif
                    @endforeach
                </select>
            </div>
            @endif
            @if($type == 'all')
            <div class="col-md-2 ml-auto">
                <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" id="user_id" name="user_id" onchange="sort_products()">
                    <option value="">{{ translate('All Sellers') }}</option>
                        @foreach (App\Models\User::where('user_type', '=', 'admin')->orWhere('user_type', '=', 'seller')->get() as $key => $seller)
                            <option value="{{ $seller->id }}" @if ($seller->id == $seller_id) selected @endif>{{ $seller->name }}</option>
                        @endforeach
                </select>
            </div>
            @endif
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
                        @if($type == 'all' || $type == 'seller')
                        <th data-breakpoints="sm">{{translate('Added By')}}</th>
                        @endif
                        <th data-breakpoints="sm">{{translate('Bid Starting Amount')}}</th>
                        <th data-breakpoints="sm">{{translate('Auction Start Date')}}</th>
                        <th data-breakpoints="sm">{{translate('Auction End Date')}}</th>
                        <th data-breakpoints="sm">{{translate('Total Bids')}}</th>
                        @if(get_setting('product_approve_by_admin') == 1 && $type == 'seller')
                            <th data-breakpoints="lg">{{translate('Approved')}}</th>
                        @endif
                        <th data-breakpoints="sm" class="text-right">{{translate('Options')}}</th>
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
                        @if($type == 'seller' || $type == 'all')
                            <td>{{ $product->user->name }}</td>
                        @endif
                        <td>{{ single_price($product->starting_bid) }}</td>
                        <td>{{ date('Y-m-d H:i:s', $product->auction_start_date) }}</td>
                        <td>{{ date('Y-m-d H:i:s', $product->auction_end_date) }}</td>
                        <td>{{ $product->bids->count() }}</td>
                        @if(get_setting('product_approve_by_admin') == 1 && $type == 'seller')
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input onchange="update_approved(this)" value="{{ $product->id }}" type="checkbox" <?php if ($product->approved == 1) echo "checked"; ?> >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                        @endif
                        <td class="text-right">
                            @if($product->auction_start_date > strtotime("now"))
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('auction_product_edit.admin', ['id'=>$product->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                            @endif
                            <a class="btn btn-soft-success btn-icon btn-circle btn-sm"  href="{{ route('auction-product', $product->slug) }}" target="_blank" title="{{ translate('View Products') }}">
                                <i class="las la-eye"></i>
                            </a>
                            <a class="btn btn-soft-info btn-icon btn-circle btn-sm"  href="{{ route('product_bids.admin', $product->id) }}" target="_blank" title="{{ translate('View All Bids') }}">
                                <i class="las la-gavel"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('auction_product_destroy.admin', $product->id)}}" title="{{ translate('Delete') }}">
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

        function update_approved(el){
            if(el.checked){
                var approved = 1;
            }
            else{
                var approved = 0;
            }
            $.post('{{ route('products.approved') }}', {
                _token      :   '{{ csrf_token() }}', 
                id          :   el.value, 
                approved    :   approved
            }, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Product approval update successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
        
    </script>
@endsection
