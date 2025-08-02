@extends('admin.layouts.admin')
@section('title', 'إضافة شركة')
@section('content')
<div class="container-fluid">
    <h4 class="mb-4">إضافة شركة</h4>
    <form method="POST" action="{{ route('admin.brands.store') }}">
        @csrf
        <div class="form-group">
            <label>اسم الشركة</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
</div>
@endsection