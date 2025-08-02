@extends('admin.layouts.admin')

@section('title', 'إدارة الأعمدة')

@section('content')
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- قائمة الأعمدة -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">قائمة الأعمدة</div>
        <div class="card-body">
            @foreach($columns as $table => $cols)
                <div class="mb-4">
                    <h5><i class="fas fa-table"></i> {{ $table }}</h5>
                    <table class="table table-bordered table-sm table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>النوع</th>
                                <th>الافتراضي</th>
                                <th>المفتاح</th>
                                <th>الإجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cols as $col)
                                <tr>
                                    <td>{{ $col['Field'] }}</td>
                                    <td>{{ $col['Type'] }}</td>
                                    <td>{{ $col['Default'] ?? '-' }}</td>
                                    <td>{{ $col['Key'] ?: '-' }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.database.dropColumn') }}" class="d-inline" onsubmit="return confirm('حذف العمود؟');">
                                            @csrf
                                            <input type="hidden" name="table" value="{{ $table }}">
                                            <input type="hidden" name="column" value="{{ $col['Field'] }}">
                                            <button class="btn btn-sm btn-danger">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>

    <!-- إضافة عمود -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">إضافة عمود</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.database.addColumn') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>اختر الجدول</label>
                        <select name="table" class="form-control" required>
                            @foreach($tables as $table)
                                <option value="{{ $table }}">{{ $table }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>اسم العمود</label>
                        <input type="text" name="column" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>نوع العمود (مثال: VARCHAR(255))</label>
                        <input type="text" name="type" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>هل يقبل القيمة الفارغة؟</label>
                    <select name="nullable" class="form-control">
                        <option value="no">لا</option>
                        <option value="yes">نعم</option>
                    </select>
                </div>

                <button class="btn btn-success btn-block">إضافة</button>
            </form>
        </div>
    </div>

    <!-- تعديل عمود -->
    <div class="card">
        <div class="card-header bg-warning text-dark">تعديل عمود</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.database.editColumn') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>اختر الجدول</label>
                        <select name="table" class="form-control" required>
                            @foreach($tables as $table)
                                <option value="{{ $table }}">{{ $table }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>العمود الحالي</label>
                        <input type="text" name="old_column" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>الاسم الجديد</label>
                        <input type="text" name="new_column" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>نوع العمود</label>
                        <input type="text" name="type" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>هل يقبل القيمة الفارغة؟</label>
                    <select name="nullable" class="form-control">
                        <option value="no">لا</option>
                        <option value="yes">نعم</option>
                    </select>
                </div>

                <button class="btn btn-warning btn-block">تعديل</button>
            </form>
        </div>
    </div>

</div>
@endsection
