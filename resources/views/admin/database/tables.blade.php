@extends('admin.layouts.admin')

@section('title', 'عرض الجداول')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>عرض الجداول</h4>
        <form method="POST" action="{{ route('admin.database.create') }}" class="form-inline">
            @csrf
            <input type="text" name="table" class="form-control mr-2" placeholder="اسم الجدول الجديد" required>
            <button type="submit" class="btn btn-success">إنشاء جدول</button>
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>اسم الجدول</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tables as $index => $table)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $table }}</td>
                            <td>
                                <a href="{{ route('admin.database.columns', $table) }}" class="btn btn-sm btn-info">عرض الأعمدة</a>

                                <form action="{{ route('admin.database.drop', $table) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف الجدول؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">حذف الجدول</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">لا توجد جداول حاليًا.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
