<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Kreait\Firebase\Auth as FirebaseAuth;

class AuthController extends Controller
{
    protected FirebaseAuth $firebaseAuth;

    public function __construct(FirebaseAuth $firebaseAuth)
    {
        $this->firebaseAuth = $firebaseAuth;
    }

    public function loginForm()
    {
        return view('site.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role == 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => __('site.invalid_credentials')]);
            }

            return redirect()->route('site.home');
        }

        return back()->withErrors(['email' => __('site.invalid_credentials')]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'username' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('site.home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('site.home');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'username' => $socialUser->getName() ?? $socialUser->getNickname(),
                'password' => Hash::make(uniqid()),
                'role' => 'user',
            ]
        );

        Auth::login($user);

        return redirect()->route('site.home');
    }

    /**
     * تسجيل الدخول باستخدام Firebase ID Token
     */
    public function firebaseAuth(Request $request)
    {
        try {
            $idToken = $request->bearerToken();

            if (!$idToken) {
                return response()->json(['message' => 'Missing ID token'], 401);
            }

            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idToken);
            $uid = $verifiedIdToken->claims()->get('sub');
            $firebaseUser = $this->firebaseAuth->getUser($uid);

            $user = User::where('firebase_uid', $uid)->first();

            if (!$user) {
                $user = User::create([
                    'firebase_uid' => $uid,
                    'username'     => $firebaseUser->displayName ?? 'User',
                    'email'        => $firebaseUser->email ?? uniqid() . '@firebase.local',
                    'password'     => bcrypt(uniqid()),
                    'role'         => 'user',
                ]);
            }

            Auth::login($user);

            return response()->json(['message' => 'Authenticated'], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Firebase authentication failed',
                'error'   => $e->getMessage()
            ], 401);
        }
    }
}
