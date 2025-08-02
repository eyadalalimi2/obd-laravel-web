@extends('admin.layouts.admin')

@section('title', 'قائمة الصفحات')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h4>الصفحات الثابتة</h4>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-success">إضافة صفحة جديدة</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>الرابط</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $page->title }}</td>
                            <td>{{ $page->slug }}</td>
                            <td>
                                <span class="badge badge-{{ $page->status === 'published' ? 'success' : 'secondary' }}">
                                    {{ $page->status === 'published' ? 'منشورة' : 'مسودة' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                                <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد حذف هذه الصفحة؟');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">لا توجد صفحات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
