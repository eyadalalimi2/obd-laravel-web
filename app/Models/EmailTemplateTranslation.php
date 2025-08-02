<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailTemplateTranslation extends Model
{
    use HasFactory;

    protected $table = 'email_template_translations';

    protected $fillable = [
        'email_template_id',
        'locale',
        'subject',
        'body',
        'placeholders',
    ];

    protected $casts = [
        'placeholders' => 'array',
    ];

    /**
     * القالب الأصلي الذي تنتمي إليه هذه الترجمة.
     */
    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'email_template_id');
    }
}