@extends('admin.layouts.admin')
@section('title', 'إضافة سنة')
@section('content')
<div class="container-fluid">
    <h4 class="mb-4">إضافة سنة</h4>
    <form method="POST" action="{{ route('admin.model_years.store') }}">
        @csrf
        <div class="form-group">
            <label>السنة</label>
            <input type="number" name="year" class="form-control" required>
        </div>
        <div class="form-group">
            <label>الموديل</label>
            <select name="model_id" class="form-control" required>
                @foreach($models as $model)
                    <option value="{{ $model->id }}">{{ $model->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
</div>
@endsection