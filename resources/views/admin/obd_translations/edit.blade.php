@extends('admin.layouts.admin')

@section('title', 'ترجمة الكود: ' . $obdCode->code)

@section('content')
<div class="container-fluid">

    <h4>ترجمة الكود: {{ $obdCode->code }}</h4>

    <form action="{{ route('admin.obd_translations.update', $obdCode->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="language_code">اختر اللغة</label>
            <select name="language_code" id="language_code" class="form-control" required>
                @foreach($languages as $language)
                    <option value="{{ $language->code }}"
                        {{ old('language_code', $currentTranslation->language_code ?? '') == $language->code ? 'selected' : '' }}>
                        {{ $language->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="title">العنوان</label>
            <input type="text" name="title" id="title" class="form-control"
                value="{{ old('title', $currentTranslation->title ?? $obdCode->title) }}" required>
        </div>

        <div class="form-group">
            <label for="description">الوصف</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $currentTranslation->description ?? $obdCode->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="causes">الأسباب</label>
            <textarea name="causes" id="causes" class="form-control" rows="3">{{ old('causes', $currentTranslation->causes ?? $obdCode->causes) }}</textarea>
        </div>

        <div class="form-group">
            <label for="symptoms">الأعراض</label>
            <textarea name="symptoms" id="symptoms" class="form-control" rows="3">{{ old('symptoms', $currentTranslation->symptoms ?? $obdCode->symptoms) }}</textarea>
        </div>

        <div class="form-group">
            <label for="solutions">الحلول</label>
            <textarea name="solutions" id="solutions" class="form-control" rows="3">{{ old('solutions', $currentTranslation->solutions ?? $obdCode->solutions) }}</textarea>
        </div>

        <div class="form-group">
            <label for="severity">شدة العطل</label>
            <input type="text" name="severity" id="severity" class="form-control"
                value="{{ old('severity', $currentTranslation->severity ?? $obdCode->severity) }}">
        </div>

        <div class="form-group">
            <label for="diagnosis">التشخيص</label>
            <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3">{{ old('diagnosis', $currentTranslation->diagnosis ?? $obdCode->diagnosis) }}</textarea>
        </div>
        <form action="{{ route('admin.obd_translations.import_json') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>رفع ملف JSON</label>
                <input type="file" name="json_file" class="form-control" accept=".json" required>
            </div>
            <button type="submit" class="btn btn-primary">استيراد الترجمات</button>
        </form>
        
        <a href="{{ route('admin.obd_translations.export_json') }}" class="btn btn-success mt-3">
            <i class="fas fa-download"></i> تصدير الترجمات JSON
        </a>
        
        <button type="submit" class="btn btn-primary btn-block">حفظ الترجمات</button>
        <a href="{{ route('admin.obd_translations.index') }}" class="btn btn-secondary btn-block mt-2">الرجوع للقائمة</a>
    
    </form>

</div>
@endsection
