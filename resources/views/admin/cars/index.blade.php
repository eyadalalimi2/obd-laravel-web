@extends('admin.layouts.admin')

@section('title', 'إدارة السيارات')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">إدارة الشركات والموديلات</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.models.create') }}" class="btn btn-success mb-3">إضافة موديل جديد</a>

    @foreach($brands as $brand)
        <div class="card mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <div>
                    {{ $brand->name }}
                </div>
                <div>
                    <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-sm btn-warning">تعديل</a>
                    <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد حذف الشركة؟');">
                        @csrf
                        <button class="btn btn-sm btn-danger">حذف</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @foreach($brand->models as $model)
                    <div class="mb-2">
                        <strong>{{ $model->name }}</strong>:
                        <a href="{{ route('admin.models.edit', $model->id) }}" class="btn btn-sm btn-outline-warning">تعديل</a>
                        <form action="{{ route('admin.models.destroy', $model->id) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف الموديل؟');">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger">حذف</button>
                        </form>
                        @foreach($model->years as $year)
                            <span class="badge badge-secondary">{{ $year->year }}</span>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

</div>
@endsection
