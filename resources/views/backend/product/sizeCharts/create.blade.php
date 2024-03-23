@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{ translate('Add New Size Chart') }}</h5>
    </div>
    <div class="">
        <!-- Error Meassages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form class="form form-horizontal mar-top" action="{{ route('size-charts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row gutters-5">
                <!-- Size Chart Information -->
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Size Chart Information') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{translate('Chart Name')}} <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="name" placeholder="{{ translate('Chart Name') }}" required>
                                </div>
                            </div>
                            <!-- Category -->
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Category') }} <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" name="category_id" id="category_id" data-live-search="true" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                                            @foreach ($category->childrenCategories as $childCategory)
                                                @include('categories.child_category', ['child_category' => $childCategory])
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Images -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Images') }}</label>
                                <div class="col-md-8">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="photos" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                    <small class="text-muted">{{translate('These images are visible in product size gide beside size description.')}}</small>
                                </div>
                            </div>
                            <!-- Size Description -->
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{translate('Size Description')}}</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" name="description" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Size Configuration -->
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{translate('Size Configuration')}}</h5>
                        </div>
                        <div class="card-body">
                            <!-- Fit Type -->
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Fit Type') }}</label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" name="fit_type">
                                        <option value="">{{ translate('Select Fit Type') }}</option>
                                        <option value="slim_fit">{{ translate('Slim Fit') }}</option>
                                        <option value="regular_fit">{{ translate('Regular Fit') }}</option>
                                        <option value="relaxed">{{ translate('Relaxed') }}</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Stretch Type -->
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Stretch Type') }}</label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" name="stretch_type">
                                        <option value="">{{ translate('Select Stretch Type') }}</option>
                                        <option value="non">{{ translate('Non') }}</option>
                                        <option value="slight">{{ translate('Slight') }}</option>
                                        <option value="medium">{{ translate('Medium') }}</option>
                                        <option value="hign">{{ translate('Hign') }}</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Measurement Points -->
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Measurement Points') }} <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" onchange="size_combination()" name="measurement_points[]" id="measurement_points" data-selected-text-format="count" data-live-search="true" multiple data-placeholder="{{ translate('Choose Measurement Points') }}" required>
                                        @foreach ($measurementPoints as $measurementPoint)
                                            <option value="{{ $measurementPoint->id }}">{{ $measurementPoint->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Size Options -->
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Size Options') }} <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" onchange="size_combination()" name="size_options[]" id="size_options" data-selected-text-format="count" data-live-search="true" multiple data-placeholder="{{ translate('Choose Size Options') }}" required>
                                        @foreach ($sizeOptions as $sizeOption)
                                            <option value="{{ $sizeOption->id }}">{{ $sizeOption->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Measurement Type -->
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Measurement Type') }}</label>
                                <div class="col-md-8">
                                    <label class="aiz-checkbox mr-4">
                                        <input type="checkbox" name="measurement_option[]" value="inch" id="measurement_option_inch" onchange="size_combination()" checked>
                                        <span class="has-transition fs-12 fw-400 text-gray-dark hov-text-primary">{{  translate('Inches') }}</span>
                                        <span class="aiz-square-check"></span>
                                    </label>
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="measurement_option[]" value="cen" id="measurement_option_cen" onchange="size_combination()">
                                        <span class="has-transition fs-12 fw-400 text-gray-dark hov-text-primary">{{  translate('Centimeter') }}</span>
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Size Combination')}}</h5>
                </div>
                <div class="card-body">
                    <div id="size-combination_body"></div>
                </div>
            </div>
                
            <!-- Button -->
            <div class="btn-toolbar float-right mb-3" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group" role="group" aria-label="Second group">
                    <button type="submit" class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Save') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function size_combination(){
            $("#size-combination_body").html('');
            let measurement_points = $('#measurement_points').val();
            let size_options = $('#size_options').val();
            let measurement_option_inch = $('#measurement_option_inch').prop('checked') ? 1 : 0;
            let measurement_option_cen = $('#measurement_option_cen').prop('checked') ? 1 : 0;
            if ((measurement_points.length > 0) && (size_options.length > 0)) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type:"POST",
                    url: "{{ route('size-charts.get-combination') }}",
                    data: {
                        measurement_points : measurement_points,
                        size_options : size_options,
                        measurement_option_inch : measurement_option_inch,
                        measurement_option_cen : measurement_option_cen,
                    },
                    success: function(data){
                        console.log(data);
                        $('#size-combination_body').html(data);
                        AIZ.plugins.fooTable();
                    }
                });
            }
        }
    </script>
@endsection
