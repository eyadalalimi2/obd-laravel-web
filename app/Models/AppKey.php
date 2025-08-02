<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppKey extends Model
{
    protected $fillable = [
        'package_name', 'version_code', 'encryption_key', 'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
