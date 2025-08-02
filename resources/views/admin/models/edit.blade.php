@extends('admin.layouts.admin')
@section('title', 'تعديل موديل')
@section('content')
<div class="container-fluid">
    <h4 class="mb-4">تعديل موديل</h4>
    <form method="POST" action="{{ route('admin.models.update', $model->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>اسم الموديل</label>
            <input type="text" name="name" class="form-control" value="{{ $model->name }}" required>
        </div>
        <div class="form-group">
            <label>الشركة</label>
            <select name="brand_id" class="form-control" required>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $brand->id == $model->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
</div>
@endsection