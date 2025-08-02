@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
  <h1 class="mb-4">إنشاء باقة جديدة</h1>
  <form action="{{ route('admin.plans.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="name">اسم الباقة</label>
      <input type="text" name="name" id="name"
             class="form-control @error('name') is-invalid @enderror"
             value="{{ old('name') }}">
      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="price">السعر</label>
        <input type="number" step="0.01" name="price" id="price"
               class="form-control @error('price') is-invalid @enderror"
               value="{{ old('price', 0) }}">
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-group col-md-4">
        <label for="duration_days">المدة (أيام)</label>
        <input type="number" name="duration_days" id="duration_days"
               class="form-control @error('duration_days') is-invalid @enderror"
               value="{{ old('duration_days', 0) }}">
        @error('duration_days')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-group col-md-4">
        <div class="form-check mt-4">
          {{-- يضمن إرسال القيمة 0 إذا لم يُحدد --}}
          <input type="hidden" name="is_active" value="0">
          <input type="checkbox" name="is_active" id="is_active" value="1"
                 class="form-check-input"
                 {{ old('is_active', 1) ? 'checked' : '' }}>
          <label class="form-check-label" for="is_active">مفعّلة</label>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label for="features_json">المزايا (اختر عدة)</label>
      <select name="features_json[]" id="features_json" multiple
              class="form-control @error('features_json') is-invalid @enderror">
        @php
          $all = [
            'SEARCH_CODES'                 => 'البحث عن الأكواد',
            'SAVE_CODES'                   => 'حفظ الأكواد',
            'SHARE_CODES'                  => 'مشاركة الأكواد',
            'COMPARE_CODES'                => 'مقارنة الأكواد',
            'OFFLINE_MODE'                 => 'وضع اوفلاين',
            'DIAGNOSIS_HISTORY'            => 'سجل التشخيص',
            'SYMPTOM_BASED_DIAGNOSIS'      => 'تشخيص حسب الأعراض',
            'SMART_NOTIFICATIONS'          => 'إشعارات ذكية',
            'PDF_REPORT'                   => 'توليد تقرير PDF',
            'TRENDING_CODES_ANALYTICS'     => 'تحليل أكواد شائعة',
            'VISUAL_COMPONENT_LIBRARY'     => 'مكتبة المكونات',
            'AI_DIAGNOSTIC_ASSISTANT'      => 'مساعد ذكي',
          ];
          $selected = old('features_json', []);
        @endphp
        @foreach($all as $key => $label)
          <option value="{{ $key }}"
            {{ in_array($key, $selected) ? 'selected' : '' }}>
            {{ $label }}
          </option>
        @endforeach
      </select>
      @error('features_json')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <button type="submit" class="btn btn-success">حفظ الباقة</button>
    <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">إلغاء</a>
  </form>
</div>
@endsection
