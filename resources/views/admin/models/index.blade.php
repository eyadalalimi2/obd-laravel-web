@extends('admin.layouts.admin')
@section('title', 'الموديلات')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>الموديلات</h4>
        <a href="{{ route('admin.models.create') }}" class="btn btn-success">إضافة موديل</a>
    </div>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr><th>#</th><th>الموديل</th><th>الشركة</th><th>إجراءات</th></tr>
        </thead>
        <tbody>
            @foreach($models as $model)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $model->name }}</td>
                <td>{{ $model->brand->name ?? '-' }}</td>
                <td>
                    <a href="{{ route('admin.models.edit', $model->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                    <form action="{{ route('admin.models.destroy', $model->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
