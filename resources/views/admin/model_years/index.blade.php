@extends('admin.layouts.admin')
@section('title', 'سنوات الإنتاج')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-3">
            <h4>سنوات الإنتاج</h4>
            <a href="{{ route('admin.model_years.create') }}" class="btn btn-success">إضافة سنة</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>السنة</th>
                    <th>الموديل</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($years as $year)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $year->year }}</td>
                        <td>{{ $year->model->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.model_years.edit', $year->id) }}"
                                class="btn btn-sm btn-primary">تعديل</a>
                            <form action="{{ route('admin.model_years.destroy', $year->id) }}" method="POST"
                                class="d-inline">
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
