@extends('admin.layouts.admin')

@section('title', 'إضافة موديل جديد')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">إضافة شركة وموديل وسنوات</h4>

    @if ($errors->any())
        <div class="alert alert-danger"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('admin.cars.store') }}">
        @csrf

        <div class="form-group">
            <label>اسم الشركة</label>
            <input type="text" name="brand_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>اسم الموديل</label>
            <input type="text" name="model_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>سنوات الموديل (افصل بينها بفاصلة)</label>
            <input type="text" name="years_input" id="years_input" class="form-control" placeholder="مثال: 2015,2016,2017" required>
        </div>

        <input type="hidden" name="years[]" id="years">

        <button class="btn btn-primary btn-block">حفظ</button>
    </form>

</div>

<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        let raw = document.getElementById('years_input').value;
        let years = raw.split(',').map(y => y.trim()).filter(y => y);
        let yearsContainer = document.getElementById('years');
        years.forEach(year => {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'years[]';
            input.value = year;
            this.appendChild(input);
        });
    });
</script>
@endsection
