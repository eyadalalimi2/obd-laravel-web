@extends('admin.layouts.admin')

@section('content')
    <h1>تعديل سيارة مستخدم</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.user_cars.update', $car->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>المستخدم</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $id => $name)
                    <option value="{{ $id }}" {{ ($car->user_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>الشركة</label>
            <select name="brand_id" id="brand_id" class="form-control" required>
                <option value="">اختر الشركة</option>
                @foreach($brands as $id => $name)
                    <option value="{{ $id }}" {{ ($car->brand_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>الموديل</label>
            <select name="model_id" id="model_id" class="form-control" required>
                <option value="">اختر الموديل</option>
                @foreach($models as $id => $name)
                    <option value="{{ $id }}" {{ ($car->model_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>سنة الإنتاج</label>
            <select name="year" id="year" class="form-control" required>
                <option value="">اختر السنة</option>
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ ($car->year == $year) ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>اسم السيارة (اختياري)</label>
            <input type="text" name="car_name" class="form-control" value="{{ old('car_name', $car->car_name) }}">
        </div>

        <button type="submit" class="btn btn-success">تحديث</button>
        <a href="{{ route('admin.user_cars.index') }}" class="btn btn-secondary">رجوع</a>
    </form>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // عند تغيير الشركة في التعديل
    $('#brand_id').change(function() {
        var brandId = $(this).val();
        $('#model_id').html('<option value="">انتظر...</option>');
        $('#year').html('<option value="">اختر السنة</option>');
        if (brandId) {
            $.get('/admin/brands/' + brandId + '/models', function(data) {
                var models = '<option value="">اختر الموديل</option>';
                $.each(data, function(id, name) {
                    models += '<option value="' + id + '">' + name + '</option>';
                });
                $('#model_id').html(models);
            });
        } else {
            $('#model_id').html('<option value="">اختر الشركة أولا</option>');
        }
    });

    // عند تغيير الموديل في التعديل
    $('#model_id').change(function() {
        var modelId = $(this).val();
        $('#year').html('<option value="">انتظر...</option>');
        if (modelId) {
            $.get('/admin/models/' + modelId + '/years', function(data) {
                var years = '<option value="">اختر السنة</option>';
                $.each(data, function(i, year) {
                    years += '<option value="' + year + '">' + year + '</option>';
                });
                $('#year').html(years);
            });
        } else {
            $('#year').html('<option value="">اختر الموديل أولا</option>');
        }
    });
});
</script>
@endpush
