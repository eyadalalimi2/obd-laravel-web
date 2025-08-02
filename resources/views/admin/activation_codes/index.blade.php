@extends('admin.layouts.admin')
@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>إدارة رموز التفعيل</h1>
    <a href="{{ route('admin.activation_codes.create') }}" class="btn btn-primary">توليد رمز جديد</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>الرمز</th>
        <th>الباقة</th>
        <th>الاستخدامات المتبقية</th>
        <th>تاريخ الانتهاء</th>
        <th>الإجراءات</th>
      </tr>
    </thead>
    <tbody>
      @foreach($codes as $code)
      <tr>
        <td>{{ $code->id }}</td>
        <td>{{ $code->code }}</td>
        <td>{{ $code->plan->name }}</td>
        <td>{{ $code->uses_left }}</td>
        <td>{{ $code->expires_at?->format('Y-m-d') ?? '-' }}</td>
        <td>
          <a href="{{ route('admin.activation_codes.edit',$code) }}" class="btn btn-sm btn-warning">تعديل</a>
          <form action="{{ route('admin.activation_codes.destroy',$code) }}" method="POST" class="d-inline-block" onsubmit="return confirm('هل أنت متأكد؟');">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">حذف</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $codes->links() }}
</div>
@endsection
