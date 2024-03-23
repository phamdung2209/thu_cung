@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="align-items-center">
            <h1 class="h3">{{ translate('All Notifications') }}</h1>
        </div>
    </div>


    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <form class="" id="sort_customers" action="" method="GET">
                    <div class="card-header row gutters-5">
                        <div class="col">
                            <h5 class="mb-0 h6">{{ translate('Notifications') }}</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                           
                            <x-notification :notifications="$notifications" is_linkable/>
                            
                        </ul>

                        {{ $notifications->links() }}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
