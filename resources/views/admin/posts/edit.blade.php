@extends('admin.layouts.admin')

@section('title', 'تعديل مقال')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">تعديل مقال: {{ $post->title }}</h4>

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
            <form method="POST" action="{{ route('admin.posts.update', $post->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>عنوان المقال</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
                </div>

                <div class="form-group">
                    <label>الرابط (Slug)</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug) }}">
                </div>

                <div class="form-group">
                    <label>المحتوى</label>
                    <textarea name="content" rows="6" class="form-control">{{ old('content', $post->content) }}</textarea>
                </div>

                <div class="form-group">
                    <label>الصورة</label>
                    <input type="file" name="image" class="form-control-file">
                    @if($post->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $post->image) }}" width="100">
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>التصنيف</label>
                    <select name="category_id" class="form-control">
                        <option value="">اختر تصنيف</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>الكاتب</label>
                    <select name="author_id" class="form-control" required>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ old('author_id', $post->author_id) == $author->id ? 'selected' : '' }}>
                                {{ $author->username }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>الحالة</label>
                    <select name="status" class="form-control" required>
                        <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>مسودة</option>
                        <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>منشور</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-block">حفظ التعديلات</button>
            </form>
        </div>
    </div>

</div>
@endsection

<script>
    $(document).ready(function() {
        $('textarea[name="content"]').summernote({
            height: 200,
            lang: 'ar-AR'
        });
    });
</script>
