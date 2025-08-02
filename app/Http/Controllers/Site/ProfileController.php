<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = auth()->user();
        return view('site.profile.show', compact('user'));
    }

    public function edit(): View
    {
        $user = auth()->user();
        return view('site.profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $data = $request->validated();

        // 1. رفع صورة الملف الشخصي
        if ($request->hasFile('profile_image')) {
            // حذف القديمة إن وجدت
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $data['profile_image'] = $request
                ->file('profile_image')
                ->store('profile_images', 'public');
        }

        // 2. تجزئة كلمة المرور إن تم إدخالها
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('profile.show')
            ->with('success', __('site.profile_updated'));
    }
}