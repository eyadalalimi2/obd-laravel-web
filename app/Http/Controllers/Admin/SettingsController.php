<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token']);

        foreach ($data as $key => $value) {
            $setting = Setting::firstOrNew(['key' => $key]);

            // إذا كان نوع الإعداد "صورة"
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = $file->store('settings', 'public');
                $setting->value = $path;
                $setting->type = 'image';
            } else {
                $setting->value = $value;
                if (!$setting->type) {
                    $setting->type = 'text';
                }
            }

            $setting->save();
        }

        return redirect()->back()->with('success', 'تم تحديث الإعدادات بنجاح.');
    }
}
