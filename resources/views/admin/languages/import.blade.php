@extends('admin.layouts.admin')

@section('title', 'استيراد ترجمة JSON')

@section('content')
<div class="container-fluid">
    <h4>استيراد ترجمات JSON للغة: {{ $language->name }}</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.languages.importJson', $language->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>ملف JSON</label>
            <input type="file" name="json_file" class="form-control-file" required>
        </div>
        <button type="submit" class="btn btn-primary">استيراد</button>
    </form>
</div>
@endsection
