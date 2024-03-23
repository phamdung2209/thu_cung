@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="align-items-center">
            <h1 class="h3">{{ translate('All Measurement Points') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="@if (auth()->user()->can('add_measurement_points')) col-lg-7 @else col-lg-12 @endif">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Measurement Points') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ translate('Name') }}</th>
                                <th class="text-right">{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($measurementPoints as $key => $measurementPoint)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $measurementPoint->name }}</td>
                                    <td class="text-right">
                                        @can('edit_measurement_points')
                                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                href="javascript:void(0);" 
                                                onclick="edit_measurement_point({{ $measurementPoint->id }})"
                                                title="{{ translate('Edit') }}">
                                                <i class="las la-edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete_measurement_points')
                                            <a href="#"
                                                class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                                data-href="{{ route('measurement-points.destroy', $measurementPoint->id) }}"
                                                title="{{ translate('Delete') }}">
                                                <i class="las la-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $measurementPoints->links() }}
                    </div>
                </div>
            </div>
        </div>
        @can('add_measurement_points')
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Add New Measurement Point') }}</h5>
                    </div>
                    <div class="card-body">
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
                        <form action="{{ route('measurement-points.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">{{ translate('Name') }}</label>
                                <input type="text" placeholder="{{ translate('Name') }}" name="name"
                                    class="form-control" required>
                            </div>
                            <div class="form-group mb-3 text-right">
                                <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')

    @can('edit_measurement_points')
        <!-- measurement point edit modal -->
        <div id="measurement-point-edit-modal" class="modal fade">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title h6">{{ translate('Measurement Point Information') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body text-center">
                        <form action="" method="POST" id="measurement-point-edit-form">
                            <input name="_method" type="hidden" value="PATCH">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label text-left" for="name">{{ translate('Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                        class="form-control" required value="">
                                </div>
                            </div>
                            <div class="form-group mb-0 text-right">
                                <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection

@section('script')
    <script type="text/javascript">
        @can('edit_measurement_points')
            function edit_measurement_point(id){
                $('#measurement-point-edit-form #name').val('');
                var actionUrl = "{{ route('measurement-points.update', '') }}/"+id
                $.ajax({
                    type: "GET",
                    url: "{{ route('measurement-points.show', '') }}/"+id,
                    data: {},
                    success: function(data) {
                        $('#measurement-point-edit-form').attr('action', actionUrl);
                        $('#measurement-point-edit-form #name').val(data);
                        $('#measurement-point-edit-modal').modal('show');
                    }
                });
            }
        @endcan
    </script>
@endsection
