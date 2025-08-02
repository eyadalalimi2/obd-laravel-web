@extends('admin.layouts.admin')

@section('title', 'تعديل صفحة')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">تعديل الصفحة: {{ $page->title }}</h4>

    @if ($errors->any())
        <div class="alert alert-danger"><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('admin.pages.update', $page->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>العنوان</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title', $page->title) }}">
        </div>

        <div class="form-group">
            <label>الرابط (slug)</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $page->slug) }}">
        </div>

        <div class="form-group">
            <label>المحتوى</label>
            <textarea name="content" class="form-control" rows="6">{{ old('content', $page->content) }}</textarea>
        </div>

        <div class="form-group">
            <label>الحالة</label>
            <select name="status" class="form-control" required>
                <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>منشورة</option>
                <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>مسودة</option>
            </select>
        </div>

        <button class="btn btn-primary btn-block">تحديث</button>
    </form>

</div>
@endsection
