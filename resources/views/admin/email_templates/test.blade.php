@extends('admin.layouts.admin')
@section('title','تجربة قالب')

@section('content')

<div class="container-fluid">
  <h1 class="mb-4">تجربة قالب {{ $template->key }} ({{ strtoupper($locale) }})</h1>
  <form action="{{ route('admin.email_templates.send_test', $template) }}" method="POST">
    @csrf
    @foreach($translation->placeholders as $ph)
      <div class="form-group">
        <label for="ph_{{ $ph }}">{{ $ph }}</label>
        <input name="data[{{ $ph }}]" id="ph_{{ $ph }}" class="form-control" value="{{ old('data.'.$ph) }}">
      </div>
    @endforeach
    <button class="btn btn-success">إرسال رسالة تجريبية</button>
  </form>
</div>
@endsection