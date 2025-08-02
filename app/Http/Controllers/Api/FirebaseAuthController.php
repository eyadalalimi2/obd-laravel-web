<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth as FirebaseAuth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class FirebaseAuthController extends Controller
{
    protected $firebase;

    public function __construct(FirebaseAuth $firebase)
    {
        $this->firebase = $firebase;
    }

    public function authenticate(Request $request)
    {
        try {
            $idToken = $request->bearerToken();

            if (!$idToken) {
                return response()->json(['message' => 'Missing ID Token'], 401);
            }

            $verifiedIdToken = $this->firebase->verifyIdToken($idToken);
            $uid = $verifiedIdToken->claims()->get('sub');
            $firebaseUser = $this->firebase->getUser($uid);

            $user = User::where('firebase_uid', $uid)->first();

            if (!$user) {
                // إنشاء مستخدم جديد بناءً على بيانات Firebase
                $user = User::create([
                    'name' => $firebaseUser->displayName ?? 'User',
                    'email' => $firebaseUser->email ?? $uid.'@firebase.local',
                    'firebase_uid' => $uid,
                    'password' => Hash::make(uniqid()), // كلمة مرور وهمية
                ]);
            }

            // تسجيل الدخول باستخدام Laravel
            Auth::login($user);

            return response()->json([
                'message' => 'تم التحقق بنجاح',
                'user' => $user,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'فشل التحقق: ' . $e->getMessage()
            ], 401);
        }
    }
}
