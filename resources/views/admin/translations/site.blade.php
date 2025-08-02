@extends('admin.layouts.admin')

@section('title', 'ترجمة واجهة الموقع')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">ترجمة واجهة الموقع</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.translations.site.update') }}">
        @csrf

        <div class="card">
            <div class="card-header bg-primary text-white">
                ترجمة النصوص العامة
            </div>
            <div class="card-body table-responsive">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>المفتاح</th>
                            <th>العربية</th>
                            <th>الإنجليزية</th>
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

                <button type="submit" class="btn btn-success btn-block mt-3">حفظ التعديلات</button>

            </div>
        </div>

    </form>

</div>
@endsection
