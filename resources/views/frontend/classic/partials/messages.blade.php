@foreach ($conversation->messages as $key => $message)
    @if ($message->user_id == Auth::user()->id)
        <div class="block block-comment mb-3">
            <div class="d-flex flex-row-reverse">
                <div class="pl-3">
                    <div class="block-image">
                        @if (Auth::user()->id != $message->user_id && $message->user->shop != null)
                            <a href="{{ route('shop.visit', $message->user->shop->slug) }}" class="avatar avatar-sm mr-3">
                                <img  class="" src="{{ uploaded_asset($message->user->shop->logo) }}" 
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                            </a>
                        @else
                        <span class="avatar avatar-sm mr-3">
                            <img class="" @if($message->user != null) src="{{ uploaded_asset($message->user->avatar_original) }}" @endif 
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                        </span>
                        @endif
                    </div>
                </div>
                <div class="flex-grow ml-5 pl-5">
                    <div class="px-3 py-2 border rounded text-right">
                        {{ $message->message }}
                    </div>
                    <span class="comment-date alpha-7 small mt-1 d-block text-right">
                        {{ date('h:i:m d-m-Y', strtotime($message->created_at)) }}
                    </span>
                </div>
            </div>
        </div>
    @else
        <div class="block block-comment mb-3">
            <div class="d-flex">
                <div class="pr-3">
                    <div class="block-image">
                        @if (Auth::user()->id != $message->user_id && $message->user->shop != null)
                            <a href="{{ route('shop.visit', $message->user->shop->slug) }}" class="avatar avatar-sm mr-3">
                                <img  class="" src="{{ uploaded_asset($message->user->shop->logo) }}" 
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                            </a>
                        @else
                            <span class="avatar avatar-sm mr-3">
                                <img @if($message->user != null) src="{{ uploaded_asset($message->user->avatar_original) }}" @endif 
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex-grow mr-5 pr-5">
                    <div class="px-3 py-2 border rounded">
                        {{ $message->message }}
                    </div>
                    <span class="comment-date alpha-7 small mt-1 d-block">
                        {{ date('h:i:m d-m-Y', strtotime($message->created_at)) }}
                    </span>
                </div>
            </div>
        </div>
    @endif
@endforeach
