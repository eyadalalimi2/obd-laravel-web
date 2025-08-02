@extends('admin.layouts.admin')

@section('title', 'سجل الأحداث')

@section('content')
<div class="container-fluid">
    <h4>سجل الأحداث</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <form method="POST" action="{{ route('admin.system.logs.clear') }}" style="display: inline-block;">
            @csrf
            <button type="submit" class="btn btn-danger">مسح السجل</button>
        </form>

        <a href="{{ route('admin.system.logs.download') }}" class="btn btn-primary">تنزيل السجل</a>
    </div>

    <div style="white-space: pre-wrap; background: #f8f9fa; padding: 15px; border-radius: 5px; max-height: 600px; overflow-y: auto;">
        {!! nl2br(e($logs)) !!}
    </div>
</div>
@endsection
