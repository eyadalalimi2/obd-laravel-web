@extends('admin.layouts.admin')

@section('title', 'تنفيذ استعلام SQL')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">تنفيذ استعلام SQL</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.database.sql') }}">
        @csrf
        <div class="form-group">
            <label for="query">الاستعلام</label>
            <textarea name="query" id="query" rows="6" class="form-control" placeholder="مثال: SELECT * FROM users">{{ old('query') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">تنفيذ</button>
    </form>

    @if (isset($results) && is_array($results) && count($results))
        <hr>
        <h5>نتائج الاستعلام:</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        @foreach(array_keys((array)$results[0]) as $column)
                            <th>{{ $column }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $row)
                        <tr>
                            @foreach((array)$row as $value)
                                <td>{{ $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif(isset($results))
        <p class="mt-3 text-muted">لا توجد نتائج.</p>
    @endif

</div>
@endsection
