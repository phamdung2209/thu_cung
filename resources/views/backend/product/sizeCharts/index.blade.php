@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="h3">{{translate('All Size Chart')}}</h1>
            </div>
            @can('add_size_charts')
                <div class="col text-right">
                    <a href="{{ route('size-charts.create') }}" class="btn btn-circle btn-info">
                        <span>{{translate('Add New Size Chart')}}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>
    <br>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('All Size Chart') }}</h5>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Size Chart') }}</th>
                        <th>{{ translate('Category') }}</th>
                        <th class="text-center">{{ translate('Details') }}</th>
                        <th class="text-right">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sizeCharts as $key => $sizeChart)
                    <tr>
                        <td>{{ ($key+1) + ($sizeCharts->currentPage() - 1)*$sizeCharts->perPage() }}</td>
                        <td>{{ $sizeChart->name }}</td>
                        <td>{{ $sizeChart->category ? $sizeChart->category->name : '' }}</td>
                        <td class="text-center">
                            <button class="btn btn-info btn-xs" onclick="showSizeChartDetail({{ $sizeChart->id }}, '{{ $sizeChart->name }}')">
                                {{ translate('Show') }}
                            </button>
                        </td>
                        <td class="text-right">
                            @can('edit_size_charts')
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('size-charts.edit', $sizeChart->id )}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                            @endcan
                            @can('delete_size_charts')
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('size-charts.destroy', $sizeChart->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $sizeCharts->links() }}
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')
    @include('modals.size_chart_show_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function showSizeChartDetail(id, name){
            $('#size-chart-show-modal .modal-title').html('');
            $('#size-chart-show-modal .modal-body').html('');
            $.ajax({
                type: "GET",
                url: "{{ route('size-charts.show', '') }}/"+id,
                data: {},
                success: function(data) {
                    $('#size-chart-show-modal .modal-title').html(name);
                    $('#size-chart-show-modal .modal-body').html(data);
                    $('#size-chart-show-modal').modal('show');
                }
            });
        }
    </script>
@endsection
