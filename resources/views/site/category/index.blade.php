@extends('site.layouts.site')

@section('content')
    <div class="py-4">
        <h2>{{ __('site.categories') }}</h2>
        <ul class="list-group">
            @foreach($categories as $category)
                <li class="list-group-item">
                    <a href="{{ route('site.category.show', ['slug' => $category->slug]) }}">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
