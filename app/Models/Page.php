<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
    ];

    public $timestamps = true;
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_code', 'code');
    }
}
