@extends('admin.layouts.admin')

@section('title', 'لوحة التحكم الرئيسية')

@push('styles')
<style>
/* تحسين بطاقات الإحصائيات */
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

/* نضمن أن جميع البطاقات فيها transition حتى بدون hover */
.card {
    transition: all 0.3s ease;
}
</style>
@endpush

@section('content')
<div class="container-fluid" style="direction: rtl;">

    <!-- الصف الأول: إحصائيات عامة -->
    <div class="row">
        @foreach([
            ['label' => 'عدد المستخدمين', 'value' => $usersCount, 'gradient' => '135deg, #667eea, #764ba2'],
            ['label' => 'عدد المقالات', 'value' => $postsCount, 'gradient' => '135deg, #ff7e5f, #feb47b'],
            ['label' => 'عدد أكواد الأعطال', 'value' => $obdCodesCount, 'gradient' => '135deg, #43cea2, #185a9d'],
            ['label' => 'عدد الصفحات الثابتة', 'value' => $pagesCount, 'gradient' => '135deg, #ff512f, #dd2476'],
        ] as $item)
            <div class="col-md-3 mb-4">
                <div class="card text-white shadow-sm" style="background: linear-gradient({{ $item['gradient'] }}); border: none; border-radius: 12px;">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-2">{{ $item['label'] }}</h5>
                        <h2>{{ $item['value'] }}</h2>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- صف إحصائيات الاشتراكات -->
    <div class="row">
        @foreach([
            ['label' => 'إجمالي الباقات', 'value' => $totalPlans, 'gradient' => '135deg, #4e54c8, #8f94fb'],
            ['label' => 'الاشتراكات النشطة', 'value' => $activeSubscriptions, 'gradient' => '135deg, #11998e, #38ef7d'],
            ['label' => 'جديدة هذا الشهر', 'value' => $newThisMonth, 'gradient' => '135deg, #ff416c, #ff4b2b'],
            ['label' => 'إجمالي الإيرادات', 'value' => number_format($totalRevenue, 2) . ' د.إ.', 'gradient' => '135deg, #f7971e, #ffd200'],
        ] as $item)
            <div class="col-md-3 mb-4">
                <div class="card text-white shadow-sm" style="background: linear-gradient({{ $item['gradient'] }}); border: none; border-radius: 12px;">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-2">{{ $item['label'] }}</h5>
                        <h2>{{ $item['value'] }}</h2>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- أكواد الأعطال العامة حسب الفئة -->
    <div class="row">
        @foreach($counts as $category => $count)
            <div class="col-md-3 mb-4">
                <div class="card text-white shadow-sm" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none; border-radius: 12px;">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-2">عدد الأكواد في الفئة {{ $category }}</h5>
                        <h2>{{ $count }}</h2>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- أكواد الأعطال الخاصة حسب الفئة -->
    <div class="row">
        @foreach($manufacturerCounts as $category => $count)
            <div class="col-md-3 mb-4">
                <div class="card text-white shadow-sm" style="background: linear-gradient(135deg, #ff512f, #dd2476); border: none; border-radius: 12px;">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-2">عدد الأكواد الخاصة {{ $category }}</h5>
                        <h2>{{ $count }}</h2>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- سجل الأنشطة -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">آخر العمليات</h5>
        </div>
        <div class="card-body">
            @if($recentActivities->count() > 0)
                <ul class="list-group">
                    @foreach($recentActivities as $activity)
                        <li class="list-group-item">
                            <span class="text-muted">{{ $activity->created_at->format('Y-m-d H:i') }}</span> - {{ $activity->description }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted mb-0">لا توجد أنشطة بعد.</p>
            @endif
        </div>
    </div>

</div>
@endsection
