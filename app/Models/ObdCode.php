<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ObdCodeTranslation;
use App\Models\Brand;

class ObdCode extends Model
{
    // إذا كان اسم الجدول مختلفًا عدِّله هنا، وإلا لا حاجة لتعريفه
    // protected $table = 'obd_codes';

    protected $fillable = [
        'code',
        'type',
        'brand_id',
        'title',
        'description',
        'symptoms',
        'causes',
        'diagnosis',
        'severity',
        'solutions',
        'status',
        'source_url',
        'lang',
        'image',
        'embedding',
    ];

    protected $casts = [
        'embedding' => 'array',
    ];

    /**
     * علاقات الترجمة المرتبطة بهذا الكود.
     */
    public function translations()
    {
        return $this->hasMany(ObdCodeTranslation::class, 'obd_code_id');
    }

    /**
     * علاقة الماركة (Brand).
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
