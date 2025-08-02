@extends('site.layouts.site')

@section('content')
    <div class="py-4">
        <h2>{{ $page->title }}</h2>
        <p>{{ $page->content }}</p>
    </div>
@endsection
