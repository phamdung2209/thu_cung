@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3 pb-2 border-bottom border-gray">
	<div class="row align-items-center">
		<div class="col">
			<h1 class="h3">{{ translate('Select Homepage') }}</h1>
		</div>
		{{-- <div class="col text-right">
			<a class="btn has-transition btn-xs btn-light hov-svg-danger rounded-0" href="{{ route('home') }}" 
				target="_blank" data-toggle="tooltip" data-placement="top" data-title="{{ translate('View Tutorial Video') }}">
				<svg xmlns="http://www.w3.org/2000/svg" width="19.887" height="16" viewBox="0 0 19.887 16">
					<path id="_42fbab5a39cb8436403668a76e5a774b" data-name="42fbab5a39cb8436403668a76e5a774b" d="M18.723,8H5.5A3.333,3.333,0,0,0,2.17,11.333v9.333A3.333,3.333,0,0,0,5.5,24h13.22a3.333,3.333,0,0,0,3.333-3.333V11.333A3.333,3.333,0,0,0,18.723,8Zm-3.04,8.88-5.47,2.933a1,1,0,0,1-1.473-.88V13.067a1,1,0,0,1,1.473-.88l5.47,2.933a1,1,0,0,1,0,1.76Zm-5.61-3.257L14.5,16l-4.43,2.377Z" transform="translate(-2.17 -8)" fill="#9da3ae"/>
				</svg>
			</a>
		</div> --}}
	</div>
</div>
<div class="">
	<div class="card rounded-0">
		<div class="card-body p-2rem">
			<form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="types[]" value="homepage_select">
				<div class="row">
					<!-- Home Classic -->
					<div class="col-xxl-3 col-lg-4 col-sm-6 my-3">
						<label class="aiz-megabox d-block mb-3">
							<input value="classic" type="radio" name="homepage_select" @if((get_setting('homepage_select') == null) || (get_setting('homepage_select') == 'classic')) checked @endif>
							<span class="d-block aiz-megabox-elem rounded-0 img-overlay">
								<div class="h-350px w-100 overflow-hidden">
									<img src="{{ static_asset('assets/img/pages/home-classic.png') }}" class="w-100" alt="home-page">
								</div>
							</span>
						</label>
						<div class="d-flex flex-wrap justify-content-between align-items-center">
							<span class="fs-14 fw-500 text-dark">{{ translate('Homepage 1 - Classic') }}</span>
							<span>
								<a href="javascript:void(0);" class="btn btn-xs btn-danger rounded-0" 
									onclick="imageShowOverlay('{{ static_asset('assets/img/pages/home-classic.png') }}')">{{ translate('View') }}</a>
							</span>
						</div>
					</div>
					<!-- Home Metro -->
					<div class="col-xxl-3 col-lg-4 col-sm-6 my-3">
						<label class="aiz-megabox d-block mb-3">
							<input value="metro" type="radio" name="homepage_select" @if(get_setting('homepage_select') == 'metro') checked @endif>
							<span class="d-block aiz-megabox-elem rounded-0 img-overlay">
								<div class="h-350px w-100 overflow-hidden">
									<img src="{{ static_asset('assets/img/pages/home-metro.png') }}" class="w-100" alt="home-page">
								</div>
							</span>
						</label>
						<div class="d-flex flex-wrap justify-content-between align-items-center">
							<span class="fs-14 fw-500 text-dark">{{ translate('Homepage 2 - Metro') }}</span>
							<span>
								<a href="javascript:void(0);" class="btn btn-xs btn-danger rounded-0"
									onclick="imageShowOverlay('{{ static_asset('assets/img/pages/home-metro.png') }}')">{{ translate('View') }}</a>
							</span>
						</div>
					</div>
					<!-- Home Minima -->
					<div class="col-xxl-3 col-lg-4 col-sm-6 my-3">
						<label class="aiz-megabox d-block mb-3">
							<input value="minima" type="radio" name="homepage_select" @if(get_setting('homepage_select') == 'minima') checked @endif>
							<span class="d-block aiz-megabox-elem rounded-0 img-overlay">
								<div class="h-350px w-100 overflow-hidden">
									<img src="{{ static_asset('assets/img/pages/home-minima.png') }}" class="w-100" alt="home-page">
								</div>
							</span>
						</label>
						<div class="d-flex flex-wrap justify-content-between align-items-center">
							<span class="fs-14 fw-500 text-dark">{{ translate('Homepage 3 - Minima') }}</span>
							<span>
								<a href="javascript:void(0);" class="btn btn-xs btn-danger rounded-0"
									onclick="imageShowOverlay('{{ static_asset('assets/img/pages/home-minima.png') }}')">{{ translate('View') }}</a>
							</span>
						</div>
					</div>
				</div>
				<div class="row bg-light p-3 mt-5">
					<div class="col-md-8 d-none d-md-block">
						<div class="d-flex align-items-center">
							<div class="text-secondary mr-3"><i class="las la-4x la-sliders-h"></i></div>
							<div>
								<h4 class="fs-16 text-secondary">{{ translate('Configure your page layout') }}</h4>
								<small class="fs-12 text-secondary">{{ translate('Each page contain different layout, choose one to bundle it in your Layout.') }}</small>
							</div>
						</div>
					</div>
					<div class="col-md-4 d-flex align-items-center justify-content-end">
						<!-- Save Button -->
						<button type="submit" class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Save') }}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('modal')
	<div class="image-show-overlay" id="image-show-overlay">
		<div class="d-flex justify-content-end my-3 mr-3">
			<button type="button" class="btn text-white d-flex align-items-center justify-content-center"><i class="las la-2x la-times"></i></button>
		</div>
		<div class="overlay-img">
			<img src="{{ static_asset('assets/img/pages/home-metro.png') }}" class="w-100" alt="img-show">
		</div>
	</div>
@endsection

@section('script')
	<script>
		function imageShowOverlay(img){
			$('#image-show-overlay .overlay-img img').attr('src', '').prop('src', img);
			$('#image-show-overlay').addClass('show');
			$('.aiz-main-wrapper').css('height', '100vh');
			$('.aiz-main-wrapper').css('overflow-y', 'hidden');
		}

		$('#image-show-overlay .btn').click(function(){
			imageHideOverlay();
		});

		$('.overlay-img').click(function(e){
			if (e.target.closest('.overlay-img img')) {
				e.stopPropagation();
				return false;
			}
			imageHideOverlay();
		});

		function imageHideOverlay(){
			if($('#image-show-overlay').hasClass('show')){
				$('#image-show-overlay').removeClass('show');
			}
			$('.aiz-main-wrapper').css('height', '100%');
			$('.aiz-main-wrapper').css('overflow-y', 'auto');
		}
	</script>
@endsection
