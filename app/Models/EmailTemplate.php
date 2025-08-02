<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $table = 'email_templates';

    protected $fillable = [
        'key',
        'subject',
        'body',
        'placeholders',
    ];

    protected $casts = [
        'placeholders' => 'array',
    ];

    /**
     * كل الترجمات المرتبطة بهذا القالب.
     */
    public function translations()
    {
        return $this->hasMany(EmailTemplateTranslation::class, 'email_template_id');
    }

    /**
     * ترجمة القالب للغـة المحددة، أو اللغة الحالية للتطبيق.
     */
    public function translation(string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->translations
                    ->where('locale', $locale)
                    ->first()
            ?? $this->translations->first();
    }
}