@extends('admin.layouts.admin')
@section('content')
    <div class="container">
     <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>إدارة الاشتراكات</h1>
    <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary">
      إضافة اشتراك جديد
    </a>
  </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>اسم المستخدم</th>
                    <th>البريد الالكتروني</th>
                    <th>الباقة</th>
                    <th>بدء</th>
                    <th>انتهاء</th>
                    <th>الحالة</th>
                    <th>المنصة</th>
                    <th>رمز الدفع</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscriptions as $sub)
                    <tr>
                        <td>{{ $sub->id }}</td>
                        <td>{{ $sub->user->username }}</td>
                        <td>{{ $sub->user->email }}</td>
                        <td>{{ $sub->plan->name }}</td>
                        <td>{{ $sub->start_at->format('Y-m-d') }}</td>
                        <td>{{ $sub->end_at->format('Y-m-d') }}</td>
                        <td>
                            <span
                                class="badge badge-{{ $sub->status == 'active' ? 'success' : ($sub->status == 'expired' ? 'secondary' : 'danger') }}">
                                {{ ucfirst($sub->status) }}
                            </span>
                        </td>
                        <td>{{ $sub->platform }}</td>
                        <td>{{ Str::limit($sub->txn_token, 10, '...') }}</td>
                        <td>
          <a href="{{ route('admin.subscriptions.show',$sub) }}" class="btn btn-sm btn-info">عرض</a>
          <form action="{{ route('admin.subscriptions.destroy',$sub) }}" method="POST" class="d-inline-block" onsubmit="return confirm('هل أنت متأكد؟');">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">حذف</button>
          </form>
        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $subscriptions->links() }}
    </div>
@endsection
