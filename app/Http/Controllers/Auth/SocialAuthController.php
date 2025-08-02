<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    // إعادة التوجيه إلى مزود الخدمة
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // استقبال رد المزود
    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'password' => bcrypt(Str::random(24)),
            ]
        );

        Auth::login($user);

        return redirect()->route('site.home.index'); // أو أي صفحة تريدها
    }
}
