<?php

namespace App\Services;

use App\Models\ObdCode;
use App\Models\ObdCodeTranslation;

class BlogPostGenerator
{
    /**
     * توليد محتوى HTML بناءً على كود العطل واللغة.
     */
    public function generate(ObdCode $code, ?ObdCodeTranslation $translation): string
    {
        $title = $translation?->title ?? $code->code;
        $description = $translation?->description ?? 'لا يوجد وصف متاح.';
        $symptoms = $translation?->symptoms ?? 'لم يتم تحديد الأعراض.';
        $causes = $translation?->causes ?? 'لم يتم تحديد الأسباب.';
        $solution = $translation?->solution ?? 'لم يتم تحديد الحلول.';

        $html = "<h2>{$title}</h2>";
        $html .= "<p><strong>الوصف:</strong> {$description}</p>";
        $html .= "<h3>الأعراض المحتملة</h3><p>{$symptoms}</p>";
        $html .= "<h3>الأسباب المحتملة</h3><p>{$causes}</p>";
        $html .= "<h3>الحلول المقترحة</h3><p>{$solution}</p>";

        return $html;
    }
}
