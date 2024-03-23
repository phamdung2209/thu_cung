@extends('backend.layouts.app')

@section('content')
	<div class="row">
		<div class="col-lg-8 col-xxl-6 mx-auto">
			<div class="card">
				<div class="card-header d-block d-md-flex">
					<h3 class="h6 mb-0">{{ translate('Import Demo Data') }}</h3>
					<span>{{ translate('Current verion') }}: {{ get_setting('current_version') }}</span>
				</div>
				<div class="card-body">
					<div class="alert alert-warning mb-5">
						<ul class="mb-0">
							<li class="">
								{{ translate('Make sure your server has matched with all requirements.') }}
								<a href="{{route('system_server')}}">{{ translate('Check Here') }}</a>
							</li>
							<li class="">{{ translate('It may take some times to upload so do not close the browser or tab.') }}</li>
							<li class="">{{ translate('If you have previous data, then it may conflicts with some of your current data.') }}</li>
							<li class="">{{ translate('Make sure you have activated your system with the domain and site URL.') }}</li>
						</ul>
					</div>
					<form action="{{ route('import_data') }}" method="post" enctype="multipart/form-data">
						@csrf
						<!-- Product Name -->
						<div class="form-group row">
							<label class="col-xxl-3 col-from-label fs-13">{{translate('Product Name')}} <span class="text-danger">*</span></label>
							<div class="col-xxl-9">
								<select name="layout" class="form-control aiz-selectpicker mb-2 mb-md-0" required>
                                    <option value="classic">Classic</option>
                                    <!--<option value="metro">Metro</option>-->
                                    <!--<option value="minima">Minima</option>-->
                                </select>
							</div>
						</div>
						<!-- Purchase Code -->
						<div class="form-group row">
							<label class="col-xxl-3 col-from-label fs-13">{{translate('Purchase Code')}} <span class="text-danger">*</span></label>
							<div class="col-xxl-9">
								<input type="text" class="form-control" name="purchase_key" placeholder="{{ translate('CodeCanyon Purchase Code') }}" required>
							</div>
						</div>
						<!-- Domain Name -->
						<div class="form-group row">
							<label class="col-xxl-3 col-from-label fs-13">{{translate('Domain Name')}} <span class="text-danger">*</span></label>
							<div class="col-xxl-9">
								<input type="text" class="form-control" name="domain" value="{{ request()->getHost() }}" placeholder="{{ translate('Domain Name (example: abcd.com)') }}" required>
							</div>
						</div>
						<!-- Main Site URL -->
						<div class="form-group row">
							<label class="col-xxl-3 col-from-label fs-13">{{translate('Site URL')}} <span class="text-danger">*</span></label>
							<div class="col-xxl-9">
								<input type="text" class="form-control" name="main_url" value="{{ URL::to('/') }}" placeholder="{{ translate('Site URL (example: https://www.abcd.com or https://abcd.com)') }}" required>
							</div>
						</div>
						<!-- Submit button -->
						<div class="d-flex justify-content-end mt-4">
							<button type="submit" class="btn btn-install mt-3">
								<i class="las la-2x la-cloud-upload-alt mr-3"></i>
								{{ translate('Import') }}
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
