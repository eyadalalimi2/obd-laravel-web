@extends('admin.layouts.admin')

@section('title', 'إدارة الترجمات')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-3">إدارة الترجمات - {{ $language->name }}</h4>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-bordered table-striped m-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>الكود</th>
                            <th>العنوان</th>
                            <th>الوصف</th>
                            <th>الأعراض</th>
                            <th>الأسباب</th>
                            <th>الحلول</th>
                            <th>الشدة</th>
                            <th>التشخيص</th>
                            <th>الفئة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($translations as $translation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $translation->code }}</td>
                                <td>{{ $translation->title }}</td>
                                <td>{{ $translation->description }}</td>
                                <td>{{ $translation->symptoms }}</td>
                                <td>{{ $translation->causes }}</td>
                                <td>{{ $translation->solutions }}</td>
                                <td>{{ $translation->severity }}</td>
                                <td>{{ $translation->diagnosis }}</td>
                                <td>{{ $translation->category }}</td>
                                <td>
                                    <a href="{{ route('admin.obd_translations.edit', ['obd_code_id' => $translation->obd_code_id, 'language_code' => $language->code]) }}" class="btn btn-sm btn-primary">تعديل</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {!! $translations->links('pagination::bootstrap-4') !!}
        </div>
    </div>
@endsection
