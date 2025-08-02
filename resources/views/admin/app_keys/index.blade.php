@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <h3 class="mb-4">إدارة مفاتيح التطبيقات</h3>
        <a href="{{ route('admin.app_keys.create') }}" class="btn btn-success mb-3">إضافة مفتاح جديد</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>حزمة التطبيق</th>
                    <th>اصدار التطبيق</th>
                    <th>مفتاح التشفير</th>
                    <th>تاريخ ألأنتهاء</th>
                    <th>خيارات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($keys as $key)
                    <tr>
                        <td>{{ $key->id }}</td>
                        <td>{{ $key->package_name }}</td>
                        <td>{{ $key->version_code }}</td>
                        <td><code>{{ $key->encryption_key }}</code></td>
                        <td>{{ $key->expires_at }}</td>
                        <td>
                            <form action="{{ route('admin.app_keys.destroy', $key->id) }}" method="POST"
                                onsubmit="return confirm('تأكيد الحذف؟')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $keys->links() }}
    </div>
@endsection
