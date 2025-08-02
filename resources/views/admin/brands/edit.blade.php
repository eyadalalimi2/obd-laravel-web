@extends('admin.layouts.admin')
@section('title', 'تعديل شركة')
@section('content')
<div class="container-fluid">
    <h4 class="mb-4">تعديل شركة</h4>
    <form method="POST" action="{{ route('admin.brands.update', $brand->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>اسم الشركة</label>
            <input type="text" name="name" class="form-control" value="{{ $brand->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
</div>
@endsection