<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'duration_days',
        'features_json',
        'is_active',
    ];

    protected $casts = [
        'price'         => 'decimal:2',
        'duration_days' => 'integer',
        'features_json' => 'array',
        'is_active'     => 'boolean',
    ];

    /**
     * باقات التفعيل المرتبطة
     */
    public function activationCodes()
    {
        return $this->hasMany(ActivationCode::class);
    }

    /**
     * اشتراكات المستخدمين المرتبطة
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
