@if($measurement_option_inch == 1 || $measurement_option_cen == 1)
  <table class="table table-bordered aiz-table footable footable-2 breakpoint-xl" style="">
    <thead>
      <tr class="footable-header">
        <th>{{ translate('Measurement Points') }}</th>
        @foreach ($size_options as $size_option)
          <th class="text-center">{{ $size_option->value }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @foreach ($measurementPoints as $measurementPoint)
        <tr>
          <td class="fw-600" style="display: table-cell; vertical-align: middle;">{{ $measurementPoint->name }}</td>
          @foreach ($size_options as $size_option)
            <td style="display: table-cell;">
              @if($measurement_option_inch == 1)
                <input type="text" class="form-control" placeholder="{{ translate('Inches') }}" name="size_chart_values[{{ $measurementPoint->id }}][{{ $size_option->id }}][inch]" required>
              @endif
              @if($measurement_option_cen == 1)
                <input type="text" class="form-control mt-2" placeholder="{{ translate('Centimeter') }}" name="size_chart_values[{{ $measurementPoint->id }}][{{ $size_option->id }}][cen]" required>
              @endif
            </td>
          @endforeach
        </tr>
      @endforeach
    </tbody>
  </table>
@endif
  