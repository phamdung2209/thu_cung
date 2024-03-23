@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('All Coupons')}}</h1>
		</div>
        @can('add_coupon')
            <div class="col-md-6 text-md-right">
                <a href="{{ route('coupon.create') }}" class="btn btn-circle btn-info">
                    <span>{{translate('Add New Coupon')}}</span>
                </a>
            </div>
        @endcan
	</div>
</div>

<div class="card">
  <div class="card-header">
      <h5 class="mb-0 h6">{{translate('Coupon Information')}}</h5>
  </div>
  <div class="card-body">
      <table class="table aiz-table p-0">
            <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th>{{translate('Code')}}</th>
                    <th data-breakpoints="lg">{{translate('Type')}}</th>
                    <th data-breakpoints="lg">{{translate('Start Date')}}</th>
                    <th data-breakpoints="lg">{{translate('End Date')}}</th>
                    <th data-breakpoints="lg">{{translate('Validation Days')}}</th>
                    <th data-breakpoints="lg">{{translate('Status')}}</th>
                    <th width="10%" class="text-right">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coupons as $key => $coupon)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$coupon->code}}</td>
                        <td>
                            {{ translate(Str::headline($coupon->type)) }}
                        </td>
                        <td>{{ $coupon->type != 'welcome_base' ? date('d-m-Y', $coupon->start_date) : '' }}</td>
                        <td>{{ $coupon->type != 'welcome_base' ? date('d-m-Y', $coupon->end_date) : '' }}</td>
                        <td>
                            @if($coupon->type == 'welcome_base')
                                {{ json_decode($coupon->details)->validation_days }}
                            @endif
                        </td>
                        <td>
                            @if($coupon->type == 'welcome_base')
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input onchange="updateCouponStatus(this)" value="{{ $coupon->id }}" type="checkbox" <?php if ($coupon->status == 1) echo "checked"; ?> >
                                    <span class="slider round"></span>
                                </label>
                            @endif
                        </td>
						<td class="text-right">
                            @can('edit_coupon')
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('coupon.edit', encrypt($coupon->id) )}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                            @endcan
                            @can('delete_coupon')
                                @if($coupon->type != 'welcome_base')
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('coupon.destroy', $coupon->id)}}" title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function updateCouponStatus(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('coupon.update_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Coupon Status updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
                location.reload();
            });
        }
    </script>
@endsection
