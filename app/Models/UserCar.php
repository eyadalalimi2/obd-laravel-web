<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCar extends Model
{
    protected $table = 'user_cars';

    protected $fillable = [
        'user_id',
        'brand_id',
        'model_id',
        'year',
        'car_name', // اسم اختياري يضيفه المستخدم مثلاً "سيارة العمل"
    ];

    // علاقة المستخدم
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // علاقة الشركة المصنعة
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    // علاقة الموديل
    public function model(): BelongsTo
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }
}
