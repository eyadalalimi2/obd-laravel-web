<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MailSetting;
use Illuminate\Support\Facades\Artisan;

class MailSettingsController extends Controller
{
    /**
     * عرض نموذج تعديل إعدادات البريد
     */
    public function edit()
    {
        $settings = MailSetting::first();
        return view('admin.mail_settings.edit', compact('settings'));
    }

    /**
     * حفظ أو تحديث إعدادات البريد
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'host'         => 'required|string',
            'port'         => 'required|integer',
            'username'     => 'required|string',
            'password'     => 'required|string',
            'encryption'   => 'nullable|string',
            'from_address' => 'required|email',
            'from_name'    => 'required|string',
            'mailer'       => 'required|string',
        ]);

        MailSetting::updateOrCreate(['id' => 1], $data);

        // مسح الكاش لإعادة تحميل الإعدادات
        Artisan::call('config:clear');

        return redirect()
            ->route('admin.mail.edit')
            ->with('success', 'تم حفظ إعدادات البريد بنجاح.');
    }
}
