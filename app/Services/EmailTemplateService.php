<?php

namespace App\Services;

use App\Models\EmailTemplate;

class EmailTemplateService
{
    /**
     * @param  string  $key       // مفتاح القالب، مثل 'password_reset'
     * @param  array   $data      // بيانات التعويض في body/subject
     * @return array              // ['subject'=>..., 'body'=>...]
     */
    public static function render(string $key, array $data): array
    {
        $locale   = app()->getLocale();
        $template = EmailTemplate::where('key', $key)
                      ->with('translations')
                      ->firstOrFail();

        $trans    = $template->translation($locale);
        $subject  = $trans->subject ?? $template->subject;
        $body     = $trans->body    ?? $template->body;

        foreach (($trans->placeholders ?? $template->placeholders) as $ph) {
            $value   = $data[$ph] ?? '';
            $subject = str_replace("{{{$ph}}}", $value, $subject);
            $body    = str_replace("{{{$ph}}}", $value, $body);
        }

        return compact('subject','body');
    }
}
