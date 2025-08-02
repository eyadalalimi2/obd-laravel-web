<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivationCode;
use App\Models\Subscription;
use App\Models\Plan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    // 1) تفعيل برمز من لوحة التحكم
    public function activateByCode(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|exists:activation_codes,code',
        ]);

        $code = ActivationCode::where('code', $data['code'])->first();
        if ($code->expires_at && Carbon::now()->gt($code->expires_at)) {
            return response()->json(['error' => 'الرمز منتهي الصلاحية'], 422);
        }
        if ($code->uses_left < 1) {
            return response()->json(['error' => 'الرمز استُهلك بالكامل'], 422);
        }

        // إنشاء الاشتراك
        $sub = Subscription::create([
            'user_id'   => $request->user()->id,
            'plan_id'   => $code->plan_id,
            'start_at'  => now(),
            'end_at'    => now()->addDays($code->plan->duration_days),
            'status'    => 'active',
            'platform'  => 'manual_code',
            'txn_token' => $code->code,
        ]);

        $code->decrement('uses_left');

        return response()->json($sub, 201);
    }

    // 2) عملية الشراء عن طريق توكن
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'plan_id'       => 'required|exists:plans,id',
            'purchase_token' => 'required|string',
            'platform'      => 'required|string|in:play_store,app_store,stripe',
        ]);

        // TODO: التحقق من صحة التوكن مع المزود (Play/App/Stripe)

        $plan = Plan::findOrFail($data['plan_id']);
        $sub = Subscription::create([
            'user_id'   => $request->user()->id,
            'plan_id'   => $plan->id,
            'start_at'  => now(),
            'end_at'    => now()->addDays($plan->duration_days),
            'status'    => 'active',
            'platform'  => $data['platform'],
            'txn_token' => $data['purchase_token'],
        ]);

        return response()->json($sub, 201);
    }

    // 3) جلب حالة الاشتراك الحالية
    public function status(Request $request)
{
    $sub = Subscription::where('user_id', $request->user()->id)
        ->where('status', 'active')
        ->latest('end_at')
        ->first();

    if (! $sub) {
        return response()->json(['status' => 'none'], 200);
    }

    // جلب ميزات الباقة من الـ plan مباشرة
    $features = $sub->plan->features_json ?? [];

    return response()->json([
        'plan'      => $sub->plan->only(['id', 'name', 'duration_days']),
        'features'  => $features,
        'start_at'  => $sub->start_at,
        'end_at'    => $sub->end_at,
        'status'    => $sub->status,
    ]);
}

    public function renew(Request $request)
    {
        $data = $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $user = $request->user();
        $plan = Plan::findOrFail($data['plan_id']);

        // إنهاء الاشتراك الحالي إن وُجد
        Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        // إنشاء اشتراك جديد
        $sub = Subscription::create([
            'user_id'   => $user->id,
            'plan_id'   => $plan->id,
            'start_at'  => now(),
            'end_at'    => now()->addDays($plan->duration_days),
            'status'    => 'active',
            'platform'  => 'manual_renew',
            'txn_token' => 'RENEW-' . strtoupper(uniqid()),
        ]);

        return response()->json([
            'plan'     => $sub->plan->only(['id', 'name', 'duration_days']),
            'start_at' => $sub->start_at,
            'end_at'   => $sub->end_at,
            'status'   => $sub->status,
        ]);
    }

    // 5) إلغاء الاشتراك الحالي
    public function cancel(Request $request)
    {
        $user = $request->user();

        $current = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->latest('end_at')
            ->first();

        if (! $current) {
            return response()->json(['error' => 'لا يوجد اشتراك حالي لإلغائه'], 422);
        }

        $current->status = 'cancelled';
        $current->save();

        return response()->json(['message' => 'تم إلغاء الاشتراك الحالي بنجاح']);
    }
}
