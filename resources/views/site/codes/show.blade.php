@extends('site.layouts.site')

@section('content')
    <div class="py-4">
        <h2>{{ $obdCode->code }} - {{ $translation->title ?? $obdCode->title }}</h2>

        <p><strong>{{ __('site.description') }}:</strong> {{ $translation->description ?? $obdCode->description }}</p>
        <p><strong>{{ __('site.symptoms') }}:</strong> {{ $translation->symptoms ?? $obdCode->symptoms }}</p>
        <p><strong>{{ __('site.causes') }}:</strong> {{ $translation->causes ?? $obdCode->causes }}</p>
        <p><strong>{{ __('site.solutions') }}:</strong> {{ $translation->solutions ?? $obdCode->solutions }}</p>
        <p><strong>{{ __('site.severity') }}:</strong> {{ $obdCode->severity }}</p>
        <p><strong>{{ __('site.diagnosis') }}:</strong> {{ $obdCode->diagnosis }}</p>
        <p><strong>{{ __('site.source_url') }}:</strong> <a href="{{ $obdCode->source_url }}" target="_blank">{{ $obdCode->source_url }}</a></p>
        @if($obdCode->image)
            <p><strong>{{ __('site.image') }}:</strong><br>
                <img src="{{ asset('storage/' . $obdCode->image) }}" alt="{{ $obdCode->title }}" style="max-width:300px;">
            </p>
        @endif

        <a href="{{ route('site.codes') }}" class="btn btn-secondary mt-3">{{ __('site.back_to_search') }}</a>
    </div>
@endsection
