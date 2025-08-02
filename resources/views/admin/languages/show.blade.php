@extends('admin.layouts.admin')

@section('title', 'عرض ترجمات اللغة - ' . $language->name)

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">عرض ترجمات اللغة: {{ $language->name }} ({{ $language->code }})</h4>

    @if($translations->isEmpty())
        <div class="alert alert-info">لا توجد ترجمات متاحة لهذه اللغة حتى الآن.</div>
    @else
        <div class="row">
            @foreach($translations as $translation)
                <div class="col-md-4">
                    <div class="card shadow-sm border-left-primary mb-4" style="border-top: 3px solid #3498db;">
                        <div class="card-body">
                            <h5><i class="fas fa-code"></i> {{ $translation->obdCode->code }}</h5>
                            <p><strong>العنوان:</strong> {{ $translation->title }}</p>
                            <p><strong>الوصف:</strong> {{ Str::limit($translation->description, 100) }}</p>
                            <a href="{{ route('admin.obd_translations.edit', $translation->obd_code_id) }}"
                               class="btn btn-sm btn-primary mt-2">
                                تعديل الترجمة
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <a href="{{ route('admin.languages.index') }}" class="btn btn-secondary mt-3">رجوع</a>
</div>
@endsection
