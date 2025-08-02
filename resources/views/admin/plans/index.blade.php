@extends('admin.layouts.admin')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>إدارة الباقات</h1>
    <a href="{{ route('admin.plans.create') }}" class="btn btn-primary">إضافة باقة جديدة</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-bordered table-hover">
    <thead class="thead-light">
      <tr>
        <th>#</th>
        <th>الاسم</th>
        <th>السعر</th>
        <th>المدة (أيام)</th>
        <th>الحالة</th>
        <th>الإجراءات</th>
      </tr>
    </thead>
    <tbody>
      @foreach($plans as $plan)
      <tr>
        <td>{{ $plan->id }}</td>
        <td>{{ $plan->name }}</td>
        <td>{{ number_format($plan->price, 2) }}</td>
        <td>{{ $plan->duration_days }}</td>
        <td>{!! $plan->is_active ? '<span class="badge badge-success">نشطة</span>' : '<span class="badge badge-secondary">معطلة</span>' !!}</td>
        <td>
          <a href="{{ route('admin.plans.edit',$plan) }}" class="btn btn-sm btn-warning">تعديل</a>
          <form action="{{ route('admin.plans.destroy',$plan) }}" method="POST" class="d-inline-block" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">حذف</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $plans->links() }}
</div>
@endsection
