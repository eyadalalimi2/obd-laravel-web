@extends('admin.layouts.admin')

@section('title', 'تعديل التصنيف')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">تعديل التصنيف: {{ $category->name }}</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
                @csrf

                <div class="form-group">
                    <label>اسم التصنيف</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                </div>

                <div class="form-group">
                    <label>الرابط (Slug)</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}">
                </div>

                <button type="submit" class="btn btn-primary btn-block">حفظ التعديلات</button>
            </form>
        </div>
    </div>

</div>
@endsection
