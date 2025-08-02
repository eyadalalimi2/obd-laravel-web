@extends('admin.layouts.admin')

@section('title', 'قائمة المقالات')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>قائمة المقالات</h4>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> إضافة مقال</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped m-0">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>الصورة</th>
                        <th>العنوان</th>
                        <th>الكاتب</th>
                        <th>الحالة</th>
                        <th>تاريخ النشر</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" width="60" height="40">
                                @else
                                    <span class="text-muted">لا توجد صورة</span>
                                @endif
                            </td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->author->username ?? '-' }}</td>
                            <td>
                                <span class="badge badge-{{ $post->status == 'published' ? 'success' : 'secondary' }}">
                                    {{ $post->status == 'published' ? 'منشور' : 'مسودة' }}
                                </span>
                            </td>
                            <td>{{ $post->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                                <a href="{{ url('/article/' . $post->slug) }}" target="_blank" class="btn btn-sm btn-secondary">عرض</a>

                                <form action="{{ route('admin.posts.delete', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد حذف المقال؟');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">لا توجد مقالات</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
