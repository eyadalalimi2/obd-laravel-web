@extends('admin.layouts.admin')
@section('title', 'إضافة لغة جديدة')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">إضافة لغة جديدة</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.languages.store') }}">
        @csrf
        <div class="form-group">
            <label>اسم اللغة</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>رمز اللغة (مثال: ar, en, fr)</label>
            <input type="text" name="code" class="form-control" required>
        </div>

        <div class="form-group">
            <label>الحالة</label>
            <select name="is_active" class="form-control">
                <option value="1">مفعلة</option>
                <option value="0">معطلة</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary btn-block">حفظ اللغة</button>
    </form>

    <a href="{{ route('admin.languages.index') }}" class="btn btn-secondary mt-3">رجوع للقائمة</a>

</div>
@endsection