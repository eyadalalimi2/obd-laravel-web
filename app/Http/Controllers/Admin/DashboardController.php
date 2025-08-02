<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Post;
use App\Models\Page;
use App\Models\ObdCode;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Payment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // الفئات المستخدمة لعد الأكواد
        $categories = ['P', 'C', 'B', 'U'];

        // عد الأكواد العامة حسب الفئة
        $counts = collect($categories)->mapWithKeys(function ($cat) {
            return [$cat => ObdCode::where('category', $cat)->count()];
        });

        // عد الأكواد الخاصة (manufacturer) حسب الفئة
        $manufacturerCounts = collect($categories)->mapWithKeys(function ($cat) {
            return [$cat => ObdCode::where('type', 'manufacturer')
                                 ->where('category', $cat)
                                 ->count()];
        });

        // إحصائيات الخطط والاشتراكات
        $totalPlans = Plan::count();
        $activeSubscriptions = Subscription::where('status', 'active')->count();

        // حساب بداية الشهر بناءً على المنطقة الزمنية للتطبيق
        $now = Carbon::now(config('app.timezone'));
        $startOfMonth = $now->copy()->startOfMonth();
        $newThisMonth = Subscription::where('start_at', '>=', $startOfMonth)->count();

        // إجمالي الإيرادات من المدفوعات المكتملة
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');

        return view('admin.dashboard', [
            'usersCount'           => User::count(),
            'postsCount'           => Post::count(),
            'obdCodesCount'        => ObdCode::count(),
            'pagesCount'           => Page::count(),
            'recentActivities'     => ActivityLog::latest()->limit(5)->get(),

            'counts'               => $counts,
            'manufacturerCounts'   => $manufacturerCounts,

            'totalPlans'           => $totalPlans,
            'activeSubscriptions'  => $activeSubscriptions,
            'newThisMonth'         => $newThisMonth,
            'totalRevenue'         => $totalRevenue,
        ]);
    }
}
