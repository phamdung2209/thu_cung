@foreach ($inhouse_top_categories as $inhouse_top_category)
    <div class="d-flex flex-lg-wrap flex-xxl-nowrap align-items-center justify-content-between" style="margin-bottom: 0.75rem;">
        <div class="d-flex align-items-center mr-2">
            <div class="rounded-2 border overflow-hidden mr-3" style="min-height: 48px !important; min-width: 48px !important;max-height: 48px !important; max-width: 48px !important;">
                <img src="{{ uploaded_asset($inhouse_top_category->cover_image) }}" alt="{{ translate('category') }}" 
                    class="h-100 img-fit lazyload" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
            </div>
            <h4 class="fs-13 fw-600 text-dark mb-0 text-truncate-2">
                @php
                    $lang = App::getLocale();
                    $category = App\Models\CategoryTranslation::where('category_id', $inhouse_top_category->id)
                    ->where('lang', $lang)
                    ->first();
                @endphp
                {{ $category ? $category->name : translate('Not Found') }}
            </h4>
        </div>
        <h4 class="fs-13 fw-600 text-danger mb-0 py-2">
            {{ single_price($inhouse_top_category->total) }}
        </h4>
    </div>
@endforeach