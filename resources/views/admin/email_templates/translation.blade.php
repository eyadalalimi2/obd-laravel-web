@extends('admin.layouts.admin') 
@section('title','ترجمة القالب') 
@section('content')

<div class="container-fluid">
  <h1 class="mb-4">ترجمة قالب {{ $template->key }} ({{ strtoupper($locale) }})</h1>
  <form action="{{ route('admin.email_templates.update_translation', ['template'=>$template,'locale'=>$locale]) }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="subject">Subject</label>
      <input name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject',$translation->subject) }}">
      @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
      <label for="body">Body (HTML)</label>
      <textarea name="body" id="body" rows="6" class="form-control @error('body') is-invalid @enderror">{{ old('body',$translation->body) }}</textarea>
      @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button class="btn btn-primary">حفظ الترجمة</button>
  </form>
</div>
@endsection