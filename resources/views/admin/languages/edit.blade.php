@extends('admin.layouts.admin')

@section('title', 'تعديل اللغة')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">تعديل اللغة: {{ $language->name }}</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.languages.update', $language->id) }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label>اسم اللغة</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $language->name) }}" required>
                </div>

                <div class="form-group">
                    <label>رمز اللغة (مثال: en, ar)</label>
                    <input type="text" name="code" class="form-control" value="{{ old('code', $language->code) }}" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">حفظ التعديلات</button>
            </form>
        </div>
    </div>

</div>
@endsection
