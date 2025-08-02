<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{
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
}
