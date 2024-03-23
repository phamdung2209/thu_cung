@php
    $coupon_details = json_decode($coupon->details);
@endphp
<div class="card-header mb-2">
    <h3 class="h6">{{translate('Edit Your Customer Welcome Coupon')}}</h3>
</div>
<div class="form-group row">
    <label class="col-lg-3 col-from-label" for="code">{{translate('Coupon code')}}</label>
    <div class="col-lg-9">
        <input type="text" class="form-control" id="code" name="code" value="{{$coupon->code}}" placeholder="{{translate('Coupon code')}}" required>
    </div>
</div>
<div class="form-group row">
    <label class="col-lg-3 col-from-label">{{translate('Minimum Shopping')}}</label>
    <div class="col-lg-9">
       <input type="number" lang="en" value="{{ $coupon_details->min_buy }}" min="0" step="0.01" placeholder="{{translate('Minimum Shopping')}}" name="min_buy" class="form-control" required>
    </div>
</div>
<div class="form-group row">
    <label class="col-lg-3 col-from-label">{{translate('Discount')}}</label>
    <div class="col-lg-7">
        <input type="number" lang="en" min="0" step="0.01" placeholder="{{translate('Discount')}}" name="discount" class="form-control" value="{{ $coupon->discount }}" required>
    </div>
    <div class="col-lg-2">
        <select class="form-control aiz-selectpicker" name="discount_type">
            <option value="amount" @if ($coupon->discount_type == 'amount') selected  @endif >{{translate('Amount')}}</option>
            <option value="percent" @if ($coupon->discount_type == 'percent') selected  @endif>{{translate('Percent')}}</option>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 control-label" for="start_date">{{translate('Validation Days')}}</label>
    <div class="col-sm-9">
      <div class="input-group">
        <input type="number" class="form-control" name="validation_days" value="{{ $coupon_details ->validation_days }}" min="1" step="1" placeholder="{{ translate('Validation Days') }}">
        <div class="input-group-prepend">
            <span class="input-group-text">{{ translate('Days') }}</span>
        </div>
    </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('.aiz-selectpicker').selectpicker();
        $('.aiz-date-range').daterangepicker();
    });
</script>
