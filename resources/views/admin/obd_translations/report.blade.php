@extends('admin.layouts.admin')

@section('title', 'تقرير حالة الترجمات')

@section('content')
<div class="container-fluid">
    <h4>تقرير حالة ترجمات الأكواد</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الكود</th>
                @foreach ($languages as $lang)
                    <th>{{ $lang->name }} ({{ $lang->code }})</th>
                @endforeach
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($obdCodes as $code)
                <tr>
                    <td>{{ $code->code }}</td>
                    @foreach ($languages as $lang)
                        @php
                            $key = $code->id . '_' . $lang->code;
                            $hasTranslation = $translations->has($key);
                        @endphp
                        <td>
                            @if ($hasTranslation)
                                <span class="badge badge-success">مترجم</span>
                            @else
                                <span class="badge badge-danger">غير مترجم</span>
                            @endif
                        </td>
                    @endforeach
                    <td>
                        <a href="{{ route('admin.obd_translations.edit', $code->id) }}" class="btn btn-sm btn-primary">
                            تعديل الترجمات
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
