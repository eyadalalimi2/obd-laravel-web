@extends('admin.layouts.admin')

@section('title', 'الأسئلة الشائعة')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h4>الأسئلة الشائعة</h4>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-success">إضافة سؤال</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>السؤال</th>
                        <th>الفئة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faqs as $faq)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $faq->question }}</td>
                            <td>{{ $faq->category ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                                <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد حذف هذا السؤال؟');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">لا توجد أسئلة حتى الآن.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
