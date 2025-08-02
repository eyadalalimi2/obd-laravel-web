@extends('admin.layouts.admin')

@section('title', 'إضافة سؤال')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">إضافة سؤال جديد</h4>

    @if ($errors->any())
        <div class="alert alert-danger"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('admin.faqs.store') }}">
        @csrf

        <div class="form-group">
            <label>السؤال</label>
            <input type="text" name="question" class="form-control" required value="{{ old('question') }}">
        </div>

        <div class="form-group">
            <label>الإجابة</label>
            <textarea name="answer" class="form-control" rows="5" required>{{ old('answer') }}</textarea>
        </div>

        <div class="form-group">
            <label>الفئة (اختياري)</label>
            <input type="text" name="category" class="form-control" value="{{ old('category') }}">
        </div>

        <button class="btn btn-primary btn-block">حفظ</button>
    </form>

</div>
@endsection
