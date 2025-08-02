@extends('admin.layouts.admin')
@section('title', 'تعديل سنة')
@section('content')
<div class="container-fluid">
    <h4 class="mb-4">تعديل سنة</h4>
    <form method="POST" action="{{ route('admin.model_years.update', $model_year->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>السنة</label>
            <input type="number" name="year" class="form-control" value="{{ $model_year->year }}" required>
        </div>
        <div class="form-group">
            <label>الموديل</label>
            <select name="model_id" class="form-control" required>
                @foreach($models as $model)
                    <option value="{{ $model->id }}" {{ $model->id == $model_year->model_id ? 'selected' : '' }}>{{ $model->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
</div>
@endsection