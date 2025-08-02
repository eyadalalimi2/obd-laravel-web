@extends('admin.layouts.admin')

@section('title', 'استيراد ترجمات JSON')

@section('content')
<div class="container mt-4">
    <h4>استيراد ملف ترجمات JSON</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.translations.import.validate') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>اختر ملف JSON:</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button class="btn btn-primary">التحقق من الملف</button>
    </form>

    @if(session('validation_errors'))
        <h5 class="mt-4">الأخطاء المكتشفة:</h5>
        <ul>
            @foreach (session('validation_errors') as $line => $errors)
                <li>السطر {{ $line }}:
                    <ul>
                        @foreach ($errors as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    @elseif(session('validated_translations'))
        <form action="{{ route('admin.translations.import.process') }}" method="POST" class="mt-3">
            @csrf
            <button class="btn btn-success">استيراد الترجمات</button>
        </form>
    @endif
</div>
@endsection
