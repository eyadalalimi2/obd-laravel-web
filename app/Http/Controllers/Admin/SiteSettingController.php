<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $settings = SiteSetting::first(); // أو أنشئ سجلًا افتراضيًا مسبقًا
        return view('admin.site_settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name.en'        => 'required|string|max:100',
            'site_name.ar'        => 'required|string|max:100',
            'site_description.en' => 'required|string|max:255',
            'site_description.ar' => 'required|string|max:255',
            'logo'                => 'nullable|image|mimes:jpg,png,svg|max:2048',
        ]);

        $settings = SiteSetting::firstOrCreate([]);

        // رفع الشعار إذا تم إرساله
        if ($request->hasFile('logo')) {
            // احذف القديم إن وجد
            if ($settings->logo_path) {
                Storage::disk('public')->delete($settings->logo_path);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $settings->logo_path = $path;
        }

        // خزّن الأسماء والوصف كـ array
        $settings->site_name        = $data['site_name'];
        $settings->site_description = $data['site_description'];

        $settings->save();

        return redirect()->route('admin.site-settings.edit')
                         ->with('success', 'تم تحديث إعدادات الموقع بنجاح');
    }
}
