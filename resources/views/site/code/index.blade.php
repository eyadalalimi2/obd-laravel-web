@extends('site.layouts.site')

@section('content')
    <div class="text-center py-4">
        <h2>{{ __('site.start_search') }}</h2>
        <form method="GET" action="{{ route('site.codes') }}" class="my-3">
            <input type="text" name="query" value="{{ request('query') }}" class="form-control"
                placeholder="{{ __('site.enter_code') }}">
            <button type="submit" class="btn btn-primary mt-2">{{ __('site.search') }}</button>
        </form>

        @if ($query)
            <h4 class="mt-4">{{ __('site.search_results') }}: {{ $query }}</h4>
            @if (count($results))
                <ul class="list-group mt-3">
                    @foreach ($results as $result)
                        @php
                            $translation = $result
                                ->translations()
                                ->where('language_code', app()->getLocale())
                                ->first();
                            $title = $translation ? $translation->title : $result->code;
                        @endphp
                        <li class="list-group-item">
                            <a href="{{ route('site.code.show', ['code' => $result->code]) }}">
                                {{ $result->code }} - {{ $title }}
                            </a>
                        </li>
                    @endforeach

                </ul>
            @else
                <p class="mt-3">{{ __('site.no_results') }}</p>
            @endif
        @endif
    </div>
@endsection
