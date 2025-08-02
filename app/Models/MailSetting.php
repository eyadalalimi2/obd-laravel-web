<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    // اسم الجدول إذا اختلف عن الاسم الافتراضي
    protected $table = 'mail_settings';

    // الحقول القابلة للتعبئة
    protected $fillable = [
        'mailer',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'from_address',
        'from_name',
    ];

    // إذا أردت استخدام خاصية timestamps
    public $timestamps = true;
}