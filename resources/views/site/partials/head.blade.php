@php
    $adsSettings = \App\Models\AdsSetting::first();
@endphp

@if ($adsSettings && $adsSettings->is_enabled && $adsSettings->head_script)
    {!! $adsSettings->head_script !!}
@endif

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ config('app.name') }}</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
