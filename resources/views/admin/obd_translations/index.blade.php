@extends('admin.layouts.admin')
@section('title', 'ترجمة أكواد الأعطال')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">ترجمة أكواد الأعطال</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover m-0">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>الكود</th>
                        <th>العنوان</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($obdCodes as $code)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $code->code }}</td>
                            <td>{{ $code->title }}</td>
                            <td>
                                <a href="{{ route('admin.obd_translations.edit', $code->id) }}" class="btn btn-sm btn-primary">
                                    ترجمة
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">لا توجد أكواد بعد</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
