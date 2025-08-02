@extends('site.layouts.site')

@section('content')
    <div class="py-4">
        <h2>{{ $category->name }}</h2>
        <ul class="list-group">
            @foreach ($codes as $code)
                @php
                    $translation = $code
                        ->translations()
                        ->where('language_code', app()->getLocale())
                        ->first();
                    $title = $translation ? $translation->title : $code->code;
                @endphp
                <li class="list-group-item">
                    <a href="{{ route('site.code.show', ['code' => $code->code]) }}">
                        {{ $code->code }} - {{ $title }}
                    </a>
                </li>
            @endforeach

        </ul>
    </div>
@endsection
