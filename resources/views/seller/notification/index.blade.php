@extends('seller.layouts.app')

@section('panel_content')

<div class="card">
    <form class="" id="sort_customers" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-0 h6">{{translate('Notifications')}}</h5>
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

@endsection



