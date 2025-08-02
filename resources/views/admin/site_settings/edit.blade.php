@extends('admin.layouts.admin')

@section('content')
<div class="container py-4">
    <h2>إعدادات الموقع العامة</h2>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.site-settings.update') }}" method="POST" enctype="multipart/form-data">
      @csrf

      {{-- 1. لوجو --}}
      <div class="mb-3">
        <label class="form-label">شعار الموقع</label><br>
        @if($settings->logo_path)
           <img src="{{ asset('storage/'.$settings->logo_path) }}" alt="Logo" height="60">
        @endif
        <input type="file" name="logo" class="form-control mt-2">
      </div>

      {{-- 2 & 3. الاسم والوصف متعدد اللغات --}}
      @foreach(['en'=>'English','ar'=>'العربية'] as $locale => $label)
        <h5>اللغة: {{ $label }}</h5>
        <div class="mb-3">
          <label class="form-label">اسم الموقع ({{ $label }})</label>
          <input type="text" name="site_name[{{ $locale }}]"
                 class="form-control"
                 value="{{ old("site_name.$locale", $settings->site_name[$locale] ?? '') }}">
        </div>
        <div class="mb-3">
          <label class="form-label">وصف SEO ({{ $label }})</label>
          <textarea name="site_description[{{ $locale }}]"
                    class="form-control"
                    rows="2">{{ old("site_description.$locale", $settings->site_description[$locale] ?? '') }}</textarea>
        </div>
      @endforeach

      <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
    </form>
</div>
@endsection
