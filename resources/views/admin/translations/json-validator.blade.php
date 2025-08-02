@extends('admin.layouts.admin')

@section('title', 'التحقق من ملف JSON')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">التحقق من ملف JSON للترجمات</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.translations.json_validator.submit') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>اختيار ملف JSON</label>
            <input type="file" name="json_file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">التحقق من الملف</button>
    </form>
</div>
@endsection
