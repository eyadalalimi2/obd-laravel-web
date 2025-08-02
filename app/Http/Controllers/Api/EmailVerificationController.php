<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use App\Notifications\VerifyEmailNotification;

class EmailVerificationController extends Controller
{
    // 1. التحقُّق عبر الرابط الموقّع
    public function verify(Request $request, $id, $hash)
    {
        if (! $request->hasValidSignature()) {
            return response()->json(['message' => 'الرابط غير صالح أو منتهي الصلاحية.'], 403);
        }

        $user = \App\Models\User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->email))) {
            return response()->json(['message' => 'الرابط غير صحيح.'], 403);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'تم التحقق من البريد سابقًا.'], 200);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json(['message' => 'تم التحقق من بريدك الإلكتروني بنجاح.'], 200);
    }

    // 2. إعادة إرسال رابط التحقق
    public function resend(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'البريد مُفَعَّل بالفعل.'], 200);
        }

        $user->notify(new VerifyEmailNotification());

        return response()->json(['message' => 'أرسلنا رابط التحقق إلى بريدك الإلكتروني مرة أخرى.'], 200);
    }
      // 3. حالة التحقق (الجديد)
    public function status(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'verified'            => $user->hasVerifiedEmail(),
            'email_verified_at'   => $user->email_verified_at,
        ], 200);
    }
}
