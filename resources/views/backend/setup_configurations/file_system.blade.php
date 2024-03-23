@extends('backend.layouts.app')

@section('content')

    <div class="row">
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="fs-18 mb-0 text-center">{{translate('S3 File System Credentials')}}</h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="AWS_ACCESS_KEY_ID">
                            <div class="col-lg-4">
                                <label class="control-label">{{translate('AWS_ACCESS_KEY_ID')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="AWS_ACCESS_KEY_ID" value="{{  env('AWS_ACCESS_KEY_ID') }}" placeholder="{{ translate('AWS_ACCESS_KEY_ID') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="AWS_SECRET_ACCESS_KEY">
                            <div class="col-lg-4">
                                <label class="control-label">{{translate('AWS_SECRET_ACCESS_KEY')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="AWS_SECRET_ACCESS_KEY" value="{{  env('AWS_SECRET_ACCESS_KEY') }}" placeholder="{{ translate('AWS_SECRET_ACCESS_KEY') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="AWS_DEFAULT_REGION">
                            <div class="col-lg-4">
                                <label class="control-label">{{translate('AWS_DEFAULT_REGION')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="AWS_DEFAULT_REGION" value="{{  env('AWS_DEFAULT_REGION') }}" placeholder="{{ translate('AWS_DEFAULT_REGION') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="AWS_BUCKET">
                            <div class="col-lg-4">
                                <label class="control-label">{{translate('AWS_BUCKET')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="AWS_BUCKET" value="{{  env('AWS_BUCKET') }}" placeholder="{{ translate('AWS_BUCKET') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="AWS_URL">
                            <div class="col-lg-4">
                                <label class="control-label">{{translate('AWS_URL')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="AWS_URL" value="{{  env('AWS_URL') }}" placeholder="{{ translate('AWS_URL') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 text-right">
                                <button class="btn btn-primary" type="submit">{{translate('Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="fs-18 mb-0 text-center">{{translate('Backblaze File System Credentials')}}</h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="BACKBLAZE_ACCESS_KEY_ID">
                            <div class="col-lg-4">
                                <label class="control-label">{{translate('BACKBLAZE_ACCESS_KEY_ID')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="BACKBLAZE_ACCESS_KEY_ID" value="{{  env('BACKBLAZE_ACCESS_KEY_ID') }}" placeholder="{{ translate('BACKBLAZE_ACCESS_KEY_ID') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="BACKBLAZE_SECRET_ACCESS_KEY">
                            <div class="col-lg-4">
                                <label class="control-label">{{translate('BACKBLAZE_SECRET_ACCESS_KEY')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="BACKBLAZE_SECRET_ACCESS_KEY" value="{{  env('BACKBLAZE_SECRET_ACCESS_KEY') }}" placeholder="{{ translate('AWS_SECRET_ACCESS_KEY') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="BACKBLAZE_DEFAULT_REGION">
                            <div class="col-lg-4">
                                <label class="control-label">{{translate('BACKBLAZE_DEFAULT_REGION')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="BACKBLAZE_DEFAULT_REGION" value="{{  env('BACKBLAZE_DEFAULT_REGION') }}" placeholder="{{ translate('BACKBLAZE_DEFAULT_REGION') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="BACKBLAZE_BUCKET">
                            <div class="col-lg-4">
                                <label class="control-label">{{translate('BACKBLAZE_BUCKET')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="BACKBLAZE_BUCKET" value="{{  env('BACKBLAZE_BUCKET') }}" placeholder="{{ translate('BACKBLAZE_BUCKET') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="BACKBLAZE_ENDPOINT">
                            <div class="col-lg-4">
                                <label class="control-label">{{translate('BACKBLAZE_ENDPOINT')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="BACKBLAZE_ENDPOINT" value="{{  env('BACKBLAZE_ENDPOINT') }}" placeholder="{{ translate('BACKBLAZE_ENDPOINT') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="BACKBLAZE_URL">
                            <div class="col-lg-4">
                                <label class="control-label">{{translate('BACKBLAZE_URL')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="BACKBLAZE_URL" value="{{  env('BACKBLAZE_URL') }}" placeholder="{{ translate('BACKBLAZE_URL') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 text-right">
                                <button class="btn btn-primary" type="submit">{{translate('Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="fs-18 mb-0 text-center">{{translate('AWS S3 File System Activation')}}</h3>
                </div>
                <div class="card-body">
                    <label class="aiz-switch mb-0">
                        <input type="radio" name="FILESYSTEM_DRIVER" onchange="updateSettings(this, 'FILESYSTEM_DRIVER', 'aws')" <?php if(env('FILESYSTEM_DRIVER') == 'aws') echo "checked";?>>
                        <span></span>
                    </label>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="fs-18 mb-0 text-center">{{translate('Backblaze File System Activation')}}</h3>
                </div>
                <div class="card-body">
                    <label class="aiz-switch mb-0">
                        <input type="radio" name="FILESYSTEM_DRIVER" onchange="updateSettings(this, 'FILESYSTEM_DRIVER', 'backblaze')" <?php if(env('FILESYSTEM_DRIVER') == 'backblaze') echo "checked";?>>
                        <span></span>
                    </label>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="fs-18 mb-0 text-center">{{translate('Local File System Activation')}}</h3>
                </div>
                <div class="card-body">
                    <label class="aiz-switch mb-0">
                        <input type="radio" name="FILESYSTEM_DRIVER" onchange="updateSettings(this, 'FILESYSTEM_DRIVER', 'local')" <?php if(env('FILESYSTEM_DRIVER') == 'local') echo "checked";?>>
                        <span></span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="fs-18 mb-0 text-center">{{translate('Cache & Session Driver')}}</h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        <input type="hidden" name="payment_method" value="paypal">
                        @csrf
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="CACHE_DRIVER">
                            <div class="col-lg-4">
                                <label class="control-label">{{translate('CACHE_DRIVER')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <select class="form-control aiz-selectpicker mb-2 mb-md-0" name="CACHE_DRIVER">
                                    <option value="file" @if (env('CACHE_DRIVER') == "file") selected @endif>{{ translate('file') }}</option>
                                    <option value="redis" @if (env('CACHE_DRIVER') == "redis") selected @endif>{{ translate('redis') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="SESSION_DRIVER">
                            <div class="col-lg-4">
                                <label class="control-label">{{translate('SESSION_DRIVER')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <select class="form-control aiz-selectpicker mb-2 mb-md-0" name="SESSION_DRIVER">
                                    <option value="file" @if (env('SESSION_DRIVER') == "file") selected @endif>{{ translate('file') }}</option>
                                    <option value="redis" @if (env('SESSION_DRIVER') == "redis") selected @endif>{{ translate('redis') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 text-right">
                                <button class="btn btn-primary" type="submit">{{translate('Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="fs-18 mb-0 text-center">{{translate('Redis Configuration (If you use redis as any of the drivers)')}}</h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        <input type="hidden" name="payment_method" value="paypal">
                        @csrf
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="REDIS_HOST">
                            <div class="col-lg-4">
                                <label class="control-label">{{translate('REDIS_HOST')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="REDIS_HOST" value="{{  env('REDIS_HOST') }}" placeholder="{{ translate('REDIS_HOST') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="REDIS_PASSWORD">
                            <div class="col-lg-4">
                                <label class="control-label">{{translate('REDIS_PASSWORD')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="REDIS_PASSWORD" value="{{  env('REDIS_PASSWORD') }}" placeholder="{{ translate('REDIS_PASSWORD') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="REDIS_PORT">
                            <div class="col-lg-4">
                                <label class="control-label">{{translate('REDIS_PORT')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="REDIS_PORT" value="{{  env('REDIS_PORT') }}" placeholder="{{ translate('REDIS_PORT') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 text-right">
                                <button class="btn btn-primary" type="submit">{{translate('Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function updateSettings(el, type, value_type){
            
            $.post('{{ route('business_settings.update.activation') }}', {
                _token:'{{ csrf_token() }}', 
                type:type, 
                value:value_type
            }, function(data){
                if(data == '1'){
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
