@extends('admin.layouts.admin')

@section('title', 'إعدادات النظام')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">إعدادات النظام العامة</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="card mb-4">
            <div class="card-header bg-dark text-white">المعلومات الأساسية</div>
            <div class="card-body">

                <div class="form-group">
                    <label>اسم الموقع</label>
                    <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name']->value ?? '' }}">
                </div>

                <div class="form-group">
                    <label>الوصف</label>
                    <textarea name="site_description" class="form-control">{{ $settings['site_description']->value ?? '' }}</textarea>
                </div>

                <div class="form-group">
                    <label>اللغة الافتراضية</label>
                    <select name="default_language" class="form-control">
                        <option value="ar" {{ ($settings['default_language']->value ?? '') == 'ar' ? 'selected' : '' }}>العربية</option>
                        <option value="en" {{ ($settings['default_language']->value ?? '') == 'en' ? 'selected' : '' }}>الإنجليزية</option>
                    </select>
                </div>

            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-info text-white">الهوية البصرية</div>
            <div class="card-body">

                <div class="form-group">
                    <label>الشعار</label>
                    <input type="file" name="site_logo" class="form-control-file">
                    @if(isset($settings['site_logo']))
                        <div class="mt-2"><img src="{{ asset('storage/' . $settings['site_logo']->value) }}" height="50"></div>
                    @endif
                </div>

                <div class="form-group">
                    <label>الأيقونة</label>
                    <input type="file" name="site_icon" class="form-control-file">
                    @if(isset($settings['site_icon']))
                        <div class="mt-2"><img src="{{ asset('storage/' . $settings['site_icon']->value) }}" height="50"></div>
                    @endif
                </div>

                <div class="form-group">
                    <label>لون الموقع</label>
                    <input type="color" name="site_color" class="form-control" value="{{ $settings['site_color']->value ?? '#3498db' }}">
                </div>

            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">إعدادات أخرى</div>
            <div class="card-body">

                <div class="form-group">
                    <label>كود Google Analytics</label>
                    <input type="text" name="ga_code" class="form-control" value="{{ $settings['ga_code']->value ?? '' }}">
                </div>

                <div class="form-group">
                    <label>Firebase API Key</label>
                    <input type="text" name="firebase_key" class="form-control" value="{{ $settings['firebase_key']->value ?? '' }}">
                </div>

                <div class="form-group">
                    <label>Meta Tags SEO</label>
                    <textarea name="seo_meta" class="form-control">{{ $settings['seo_meta']->value ?? '' }}</textarea>
                </div>

            </div>
        </div>

        <button class="btn btn-primary btn-block">حفظ الإعدادات</button>
    </form>

</div>
@endsection
