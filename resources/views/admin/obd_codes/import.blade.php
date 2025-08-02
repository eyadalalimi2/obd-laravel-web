@extends('admin.layouts.admin')

@section('title', 'استيراد أكواد OBD')

@section('content')
<div class="container-fluid">
  <h1>رفع ملف JSON لاستيراد أكواد OBD</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @error('json_file')
    <div class="alert alert-danger">{{ $message }}</div>
  @enderror

  @if(session('row_errors'))
    <ul class="mt-2 alert alert-warning">
      @foreach(session('row_errors') as $line => $errs)
        <li>السطر {{ $line }}:
          <ul>
            @foreach($errs as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </li>
      @endforeach
    </ul>
  @endif

  <form action="{{ route('admin.obd_codes.import_validate') }}"
        method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="json_file">اختر ملف JSON:</label>
      <input type="file" name="json_file" id="json_file"
             class="form-control" accept=".json">
    </div>
    <button class="btn btn-primary mt-2">تحقق من الملف</button>
  </form>
</div>
@endsection
