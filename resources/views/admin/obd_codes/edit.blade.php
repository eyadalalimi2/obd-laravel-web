@extends('admin.layouts.admin')
@section('title', 'تعديل كود')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">تعديل الكود: {{ $obdCode->code }}</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.obd_codes.update', $obdCode->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="type">نوع الكود <span class="text-danger">*</span></label>
                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                    <option value="generic" {{ old('type', $obdCode->type) == 'generic' ? 'selected' : '' }}>عام</option>
                    <option value="manufacturer" {{ old('type', $obdCode->type) == 'manufacturer' ? 'selected' : '' }}>خاص
                        بالشركة</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="brand_id">العلامة التجارية</label>
                <select name="brand_id" id="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                    <option value="">-- اختر العلامة --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $obdCode->brand_id)==$brand->id? 'selected':'' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group"><label>العنوان</label><input type="text" name="title" class="form-control"
                    value="{{ old('title', $obdCode->title) }}" required></div>
            <div class="form-group"><label>الوصف</label>
                <textarea name="description" class="form-control">{{ old('description', $obdCode->description) }}</textarea>
            </div>
            <div class="form-group"><label>الأعراض</label>
                <textarea name="symptoms" class="form-control">{{ old('symptoms', $obdCode->symptoms) }}</textarea>
            </div>
            <div class="form-group"><label>الأسباب</label>
                <textarea name="causes" class="form-control">{{ old('causes', $obdCode->causes) }}</textarea>
            </div>
            <div class="form-group"><label>الحلول</label>
                <textarea name="solutions" class="form-control">{{ old('solutions', $obdCode->solutions) }}</textarea>
            </div>
            <div class="form-group"><label>الخطورة</label><input type="text" name="severity" class="form-control"
                    value="{{ old('severity', $obdCode->severity) }}"></div>
            <div class="form-group"><label>تشخيص</label>
                <textarea name="diagnosis" class="form-control">{{ old('diagnosis', $obdCode->diagnosis) }}</textarea>
            </div>
            <div class="form-group"><label>التصنيف</label><input type="text" name="category" class="form-control"
                    value="{{ old('category', $obdCode->category) }}"></div>
            <div class="form-group"><label>رابط المصدر</label><input type="text" name="source_url" class="form-control"
                    value="{{ old('source_url', $obdCode->source_url) }}"></div>

            <div class="form-group">
                <label>الصورة</label>
                <input type="file" name="image" class="form-control-file">
                @if ($obdCode->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $obdCode->image) }}" width="100">
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary btn-block">تحديث الكود</button>
        </form>

    </div>
@endsection
