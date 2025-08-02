<?php

namespace App\Services;

use App\Models\MailSetting;

class MailSettingService
{
    /**
     * إرجاع قيمة الإعداد حسب المفتاح
     */
    public function get(string $key): ?string
    {
        $settings = MailSetting::first();
        return $settings ? $settings->{$key} : null;
    }

    /**
     * إرجاع جميع الإعدادات كمصفوفة
     */
    public function all(): array
    {
        $settings = MailSetting::first();
        return $settings ? $settings->toArray() : [];
    }
}