@extends('admin.layouts.admin')
@section('title', 'إضافة موديل')
@section('content')
<div class="container-fluid">
    <h4 class="mb-4">إضافة موديل</h4>
    <form method="POST" action="{{ route('admin.models.store') }}">
        @csrf
        <div class="form-group">
            <label>اسم الموديل</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>الشركة</label>
            <select name="brand_id" class="form-control" required>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
</div>
@endsection
