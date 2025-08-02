@extends('admin.layouts.admin')

@section('title', 'قائمة أكواد الأعطال')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>قائمة أكواد الأعطال</h4>
            <a href="{{ route('admin.obd_codes.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> إضافة كود جديد
            </a>
        </div>

        <!-- أزرار اللغات -->
        <div class="mb-3">
            @foreach ($languages as $language)
                <a href="{{ route('admin.languages.translations', $language->id) }}" class="btn btn-sm btn-primary m-1">
                    {{ $language->name }}
                </a>
            @endforeach

        </div>



        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-bordered table-striped m-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>
                                <a
                                    href="{{ route('admin.obd_codes.index', array_merge(request()->query(), ['sort' => 'code', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                    الكود
                                </a>
                            </th>
                            <th>النوع</th>
                            <th>الشركه المصنعة</th>
                            <th>
                                <a
                                    href="{{ route('admin.obd_codes.index', array_merge(request()->query(), ['sort' => 'title', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                    العنوان
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('admin.obd_codes.index', array_merge(request()->query(), ['sort' => 'severity', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                    الشدة
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('admin.obd_codes.index', array_merge(request()->query(), ['sort' => 'category', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                    الفئة
                                </a>
                            </th>
                            <th>الصورة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($obdCodes as $code)
                            <tr>
                                <td>{{ $loop->iteration + ($obdCodes->currentPage() - 1) * $obdCodes->perPage() }}</td>
                                <td>{{ $code->code }}</td>
                                <td>{{ ucfirst($code->type) }}</td>
                                <td>{{ optional($code->brand)->name ?: '—' }}</td>
                                <td>{{ $code->title }}</td>
                                <td>{{ $code->severity }}</td>
                                <td>{{ $code->category }}</td>
                                <td>
                                    @if ($code->image)
                                        <img src="{{ asset('storage/' . $code->image) }}" width="60" height="40">
                                    @else
                                        <span class="text-muted">بدون صورة</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.obd_codes.show', $code->id) }}"
                                        class="btn btn-sm btn-info">عرض</a>
                                    <a href="{{ route('admin.obd_codes.edit', $code->id) }}"
                                        class="btn btn-sm btn-primary">تعديل</a>
                                    <form action="{{ route('admin.obd_codes.toggleStatus', $code->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('هل تريد تغيير حالة التفعيل؟');">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm {{ $code->status ? 'btn-warning' : 'btn-success' }}">
                                            {{ $code->status ? 'تعطيل' : 'تفعيل' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.obd_codes.delete', $code->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('هل تريد حذف هذا الكود؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">لا توجد بيانات</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {!! $obdCodes->appends(request()->query())->links('pagination::bootstrap-4') !!}
        </div>

    </div>
@endsection
