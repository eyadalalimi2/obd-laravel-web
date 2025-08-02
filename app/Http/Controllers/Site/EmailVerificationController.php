<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use App\Models\User;

class EmailVerificationController extends Controller
{
    /**
     * عرض صفحة التفعيل مع زرّ واحد.
     */
    public function show(Request $request, $id, $hash)
    {
        // عرض الصفحة بلا رسالة في البداية
        return view('auth.verify-email', [
            'id'   => $id,
            'hash' => $hash,
        ]);
    }

    public function verify(Request $request, $id, $hash)
    {
        // تحقق من صلاحية التوقيع
        if (! $request->hasValidSignature()) {
            $msg = 'الرابط غير صالح أو منتهي الصلاحية.';
        } elseif (
            ! $user = \App\Models\User::find($id)
            or ! hash_equals((string)$hash, sha1($user->email))
        ) {
            $msg = 'الرابط غير صحيح.';
        } elseif ($user->hasVerifiedEmail()) {
            $msg = 'تم التفعيل سابقاً.';
        } else {
            $user->markEmailAsVerified();
            event(new \Illuminate\Auth\Events\Verified($user));
            $msg = 'تم تفعيل بريدك الإلكتروني بنجاح.';
        }

        return view('auth.verify-email', [
            'id'      => $id,
            'hash'    => $hash,
            'message' => $msg,
        ]);
    }
}
