@extends('admin.layouts.admin')
@section('title', 'إضافة كود جديد')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">إضافة كود جديد</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.obd_codes.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group"><label>رمز الكود</label><input type="text" name="code" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label for="type">نوع الكود <span class="text-danger">*</span></label>
                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                    <option value="generic" {{ old('type')=='generic'? 'selected':'' }}>عام</option>
                    <option value="manufacturer" {{ old('type')=='manufacturer'? 'selected':'' }}>خاص بالشركة</option>
                </select>
                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

        {{-- العلامة التجارية والفئة --}}
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="brand_id">الشركه المصنعة </label>
                <select name="brand_id" id="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                    <option value="">-- اختر الشركه --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id')==$brand->id? 'selected':'' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
        </div>
            <div class="form-group"><label>العنوان</label><input type="text" name="title" class="form-control"
                    required></div>
            <div class="form-group"><label>الوصف</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="form-group"><label>الأعراض</label>
                <textarea name="symptoms" class="form-control"></textarea>
            </div>
            <div class="form-group"><label>الأسباب</label>
                <textarea name="causes" class="form-control"></textarea>
            </div>
            <div class="form-group"><label>الحلول</label>
                <textarea name="solutions" class="form-control"></textarea>
            </div>
            <div class="form-group"><label>درجة الخطوره</label><input type="text" name="severity" class="form-control"></div>
            <div class="form-group"><label>التشخيص</label>
                <textarea name="diagnosis" class="form-control"></textarea>
            </div>
            <div class="form-group"><label>التصنيف</label><input type="text" name="category" class="form-control"></div>
            <div class="form-group"><label>رابط المصدر</label><input type="text" name="source_url" class="form-control">
            </div>
            <div class="form-group"><label>الصورة</label><input type="file" name="image" class="form-control-file">
            </div>

            <button type="submit" class="btn btn-primary btn-block">حفظ الكود</button>
        </form>

    </div>
@endsection
