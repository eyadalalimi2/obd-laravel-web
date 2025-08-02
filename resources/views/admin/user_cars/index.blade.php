@extends('admin.layouts.admin')

@section('content')
    <h1>إدارة سيارات المستخدمين</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('admin.user_cars.create') }}" class="btn btn-primary">إضافة سيارة جديدة</a>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>المستخدم</th>
                <th>الشركة</th>
                <th>الموديل</th>
                <th>سنة الإنتاج</th>
                <th>اسم السيارة</th>
                <th>خيارات</th>
            </tr>
        </thead>
        <tbody>
        @foreach($cars as $car)
            <tr>
                <td>{{ $car->user->username ?? '-' }}</td>
                <td>{{ $car->brand->name ?? '-' }}</td>
                <td>{{ $car->model->name ?? '-' }}</td>
                <td>{{ $car->year }}</td>
                <td>{{ $car->car_name }}</td>
                <td>
                    <a href="{{ route('admin.user_cars.edit', $car->id) }}" class="btn btn-sm btn-warning">تعديل</a>
                    <form action="{{ route('admin.user_cars.destroy', $car->id) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('تأكيد الحذف؟')" class="btn btn-sm btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $cars->links() }}
@endsection
