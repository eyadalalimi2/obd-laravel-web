<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ObdCodeTranslation;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function translations()
    {
        return $this->hasMany(ObdCodeTranslation::class, 'language_code', 'code');
    }
    public function faqs()
{
    return $this->hasMany(Faq::class, 'language_code', 'code');
}

public function pages()
{
    return $this->hasMany(Page::class, 'language_code', 'code');
}

}
