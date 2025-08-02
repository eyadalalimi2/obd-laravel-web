<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Notifications\VerifyEmailNotification;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'بيانات الدخول غير صحيحة'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('app_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => $user
        ]);
    }

    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'username' => 'required|string|max:255|unique:users',
        'email'    => 'required|string|email|max:255|unique:users',
        'phone'    => 'nullable|string|unique:users',
        'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // 1. إنشاء المستخدم
    $user = User::create([
        'username' => $request->username,
        'email'    => $request->email,
        'phone'    => $request->phone,
        'password' => Hash::make($request->password),
    ]);

    // 2. إرسال رسالة التفعيل
    $user->notify(new VerifyEmailNotification());

    // 3. توليد التوكن ورجعه
    $token = $user->createToken('app_token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => $user
    ], 201);
}


    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }

   /**
     * تحديث البيانات النصّية فقط
     */
    public function updateProfileData(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'username'  => ['required','string','max:255', Rule::unique('users','username')->ignore($user->id)],
            'email'     => ['required','email','max:255',    Rule::unique('users','email')->ignore($user->id)],
            'phone'     => ['nullable','string','max:255'],
            'job_title' => ['nullable','string','max:255'],
        ]);

        $user->update($data);

        return response()->json([
            'message' => __('تم تحديث البيانات بنجاح'),
            'user'    => $user,
        ]);
    }

    /**
     * رفع صورة الملفّ الشخصي فقط
     */
    public function updateProfileAvatar(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'profile_image' => ['required','image','max:2048'],
        ]);

        // احذف الصورة القديمة (إن وُجدت)
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $path = $request->file('profile_image')
                        ->store('avatars','public');

        $user->update(['profile_image' => $path]);

        return response()->json([
            'message' => __('تم رفع الصورة بنجاح'),
            'user'    => $user,
        ]);
    }



    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'تم تسجيل الخروج بنجاح']);
    }
    public function destroy(Request $request)
    {
        $user = Auth::user();

        $user->tokens()->delete();

        $user->delete();

        return response()->json(['message' => 'تم حذف الحساب بنجاح']);
    }
    /**
     * 1. إرسال رابط إعادة ضبط كلمة المرور
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 500);
    }

    /**
     * 2. إعادة تعيين كلمة المرور باستخدام التوكن
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'                 => ['required', 'email', 'exists:users,email'],
            'token'                 => ['required', 'string'],
            'password'              => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 500);
    }
}
