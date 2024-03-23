<option value="0">{{ translate('No Parent') }}</option>
@foreach ($categories as $category)
    <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
    @foreach ($category->childrenCategories as $childCategory)
        @include('categories.child_category', ['child_category' => $childCategory])
    @endforeach
@endforeach