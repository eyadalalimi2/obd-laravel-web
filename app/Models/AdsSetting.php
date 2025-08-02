<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdsSetting extends Model
{
    protected $fillable = [
        'is_enabled',
        'head_script',
        'body_script',
    ];
}
