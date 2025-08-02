@extends('admin.layouts.admin') 
@
@section('title','معاينة قالب: '.$template->key)

@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1>معاينة: <code>{{ $template->key }}</code> ({{ strtoupper($locale) }})</h1>
    <select onchange="location = this.value" class="form-control w-auto">
      @foreach($locales as $code => $label)
        <option value="{{ route('admin.email_templates.show',['template'=>$template,'locale'=>$code]) }}"
                {{ $code == $locale ? 'selected' : '' }}>
          {{ $label }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="card">
    <div class="card-header bg-info text-white">
      <strong>{{ $translation->subject }}</strong>
    </div>
    <div class="card-body" style="background:#f9f9f9;">
      {!! $translation->body !!}
    </div>
  </div>
</div>
@endsection