@extends('admin.layouts.admin')

@section('title', 'معاينة استيراد أكواد OBD')

@section('content')
<div class="container-fluid">
  <h1>معاينة البيانات قبل الاستيراد</h1>

  <form method="POST" action="{{ route('admin.obd_codes.import_confirm') }}">
    @csrf
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>الكود</th>
          <th>العنوان</th>
          <th>الوصف</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $i => $row)
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $row['code'] }}</td>
            <td>{{ $row['title'] }}</td>
            <td>{{ Str::limit($row['description'], 50) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <button type="submit" class="btn btn-success">تأكيد الاستيراد</button>
    <a href="{{ route('admin.obd_codes.import_form') }}"
       class="btn btn-secondary">إلغاء</a>
  </form>
</div>
@endsection
