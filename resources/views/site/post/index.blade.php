@extends('site.layouts.site')

@section('content')
    <div class="py-4">
        <h2>{{ __('site.blog') }}</h2>
        <ul class="list-group">
            @foreach($posts as $post)
                <li class="list-group-item">
                    <a href="{{ route('site.post.show', ['slug' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
