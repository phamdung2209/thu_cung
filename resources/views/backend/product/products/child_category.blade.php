@php
    $value = null;
    for ($i=0; $i < $child_category->level; $i++){
        $value .= '-';
    }
@endphp
<li id="{{ $childCategory->id }}">{{ $value }}{{ $childCategory->getTranslation('name') }}</li>
@if ($child_category->childrenCategories)
    @foreach ($child_category->childrenCategories as $childCategory)
        @include('backend.product.products.child_category', ['child_category' => $childCategory])
    @endforeach
@endif
