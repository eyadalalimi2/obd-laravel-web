<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdsSetting;

class AdsSettingController extends Controller
{
    public function index()
    {
        $settings = AdsSetting::firstOrCreate([], [
            'is_enabled' => false,
            'head_script' => '',
            'body_script' => '',
        ]);

        return view('admin.ads_settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'is_enabled' => 'required|boolean',
            'head_script' => 'nullable|string',
            'body_script' => 'nullable|string',
        ]);

        $settings = AdsSetting::first();
        $settings->update($request->only(['is_enabled', 'head_script', 'body_script']));

        return redirect()->back()->with('success', 'تم تحديث إعدادات الإعلانات بنجاح.');
    }
}
