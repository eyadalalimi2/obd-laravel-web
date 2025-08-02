@extends('admin.layouts.admin')

@section('title', 'ترجمة لوحة التحكم')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">ترجمة لوحة التحكم</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.translations.update') }}" method="POST">
        @csrf
        <input type="hidden" name="lang" value="both">

        <div class="card">
            <div class="card-header bg-dark text-white">جميع الترجمات</div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>المفتاح</th>
                            <th>اللغة العربية</th>
                            <th>اللغة الإنجليزية</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($keys as $key)
                            <tr>
                                <td><strong>{{ $key }}</strong></td>
                                <td>
                                    <input type="text" name="translations[ar][{{ $key }}]" class="form-control"
                                        value="{{ $ar[$key] ?? '' }}">
                                </td>
                                <td>
                                    <input type="text" name="translations[en][{{ $key }}]" class="form-control"
                                        value="{{ $en[$key] ?? '' }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block mt-3">حفظ التعديلات</button>
    </form>

</div>
@endsection
