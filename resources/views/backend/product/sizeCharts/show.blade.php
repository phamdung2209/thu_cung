@if ($size_chart->fit_type != null)
    <!-- Fit Type -->
    <p class="fs-14 fw-600 text-left">
        {{ translate('Fit Type') }}: 
        <span class="fw-400 ml-3">
            @if ($size_chart->fit_type == 'slim_fit') {{ translate('Slim Fit') }} @endif
            @if ($size_chart->fit_type == 'regular_fit') {{ translate('Regular Fit') }} @endif
            @if ($size_chart->fit_type == 'relaxed') {{ translate('Relaxed') }} @endif
        </span>
    </p>
@endif

@if ($size_chart->stretch_type != null)
    <!-- Stretch Type -->
    <p class="fs-14 fw-600 text-left">
        {{ translate('Stretch Type') }}: 
        <span class="fw-400 ml-3">
            @if ($size_chart->stretch_type == 'non') {{ translate('Non') }} @endif
            @if ($size_chart->stretch_type == 'slight') {{ translate('Slight') }} @endif
            @if ($size_chart->stretch_type == 'medium') {{ translate('Medium') }} @endif
            @if ($size_chart->stretch_type == 'hign') {{ translate('Hign') }} @endif
        </span>
    </p>
@endif

<!-- Size Combination -->
<div class="mt-4 mb-4">
    @if($measurement_option_inch == 1 || $measurement_option_cen == 1)
        <ul class="nav nav-tabs border-0" role="tablist">
            @if($measurement_option_inch == 1)
                <li class="nav-item">
                    <a class="nav-link w-110px active" data-toggle="tab" data-type="inch" 
                        href="#inch-chart" role="tab" id="inch-tab">{{ translate('Inches') }}</a>
                </li>
            @endif
            @if($measurement_option_cen == 1)
                <li class="nav-item">
                    <a class="nav-link w-110px @if($measurement_option_inch == 0) active @endif" data-toggle="tab" data-type="cen"
                        href="#cen-chart" role="tab" id="cen-tab">{{ translate('Centimeter') }}</a>
                </li>
            @endif
        </ul>
    @endif
    <div class="tab-content c-scrollbar-light overflow-auto" style="">
        @if($measurement_option_inch == 1)
            <div class="tab-pane active mt-3" id="inch-chart" role="tabpanel">
                <table class="table table-bordered breakpoint-xl" style="">
                    <thead>
                      <tr class="">
                        <th class="text-left">{{ translate('Measurement Points') }}</th>
                        @foreach ($size_options as $size_option)
                          <th class="text-center">{{ $size_option->value }}</th>
                        @endforeach
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($measurementPoints as $measurementPoint)
                        <tr>
                          <td class="fw-600 text-left" style="display: table-cell; vertical-align: middle;">{{ $measurementPoint->name }}</td>
                          @foreach ($size_options as $size_option)
                            <td style="display: table-cell;">
                              {{  $data['inch'][$measurementPoint->id][$size_option->id] }}
                            </td>
                          @endforeach
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        @if($measurement_option_cen == 1)
            <div class="tab-pane  @if($measurement_option_inch == 0) active @endif mt-3" id="cen-chart" role="tabpanel">
                <table class="table table-bordered breakpoint-xl" style="">
                    <thead>
                    <tr class="">
                        <th class="text-left">{{ translate('Measurement Points') }}</th>
                        @foreach ($size_options as $size_option)
                        <th class="text-center">{{ $size_option->value }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($measurementPoints as $measurementPoint)
                        <tr>
                        <td class="fw-600 text-left" style="display: table-cell; vertical-align: middle;">{{ $measurementPoint->name }}</td>
                        @foreach ($size_options as $size_option)
                            <td style="display: table-cell;">
                                {{  $data['cen'][$measurementPoint->id][$size_option->id] }}
                            </td>
                        @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@if ($size_chart->photos != null || $size_chart->description != null)
    <!-- Image & description -->
    <h6 class="text-left fs-16 fw-600 mb-4">{{ translate('Description') }}:</h6>
    <div class="row">
        @if ($size_chart->description != null)
            <div class="@if ($size_chart->photos != null && $size_chart->description != null) col-md-6 @else col-md-12 @endif">
                <p class="text-justify">{!! nl2br($size_chart->description) !!}</p>
            </div>
        @endif
        @if ($size_chart->photos != null)
            <div class="@if ($size_chart->photos != null && $size_chart->description != null) col-md-6 @else col-md-12 @endif px-4">
                @foreach (explode(",", $size_chart->photos) as $photo)
                    <img src="{{ uploaded_asset($photo) }}" class="w-100 mb-4">
                @endforeach
            </div>
        @endif
    </div>
@endif