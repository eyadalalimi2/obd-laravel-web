@extends('admin.layouts.admin')

@section('content')
    <h1>إضافة سيارة مستخدم</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.user_cars.store') }}">
        @csrf

        <div class="form-group">
            <label>المستخدم</label>
            <select name="user_id" class="form-control" required>
                @foreach ($users as $id => $name)
                    <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>الشركة</label>
            <select name="brand_id" id="brand_id" class="form-control" required>
                <option value="">اختر الشركة</option>
                @foreach ($brands as $id => $name)
                    <option value="{{ $id }}" {{ old('brand_id') == $id ? 'selected' : '' }}>{{ $name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>الموديل</label>
            <select name="model_id" id="model_id" class="form-control" required>
                <option value="">اختر الموديل</option>
                {{-- عند أول تحميل، القائمة فارغة --}}
                @if (isset($models))
                    @foreach ($models as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="form-group">
            <label>سنة الإنتاج</label>
            <select name="year" id="year" class="form-control" required>
                <option value="">اختر السنة</option>
                {{-- عند أول تحميل، القائمة فارغة --}}
                @if (isset($years))
                    @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                @endif
            </select>
        </div>


        <div class="form-group">
            <label>اسم السيارة (اختياري)</label>
            <input type="text" name="car_name" class="form-control" value="{{ old('car_name') }}">
        </div>

        <button type="submit" class="btn btn-success">إضافة</button>
        <a href="{{ route('admin.user_cars.index') }}" class="btn btn-secondary">رجوع</a>
    </form>
@endsection

@push('scripts')
    <script>
        alert('Javascript Loaded!');
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // تعبئة الموديلات بناءً على الشركة
            $('#brand_id').change(function() {
                var brandId = $(this).val();
                console.log("Brand changed: ", brandId); // سطر فحص
                $('#model_id').html('<option value="">انتظر...</option>');
                $('#year').html('<option value="">اختر السنة</option>');
                if (brandId) {
                    $.get('/admin/brands/' + brandId + '/models', function(data) {
                        console.log("Data from backend: ", data); // سطر فحص
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

            // تعبئة السنوات بناءً على الموديل
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
