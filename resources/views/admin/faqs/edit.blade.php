@extends('admin.layouts.admin')

@section('title', 'تعديل سؤال')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">تعديل السؤال: {{ $faq->question }}</h4>

    @if ($errors->any())
        <div class="alert alert-danger"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('admin.faqs.update', $faq->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>السؤال</label>
            <input type="text" name="question" class="form-control" required value="{{ old('question', $faq->question) }}">
        </div>

        <div class="form-group">
            <label>الإجابة</label>
            <textarea name="answer" class="form-control" rows="5" required>{{ old('answer', $faq->answer) }}</textarea>
        </div>

        <div class="form-group">
            <label>الفئة</label>
            <input type="text" name="category" class="form-control" value="{{ old('category', $faq->category) }}">
        </div>

        <button class="btn btn-primary btn-block">تحديث</button>
    </form>

</div>
@endsection
