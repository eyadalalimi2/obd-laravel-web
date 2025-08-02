<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['user','plan'])->paginate(15);
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function show(Subscription $subscription)
    {
        return view('admin.subscriptions.show', compact('subscription'));
    }

    public function create()
    {
        $users = User::all();
        $plans = Plan::where('is_active', true)->get();
        return view('admin.subscriptions.create', compact('users','plans'));
    }

    public function store(SubscriptionRequest $request)
    {
        Subscription::create($request->validated());
        return redirect()->route('admin.subscriptions.index')
                         ->with('success', 'تم إضافة الاشتراك يدوياً.');
    }

    public function edit(Subscription $subscription)
    {
        $users = User::all();
        $plans = Plan::where('is_active', true)->get();
        return view('admin.subscriptions.edit', compact('subscription','users','plans'));
    }

    public function update(SubscriptionRequest $request, Subscription $subscription)
    {
        $subscription->update($request->validated());
        return redirect()->route('admin.subscriptions.index')
                         ->with('success', 'تم تحديث الاشتراك.');
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return redirect()->route('admin.subscriptions.index')
                         ->with('success', 'تم حذف الاشتراك.');
    }
    /**
     * إلغاء الاشتراك
     */
    public function cancel(Subscription $subscription)
    {
        $subscription->update([
            'status' => 'canceled',
        ]);

        return redirect()
            ->route('admin.subscriptions.index')
            ->with('success', 'تم إلغاء الاشتراك بنجاح.');
    }

    /**
     * تجديد الاشتراك بناءً على مدة الخطة
     */
    public function renew(Subscription $subscription)
    {
        $plan = $subscription->plan;
        // نأخذ الـ end_at الحالي إذا كان في المستقبل، وإلا الآن
        $base = Carbon::parse($subscription->end_at)->isFuture()
            ? Carbon::parse($subscription->end_at)
            : Carbon::now();

        $newEnd = $base->copy()->addDays($plan->duration_days);

        $subscription->update([
            'start_at' => Carbon::now(),
            'end_at'   => $newEnd,
            'status'   => 'active',
        ]);

        return redirect()
            ->route('admin.subscriptions.index')
            ->with('success', 'تم تجديد الاشتراك بنجاح.');
    }
}
