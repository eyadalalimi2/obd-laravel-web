<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'logo_path',
        'site_name',
        'site_description',
    ];

    // إذا أردنا التعامل مع JSON كصفائف PHP تلقائياً:
    protected $casts = [
        'site_name'        => 'array',
        'site_description' => 'array',
    ];
}
