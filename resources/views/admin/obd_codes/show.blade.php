@extends('admin.layouts.admin')

@section('title', 'تفاصيل كود OBD ' . $obdCode->code)

@push('styles')
<style>
    .detail-label { font-weight: 600; color: #333; }
    .detail-value { color: #555; }
    .btn-actions { margin-right: 5px; }
</style>
@endpush

@section('content')
<div class="container-fluid" style="direction: rtl;">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">تفاصيل الكود: {{ $obdCode->code }}</h5>
            <div>
                <a href="{{ route('admin.obd_codes.edit', $obdCode->id) }}" class="btn btn-sm btn-primary btn-actions">
                    <i class="fas fa-edit"></i> تعديل
                </a>
                <form action="{{ route('admin.obd_codes.destroy', $obdCode->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذا الكود؟');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger btn-actions">
                        <i class="fas fa-trash"></i> حذف
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            @php
                $fields = [
                    ['label' => 'رمز الكود',        'value' => $obdCode->code],
                    ['label' => 'النوع',            'value' => ucfirst($obdCode->type)],
                    ['label' => 'العلامة التجارية', 'value' => $obdCode->brand ? $obdCode->brand->name : '—'],
                    ['label' => 'العنوان',          'value' => $obdCode->title],
                    ['label' => 'الوصف',            'value' => $obdCode->description],
                    ['label' => 'الأعراض',           'value' => $obdCode->symptoms],
                    ['label' => 'الأسباب',           'value' => $obdCode->causes],
                    ['label' => 'الحلول',            'value' => $obdCode->solutions],
                    ['label' => 'الخطورة',           'value' => $obdCode->severity],
                    ['label' => 'التشخيص',           'value' => $obdCode->diagnosis],
                    ['label' => 'رابط المصدر',       'value' => $obdCode->source_url ? '<a href="' . $obdCode->source_url . '" target="_blank">' . $obdCode->source_url . '</a>' : '—'],
                    ['label' => 'حالة التفعيل',      'value' => $obdCode->status ? 'نشط' : 'معطّل'],
                    ['label' => 'تم الإنشاء في',     'value' => $obdCode->created_at->format('Y-m-d H:i')],
                    ['label' => 'آخر تحديث',         'value' => $obdCode->updated_at->format('Y-m-d H:i')],
                ];
            @endphp

            <div class="row">
                @foreach ($fields as $f)
                    <div class="col-md-4 mb-3">
                        <div class="detail-label">{{ $f['label'] }}</div>
                        <div class="detail-value">{!! $f['value'] !!}</div>
                    </div>
                @endforeach
            </div>

            {{-- عرض الصورة إن وجدت --}}
            <div class="row mt-3">
                <div class="col-md-12 detail-label">الصورة التوضيحية</div>
                <div class="col-md-12 detail-value">
                    @if ($obdCode->image)
                        <img src="{{ asset('storage/' . $obdCode->image) }}" alt="Image" class="img-fluid rounded" style="max-width:200px;">
                    @else
                        <span class="text-muted">بدون صورة</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('admin.obd_codes.index') }}" class="btn btn-light">
        <i class="fas fa-arrow-right"></i> العودة إلى القائمة
    </a>
</div>
@endsection
