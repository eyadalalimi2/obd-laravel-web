@extends('admin.layouts.admin')

@section('title', 'إعدادات الإعلانات')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">إعدادات إعلانات Google AdSense</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.ads_settings.update') }}">
        @csrf

        <div class="form-group">
            <label>تفعيل الإعلانات</label>
            <select name="is_enabled" class="form-control" required>
                <option value="1" {{ $settings->is_enabled ? 'selected' : '' }}>مفعل</option>
                <option value="0" {{ !$settings->is_enabled ? 'selected' : '' }}>معطل</option>
            </select>
        </div>

        <div class="form-group">
            <label>كود AdSense الرئيسي (يُضاف داخل &lt;head&gt;)</label>
            <textarea name="head_script" rows="5" class="form-control">{{ $settings->head_script }}</textarea>
        </div>

        <div class="form-group">
            <label>كود الوحدات الإعلانية (يُضاف داخل &lt;body&gt;)</label>
            <textarea name="body_script" rows="5" class="form-control">{{ $settings->body_script }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-block">حفظ الإعدادات</button>
    </form>
</div>
@endsection
