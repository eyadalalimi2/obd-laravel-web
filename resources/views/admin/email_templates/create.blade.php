@extends('admin.layouts.admin') 
@section('title','إنشاء قالب بريد جديد') 
@section('content')

<div class="container-fluid">
  <h1 class="mb-4">إنشاء قالب بريد جديد</h1>
  <form action="{{ route('admin.email_templates.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="key">Key</label>
      <input name="key" id="key" class="form-control @error('key') is-invalid @enderror" value="{{ old('key') }}">
      @error('key')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
      <label for="locale">اللغة</label>
      <select name="locale" id="locale" class="form-control">
        <option value="en">EN</option>
        <option value="ar">AR</option>
      </select>
    </div>
    <div class="form-group">
      <label for="subject">Subject</label>
      <input name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}">
      @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
      <label for="body">Body (HTML)</label>
      <textarea name="body" id="body" rows="6" class="form-control @error('body') is-invalid @enderror">{{ old('body') }}</textarea>
      @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button class="btn btn-primary">حفظ</button>
  </form>
</div>
@endsection