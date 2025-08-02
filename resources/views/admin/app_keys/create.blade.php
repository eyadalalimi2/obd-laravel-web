@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <h3 class="mb-4">إضافة مفتاح جديد</h3>

    <form action="{{ route('admin.app_keys.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>حزمة التطبيق</label>
            <input type="text" name="package_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>اصدار التطبيق</label>
            <input type="text" name="version_code" class="form-control" required>
        </div>

        <button class="btn btn-primary">إنشاء المفتاح</button>
    </form>
</div>
@endsection
