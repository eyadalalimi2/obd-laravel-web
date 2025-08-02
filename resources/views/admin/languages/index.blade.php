@extends('admin.layouts.admin')

@section('title', 'إدارة اللغات')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>إدارة اللغات</h4>
        <a href="{{ route('admin.languages.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> إضافة لغة جديدة
        </a>
    </div>

    <div class="row">
        @foreach ($languages as $language)
            <div class="col-md-3">
                <div class="card shadow-sm border-primary mb-4">
                    <div class="card-header bg-primary text-white text-center font-weight-bold">
                        {{ $language->name }} ({{ $language->code }})
                    </div>
                    <div class="card-body text-center">
                        <p><strong>الحالة:</strong> 
                            @if ($language->is_active)
                                <span class="badge badge-success">مفعلة</span>
                            @else
                                <span class="badge badge-secondary">معطلة</span>
                            @endif
                        </p>
                        <p><strong>المترجمة:</strong> {{ $language->translated_count ?? 0 }}</p>
                        <p><strong>الغير مترجمة:</strong> {{ $language->untranslated_count ?? 0 }}</p>

                        <div class="d-flex justify-content-center flex-wrap gap-1">
                            <a href="{{ route('admin.languages.translations', $language->id) }}" class="btn btn-sm btn-info m-1">عرض</a>
                            <a href="{{ route('admin.languages.edit', $language->id) }}" class="btn btn-sm btn-primary m-1">تعديل</a>
                            <form action="{{ route('admin.languages.destroy', $language->id) }}" method="POST" class="d-inline m-1" onsubmit="return confirm('هل أنت متأكد من حذف اللغة؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                            </form>
                            <a href="{{ route('admin.translations.import', $language->id) }}" class="btn btn-sm btn-dark m-1">استيراد الترجمة</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
