@extends('admin.layouts.admin')

@section('title', 'عرض بيانات المستخدم')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">تفاصيل المستخدم</h4>

    <div class="card shadow-sm">
        <div class="card-body">

            @if($user->profile_image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="الصورة الشخصية" style="width: 120px; height: 120px; border-radius: 50%;">
                </div>
            @endif

            <p><strong>اسم المستخدم:</strong> {{ $user->username }}</p>
            <p><strong>البريد الإلكتروني:</strong> {{ $user->email ?? 'لا يوجد' }}</p>
            <p><strong>رقم الهاتف:</strong> {{ $user->phone ?? 'لا يوجد' }}</p>
            <p><strong>المسمى الوظيفي:</strong> {{ $user->job_title ?? 'غير محدد' }}</p>
            <p><strong>اسم الباقة:</strong> {{ $user->package_name ?? 'غير مشترك' }}</p>
            <p><strong>نوع المستخدم:</strong> {{ $user->user_mode == 'guest' ? 'زائر' : 'مشترك' }}</p>
            <p><strong>الخطة الحالية:</strong> {{ $user->current_plan ?? 'لا توجد' }}</p>
            <p><strong>تاريخ بدء الخطة:</strong> {{ $user->plan_start_date ?? '-' }}</p>
            <p><strong>تاريخ تجديد الخطة:</strong> {{ $user->plan_renewal_date ?? '-' }}</p>
            <p><strong>هل أدمن؟:</strong> {{ $user->is_admin ? 'نعم' : 'لا' }}</p>
            <p><strong>الدور:</strong> {{ $user->role }}</p>
            <p><strong>حالة الحساب:</strong> {{ $user->status == 'active' ? 'نشط' : 'موقوف' }}</p>
            <p><strong>تم التحقق من البريد:</strong> {{ $user->email_verified_at ? 'نعم' : 'لا' }}</p>
            <p><strong>تاريخ الإنشاء:</strong> {{ $user->created_at->translatedFormat('Y-m-d H:i') }}</p>
            <p><strong>آخر تعديل:</strong> {{ $user->updated_at->translatedFormat('Y-m-d H:i') }}</p>

        </div>
    </div>
</div>
@endsection
