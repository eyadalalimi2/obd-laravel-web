@extends('admin.layouts.admin')
@section('content')
<div class="container">
  <h1>تفاصيل الاشتراك #{{ $subscription->id }}</h1>

  <table class="table table-bordered">
    <tr>
      <th>المستخدم</th>
      <td>{{ $subscription->user->username }} ({{ $subscription->user->email }})</td>
    </tr>
    <tr>
      <th>الباقة</th>
      <td>{{ $subscription->plan->name }}</td>
    </tr>
    <tr>
      <th>تاريخ البدء</th>
      <td>{{ $subscription->start_at->format('Y-m-d H:i') }}</td>
    </tr>
    <tr>
      <th>تاريخ الانتهاء</th>
      <td>{{ $subscription->end_at->format('Y-m-d H:i') }}</td>
    </tr>
    <tr>
      <th>الحالة</th>
      <td>{{ ucfirst($subscription->status) }}</td>
    </tr>
    <tr>
      <th>المنصة</th>
      <td>{{ $subscription->platform }}</td>
    </tr>
    <tr>
      <th>رمز التحقق</th>
      <td>{{ $subscription->txn_token ?? '-' }}</td>
    </tr>
    <tr>
      <th>أنشأ في</th>
      <td>{{ $subscription->created_at->format('Y-m-d H:i') }}</td>
    </tr>
    
  </table>

  <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">العودة</a>
  <form action="{{ route('admin.subscriptions.cancel', $subscription) }}" method="POST" class="d-inline">
        @csrf
        <button class="btn btn-danger" onclick="return confirm('هل تريد إلغاء الاشتراك؟')">إلغاء الاشتراك</button>
      </form>

      <form action="{{ route('admin.subscriptions.renew', $subscription) }}" method="POST" class="d-inline">
        @csrf
        <button class="btn btn-success">تجديد الاشتراك</button>
      </form>
</div>
@endsection
