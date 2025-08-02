@extends('site.layouts.site')

@section('content')
    <div class="py-4">
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->content }}</p>
    </div>
@endsection
