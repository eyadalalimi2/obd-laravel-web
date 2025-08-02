@extends('admin.layouts.admin')
@section('title', 'الشركات')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>الشركات</h4>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-success">إضافة شركة</a>
    </div>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr><th>#</th><th>الاسم</th><th>إجراءات</th></tr>
        </thead>
        <tbody>
            @foreach($brands as $brand)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $brand->name }}</td>
                <td>
                    <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                    <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline">
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
