<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'category',
    ];

    public $timestamps = true;
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_code', 'code');
    }
}
