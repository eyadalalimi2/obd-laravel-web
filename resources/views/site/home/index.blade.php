@extends('site.layouts.site')

@section('content')
    {{-- Hero Section --}}
    <section class="text-center py-5 bg-light border-bottom">
        @if($site_logo)
            <img src="{{ asset('storage/' . $site_logo) }}" alt="{{ $site_name }}" class="mb-3" style="max-height: 110px;">
        @endif
        <h1 class="display-5 fw-bold mb-3">{{ $site_name }}</h1>
        <p class="lead mb-4">{{ $site_description }}</p>
        <a href="{{ route('site.codes') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow">
            {{ __('site.start_search') }}
        </a>
    </section>

    {{-- بطاقات مدمجة اللون --}}
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row text-center justify-content-center g-4">
                <div class="col-md-4">
                    <div class="card shadow border-0 rounded-4 h-100"
                        style="background: linear-gradient(135deg,#1976d2 70%,#90caf9 100%);color:#fff">
                        <div class="card-body p-4">
                            <img src="{{ asset('icons/diagnose.jbg') }}" alt="" height="38" class="mb-3">
                            <h5 class="fw-bold mb-2">تشخيص ذكي</h5>
                            <p class="mb-0">تفسير احترافي لأكواد أعطال السيارات وحلول عملية مفصلة.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0 rounded-4 h-100"
                        style="background: linear-gradient(135deg,#388e3c 70%,#a5d6a7 100%);color:#fff">
                        <div class="card-body p-4">
                            <img src="{{ asset('icons/online.jbg') }}" alt="" height="38" class="mb-3">
                            <h5 class="fw-bold mb-2">اتصال حي بالسيارة</h5>
                            <p class="mb-0">قراءة بيانات السيارة مباشر ودعم أجهزة OBD-II الحديثة.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0 rounded-4 h-100"
                        style="background: linear-gradient(135deg,#ffa000 70%,#ffe082 100%);color:#fff">
                        <div class="card-body p-4">
                            <img src="{{ asset('icons/report.jbg') }}" alt="" height="38" class="mb-3">
                            <h5 class="fw-bold mb-2">حفظ ومشاركة</h5>
                            <p class="mb-0">حفظ تقارير الفحص ومشاركتها مع المختصين أو للأرشفة الدائمة.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- قسم تحميل التطبيق --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-md-6 text-center text-md-end" data-aos="fade-left">
                    <img src="{{ asset('icons/app-mobile.jpg') }}" alt="OBD App" style="height:160px;">
                </div>
                <div class="col-md-6 text-center text-md-start" data-aos="fade-right">
                    <h3 class="fw-bold mb-2">حمّل تطبيق OBD الآن!</h3>
                    <p class="text-muted mb-4">احصل على كافة مزايا المنصة على هاتفك (أندرويد وآيفون).</p>
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-start">
                        <a href="https://play.google.com/store/apps/details?id=YOUR_ID" target="_blank">
                            <img src="{{ asset('icons/google-play-badge.svg') }}" alt="Google Play" height="48">
                        </a>
                        <a href="https://apps.apple.com/app/idYOUR_ID" target="_blank">
                            <img src="{{ asset('icons/app-store-badge.svg') }}" alt="App Store" height="48">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- قسم آراء العملاء (اختياري) --}}
    <section class="py-5 bg-white">
        <div class="container">
            <h4 class="fw-bold text-center mb-4">ماذا قال مستخدمونا؟</h4>
            <div class="row justify-content-center g-3">
                <div class="col-md-4">
                    <div class="shadow-sm rounded-4 bg-light p-3 h-100">
                        <p class="mb-1">"تجربة رائعة، وفرت لي الوقت والجهد في تشخيص العطل!"</p>
                        <small class="text-muted">ـ أحمد (صنعاء)</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="shadow-sm rounded-4 bg-light p-3 h-100">
                        <p class="mb-1">"أدق منصة يمنية لشرح أكواد السيارات."</p>
                        <small class="text-muted">ـ ريم (عدن)</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- قسم إحصائيات وميزات إضافية (اختياري) --}}
    <section class="py-5 bg-light">
        <div class="container text-center">
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <h2 class="fw-bold text-primary mb-0">+10K</h2>
                    <div class="text-muted">رمز تم تحليله</div>
                </div>
                <div class="col-6 col-md-3">
                    <h2 class="fw-bold text-success mb-0">+5K</h2>
                    <div class="text-muted">عميل سعيد</div>
                </div>
                <div class="col-6 col-md-3">
                    <h2 class="fw-bold text-warning mb-0">+100</h2>
                    <div class="text-muted">تقرير جديد يوميًا</div>
                </div>
                <div class="col-6 col-md-3">
                    <h2 class="fw-bold text-info mb-0">24/7</h2>
                    <div class="text-muted">دعم مباشر</div>
                </div>
            </div>
        </div>
    </section>
@endsection